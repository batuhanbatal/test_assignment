<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\SubscriptionFormRequest;
use App\Traits\Responseable;

class SubscriptionController extends Controller
{
    use Responseable;

    public function index(SubscriptionFormRequest $request)
    {
        $user = Auth::user();

        $userKey = 'chat' . $user->id;
        RateLimiter::clear($userKey);

        Subscription::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'product_id' => $request->input('product_id'),
                'receipt_token' => $request->input('receipt_token')
            ]
        );

        return Responseable::success([], 'Subscripton defined');
    }
}
