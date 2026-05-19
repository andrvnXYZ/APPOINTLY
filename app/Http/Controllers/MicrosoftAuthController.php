<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class MicrosoftAuthController extends Controller
{
   
    public function redirect()
    {
        return Socialite::driver('azure')->redirect();
    }

    
    public function callback()
    {
        try {
           
            $driver = Socialite::driver('azure');
            $driver->setHttpClient(new Client(['verify' => false]));

            $microsoftUser = $driver->user();

          
            $user = User::updateOrCreate(
                ['email' => $microsoftUser->getEmail()],
                [
                    'name'              => $microsoftUser->getName(),
                    'email'             => $microsoftUser->getEmail(),
                    'microsoft_id'      => $microsoftUser->getId(),
                    'microsoft_token'   => $microsoftUser->token,
                    'password'          => bcrypt('microsoft_default'),
                ]
            );

        
            $token = $user->createToken('auth_token')->plainTextToken;

     
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
                'message'   => 'Microsoft Login Failed',
                'error'     => $e->getMessage()
            ], 401);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}