<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'product'])->get();
        return view('admin.dashboard.index')->with('subscriptions', $subscriptions);
    }
}
