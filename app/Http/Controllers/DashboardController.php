<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MqttUser;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data semua MQTT yang dimiliki oleh user yang sedang login
        $mqtts = MqttUser::where('user_id', Auth::id())->get();

        return view('dashboard.index', compact('mqtts'));
    }
}
