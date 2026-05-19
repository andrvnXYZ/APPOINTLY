<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailService;

class NotificationController  extends Controller
{
  
    public function send(Request $request, MailService $mail)
    {
     
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
         
            $result = $mail->sendCustomNotification(
                $request->email,
                $request->message
            );

            return response()->json([
                'message' => 'Notification sent successfully',
                'status' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}