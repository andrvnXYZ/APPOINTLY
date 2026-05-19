<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    // Redirect to Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google Callback
    public function handleGoogleCallback()
    {
        try {
            //  Bypass for local development
            $driver = Socialite::driver('google');
            $driver->setHttpClient(new Client(['verify' => false]));

            $googleUser = $driver->user();

            // Find or create user in database
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt('google_default'),
                ]
            );

            // Generate API Token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return Token as JSON
            return response()->json([
                'message'       => 'Login Successful',
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'user'          => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login Failed',
                'error'   => $e->getMessage()
            ], 401);
        }
    }

    //  Step 3: Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}