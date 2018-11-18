<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Post;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.posts.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $input['user_id'] = Auth::id();

        if($photo = $request->file('photo_id')){
         $photo_name = "post_image_" . time() . "." . $photo->getClientOriginalExtension();
         $photo->move('images', $photo_name);
         $pic = Photo::create(['file'=>$photo_name]);
         $input['photo_id']=$pic['id'];
        }

        Post::create($input);
        //or if we use $user=Auth::user(), we can: $user->posts()->create($input)
        return redirect('admin/posts');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $roles = Role::all();

        return view('admin.posts.edit', compact('post', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $input = $request->all();
        $input['user_id'] = Auth::id();

        if($photo = $request->file('photo_id')) {
            $photo_name = "post_id_" . $id . "_image." . $photo->getClientOriginalExtension();
            $photo->move('images', $photo_name);
//            $pic = Photo::findOrFail($post->photo_id);
//            $pic->update(['file' => $photo_name]);
            $pic = Photo::create(['file' => $photo_name]);
            $input['photo_id'] = $pic['id'];

            //delete existing post picture
            if ($post->photo) {
                if (file_exists(str_replace('\\', '/', public_path()) . $post->photo->file)) {
                    //Use str_replace because public_path returns slashes - not for Windows
                    unlink(str_replace('\\', '/', public_path()) . $post->photo->file);
                }
                $post->photo()->delete();
            }
        }

        $post->update($input);

        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id == Auth::user()->id) {
            if ($post->photo) {
                if (file_exists(str_replace('\\', '/', public_path()) . $post->photo->file)) {
                    //Use str_replace because public_path returns slashes - not for Windows
                    unlink(str_replace('\\', '/', public_path()) . $post->photo->file);
                }
                $post->photo()->delete();
            }
            $post->delete();
            Session::flash('deleted_post', 'The post has been deleted.');
        }else{
            Session::flash('deleted_post', 'The post can not be deleted.');
        }
        return redirect('admin/posts');
    }
}
