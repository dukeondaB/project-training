<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function show(){
<<<<<<< Updated upstream
        $user = Auth::user();
        return view('dashboard.index',['user' => $user]);
=======
        return view('dashboard.index');
>>>>>>> Stashed changes
    }
}
