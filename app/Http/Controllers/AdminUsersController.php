<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Photo;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
//        $roles = Role::lists('name', 'id')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if(trim($request->password) == ""){
            $input = $request->except('password');
        }else{
            $input = $request->all();
        }
//        $user['password'] = bcrypt($user['password']);
//        $new_user_id = User::latest()->first()->id + 1; //NOT a great idea
        $user = User::create($input);

        if($photo = $request->file('file')){
            $photo_name = $user['name'] . $photo->getClientOriginalName();
            $photo->move('images', $photo_name);
//            Photo::create(['user_id'=>$user->id, 'file'=>'images/' . $photo_name]);
            $user->photos()->create(['file'=>$photo_name]); //user after been created above, have id
        }



        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if(trim($request->password) == ""){
            $input = $request->except('password');
        }else{
            $input = $request->all();
        }
//        $input = $request->all();
//        $input['password'] = bcrypt($input['password']); //this is done from the mutator
        $user->update($input);

        if($photo = $request->file('file')){
            $photo_name = $user['name'] . $photo->getClientOriginalName();
            if(in_array($photo->getClientOriginalExtension(),['jpg','png','bmp'])){
                if($photo->getClientSize() < 1100000) {
                    $photo->move('images', $photo_name);
                    $user->photos()->where('user_id', $user->id)->updateOrCreate(['user_id' => $user->id], ['file' => $photo_name]);
                }else{
                    return "File size over 1Mb";
                }
            }else{
                return "File is not Image";
            }
        }

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user_name = $user->name;
        foreach ($user->photos as $photo) {
            if(file_exists(str_replace('\\', '/', public_path()) . $photo->file)) {
                //Use sre_replace because public_path returns slashes - not for Windows
                unlink(str_replace('\\', '/', public_path()) . $photo->file);
            }
        }
        if($user->photos()) {
            $user->photos()->delete();
        }
        $user->delete();

        //Flashing information
        //$request->session ili moze session()...
        Session::flash('deleted_user', "The user $user_name has been deleted!");

        return redirect('admin/users');
    }
}
