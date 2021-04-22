<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Validator;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request){
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        $creds = $request->only(['email','password']);

        if(!$token=auth()->attempt($creds)){
            return response()->json([
                'success' => false,
                'message' => 'invalid credentials'
            ]);
        }

        return response()->json([
            'success' =>true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function register(Request $request){

        $rules = array(
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        try{
            $user = new User;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return $this->login($request);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }

    public function logout(Request $request){
        try{
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'logout success'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'You must be sign-in first to logout'
            ]);
        }
    }

    // this function saves user name,lastname and photo
    public function saveUserInfo(Request $request){
        $rules = array(
            'name' => 'required|string|min:2',
            'lastname' => 'required|string|min:2',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;

        if($request->picture != ''){
            //cache the file
            $file = $request->picture;
            // generate a new filename. getClientOriginalExtension() for the file extension
            $name = $string = preg_replace('/\s+/', '', $request->name);

            $fileName = $name.'-photo-'.time().'.jpg';
            // save to storage/app/photos as the new $filename
            // $path = $file->storeAs('public/users', base64_decode($fileName));
            Storage::put('public/users/'.$fileName,base64_decode($request->picture));
            $user->picture = $fileName;
        }

        $user->update();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
