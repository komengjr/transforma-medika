<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\EventModel;
use App\Models\Event\SubEventModel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function event_registrasi($id, $code)
    {
        $event = EventModel::where('event_data_code', $id)->first();
        if ($event) {
            $subevent = SubEventModel::where('event_data_code', $id)->get();
            return view('public.event-registrasi', compact('event', 'subevent'));
        } else {
            return view('public.error.500');
        }
    }
}
