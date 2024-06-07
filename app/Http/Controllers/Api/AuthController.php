<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthFormRequest;
use App\Models\User;
use App\Traits\Responseable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $response =
            [
                'user' => $user,
                'token' => $user->createToken('access_token')->plainTextToken,
            ];

        return Responseable::success($response, 'Token created.');
    }
}
