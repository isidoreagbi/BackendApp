<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use App\Mail\OtpMail;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\VerifyOtpRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class AuthController extends Controller {
    protected $userRepo;

    public function __construct(UserInterface $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function register(RegisterRequest $request) {
        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);
    
        $user = $this->userRepo->createUser($data);
    
        $otp = Str::random(6);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10); 
        $user->save();
    
        // Envoyer l'OTP par email
        Mail::to($user->email)->send(new OtpMail($otp));
    
        return response()->json(['message' => 'User registered successfully. Check your email for the OTP.'], 201);
    }

    public function verifyOtp(VerifyOtpRequest $request) {
        $user = $this->userRepo->getUserByEmail($request->email);

        if (!$user || $user->otp !== $request->otp || $user->otp_expires_at < now()) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);

        return response()->json(['message' => 'OTP verified successfully.'], 200);
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function showRegistrationForm(Request $request) {
        return view('auth.register', [
            'email' => $request->query('email'),
            'groupe_id' => $request->query('groupe_id'),
        ]);
    }
    
}
