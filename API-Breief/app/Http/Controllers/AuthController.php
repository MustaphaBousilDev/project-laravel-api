<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\MailUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'resetPassword', 'updatePassword']]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        // i using authentification with passport i want to return data with token give me an example


        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user_role' => $user->role,
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(){
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function updateProfile(Request $request){
        $user = Auth::user();
        //check if the user is trying to change the name
        if($request->name != $user->name){
            $request->validate(['name' => 'required|string|max:255',]);
            $user->name = $request->name;
        }
        //check if the user is trying to change the email
        if($request->email != $user->email){
            $request->validate(['email' => 'required|email|unique:users',]);
            $user->email = $request->email;
        }
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }
    // reset password
    public function resetPassword(Request $request){
        $request->validate(['email' => 'required|string|email',]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
        // Generate a unique token and store it in the user's database record.
        $token = Str::random(60);
        $user->reset_password_token = $token;
        $user->save();
        // Create an email with a link to a password reset page that includes the unique token in the URL.
        $resetLink = url('/api/password-reset/'.$token);
    
        // Send the email to the user's email address using a library like Laravel's built-in Mail class.
        Mail::to($user->email)->send(new MailUser($resetLink));
        
        return response()->json([
            'status' => 'success',
            'message' => 'Password reset email sent',
        ]);
    }
    
    public function updatePassword(Request $request, $token){
        // return $token;
        $user = User::where('reset_password_token', $token)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
        $request->validate([
            'password' => 'required|string|min:6',
        ]);
        $user->password = Hash::make($request->password);
        $user->reset_password_token = null;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully',
        ]);
        
    }
    //update user role by admin 
    public function changeRole($id){
         if(Auth::user()->role == 0){
            $user = User::find($id);
            $user->role=1;
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'User role updated successfully',
                'user' => $user,
            ]);
         }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
         }
    }


}