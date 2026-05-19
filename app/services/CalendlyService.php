<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CalendlyService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.calendly.token');
    }

    // GET CURRENT USER
    public function getUser()
    {
        return Http::withToken($this->token)
            ->get('https://api.calendly.com/users/me')
            ->json();
    }

    // GET EVENT TYPES
    public function getEventTypes()
    {
        return Http::withToken($this->token)
            ->get('https://api.calendly.com/event_types')
            ->json();
    }

    // GET SCHEDULED EVENTS
    public function getScheduledEvents()
    {
        return Http::withToken($this->token)
            ->get('https://api.calendly.com/scheduled_events')
            ->json();
    }
}