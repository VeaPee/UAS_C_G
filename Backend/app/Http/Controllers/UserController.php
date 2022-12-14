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
        $user = User::all();

        if(count($user) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Users Empty',
            'data' => null
        ], 404);
    }
    
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ],404);
        }

        $data = $request->all();

        $validate = Validator::make($data, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'nomor_hp' => 'required'
        ]);

        // if validation failed
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }
    
        $data['password'] = bcrypt($request->password);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $data['password'],
            'nomor_hp' => $request->nomor_hp
        ]);

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
