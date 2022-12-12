<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();

        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:8',
            'picture' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
            
        $up = 'users';
        $image = $request->file('picture');
        $image_uploaded_path = $image->store($up, 'public');
        $registrationData['picture'] = basename($image_uploaded_path);

        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData);
        $user->sendEmailVerificationNotification();

        return response([
            'status' => true,
            'message' => 'Register Success',
            'user' => $user,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData,[
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);
   
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => false,
                'message' => 'Email & Password invalid.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                "message" => "Email isn't' verified"
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);

    }
    

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully',
        ], 200);
    }
}