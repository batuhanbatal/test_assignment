<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\Responseable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthFormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Routing\Middleware\ThrottleRequests;

class AuthController extends Controller
{
    use Responseable;

    public function index(AuthFormRequest $request)
    {
        $device_uuid = $request->input('device_uuid');
        $device_name = $request->input('device_name');

        $user = User::where('device_uuid', $device_uuid)
            ->where('device_name', $device_name)
            ->first();

        if (!$user) {
            $user = User::create([
                'device_uuid' => $device_uuid,
                'device_name' => $device_name
            ]);
        }

        if ($user->subscription()->exists()) {
            $userKey = 'chat' .  $user->id;
            $remaining_limit = RateLimiter::remaining($userKey,  $user->subscription->product->rate_limit);
        } else {
            $remaining_limit = null;
        }

        $response =
            [
                'user' => $user,
                'remaining_limit' => $remaining_limit,
                'token' => $user->createToken('access_token')->plainTextToken,
            ];

        return Responseable::success($response, 'Token created.');
    }
}
