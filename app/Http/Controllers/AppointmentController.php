<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CalendlyService;

class AppointmentController extends Controller
{
    
    public function book(Request $request, CalendlyService $calendly)
    {
        
        $request->validate([
            'student_id' => 'required|integer',
            'email' => 'required|email',
        ]);

        // calendy test dari
        $response = $calendly->getUser();

        
        $calendlyEventId = $response['resource']['uri'] ?? 'no-id';

        //  Save sa database
        DB::table('appointments')->insert([
            'student_id' => $request->student_id,
            'email' => $request->email,
            'calendly_event_id' => $calendlyEventId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

       
        return response()->json([
            'message' => 'Appointment booked (Calendly connected)',
            'calendly_data' => $response
        ]);
    }

    // GET ALL APPOINTMENTS
    public function index()
    {
        $appointments = DB::table('appointments')->get();

        return response()->json([
            'data' => $appointments
        ]);
    }
}