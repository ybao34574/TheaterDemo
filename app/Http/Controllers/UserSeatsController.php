<?php

namespace App\Http\Controllers;

use App\Models\UserSeats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserSeatsController extends Controller
{
    //
    public static function index()
    {
        return view('index');
    }

    public static function store(Request $request)
    {
        try {
            UserSeats::insertIntoUserSeats($request->user, $request->email, $request->tickets);
        } catch (\Exception $e) {
            Log::alert('UserSeatsController::store : '.$e);
        }
        return redirect('/');
    }
}
