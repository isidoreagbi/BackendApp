<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller {
    protected $userRepo;

    public function __construct(UserInterface $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);
    
        $user = $this->userRepo->createUser($data);
    
        $otp = Str::random(6);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10); // OTP expire dans 10 minutes
        $user->save();
    
        // Envoyer l'OTP par email
        Mail::to($user->email)->send(new OtpMail($otp));
    
        return response()->json(['message' => 'User registered successfully. Check your email for the OTP.'], 201);
    }

    public function verifyOtp(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email|max:255',
        'otp' => 'required|string|size:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = $this->userRepo->getUserByEmail($request->email);

    if (!$user || $user->otp !== $request->otp || $user->otp_expires_at < now()) {
        return response()->json(['message' => 'Invalid or expired OTP.'], 400);
    }

    $user->otp = null;
    $user->otp_expires_at = null;
    $user->save();

    // Connexion automatique ou redirection vers le dashboard
    Auth::login($user);

    return response()->json(['message' => 'OTP verified successfully.'], 200);
}

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}
