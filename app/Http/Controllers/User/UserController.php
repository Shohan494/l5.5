<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        //return response()->json(['data' => $users], 200);
        //return $users;
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);
        
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generate_token();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        //return response()->json(['data' => $user], 201);
        return $this->showOne($user, 201);
        // 201 was different, for create 
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
        return $this->showOne($user);
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
        $user = User::findOrFail($id);

        $rules = [ 
            'email' => 'required|email|unique:users,' . $user->id,
            'password' => 'required|min:6|confirmed',
            'admin' => 'in:' . User::REGULAR_USER . ',' . User::ADMIN_USER,
        ];

        if($request->has('name'))
        {
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email)
        {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generate_token();
            $user->email = $request->email;
        }
        if($request->has('password'))
        {
            $user->password = bcrypt($request->password);
        }
        if($request->has('admin'))
        {
            if(!$user->isVerified())
            {
                return $this->errorResponce('user is not verified', 409); 
            }

            $user->admin = $request->admin;
        }
        if(!$user->isDirty())
        {
            return $this->errorResponce('specify different value to update', 422);
            $user->admin = $request->admin;
        }

        $user->save();
        return $this->showOne($user);

        
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
        $user->delete();
        
        //return response()->json(['data' => $user], 200);
        return $this->showOne($user);
    }
}
