<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if(count($users) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $users
            ], 200);
        }

        return response([
            'message' => 'Users Empty',
            'data' => null
        ], 404);
    }
    
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $data = $request->all();

        $validate = Validator::make($data, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users' . $user->id,
            'password' => 'required',
            'picture' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        // if validation failed
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }
        
        $up = 'users';
        $image = $request->file('picture');
        $image_uploaded_path = $image->store($up, 'public');
        $user['picture'] = basename($image_uploaded_path);

        $user['password'] = bcrypt($request->password);

        $user = User::find($user->id);
        $user->update($data);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile Updated',
            'data' => $user
        ], 200);
    }

    public function show()
    {
        $user = auth()->user();

        if(!is_null($user)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }
}
