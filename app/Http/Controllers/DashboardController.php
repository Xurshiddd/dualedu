<?php

namespace App\Http\Controllers;

use App\Models\Inspector;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Inspector')|| auth()->user()->hasRole('Moderator')) {
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            $inspectors = [];
            foreach (range(1, 12) as $month) {
                $inspectors[] = Inspector::whereMonth('created_at', $month)->count();
            }

            return view('dashboard', compact('months', 'inspectors'));
        }else{
            return view('welcome');
        }
    }
}
