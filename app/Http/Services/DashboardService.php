<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function show()
    {
        $user = Auth::user();
        return view('dashboard.index', ['student' => $user]);
    }
}
