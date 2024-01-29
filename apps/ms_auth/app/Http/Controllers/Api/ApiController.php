<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends BaseController
{
    use ApiResponser;

    public function __construct()
    {
    }

    /**
     * Healthcheck
     *
     * Check that the service is up. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with a 400 error, and a response listing the failed services.
     *
     * @response 400 scenario="Service is unhealthy" {"status": "down", "services": {"database": "up", "redis": "down"}}
     *
     * @responseField status The status of this API (`up` or `down`).
     * @responseField services Map of each downstream service and their status (`up` or `down`).
     */
    public function health()
    {
        // Test database connection
        try {
            if (DB::connection()->getPdo()) {
                return $this->showMessage(['meesage' => 'Health ms_auth check ok'], 200);
            } else {
                return $this->errorResponse(['message' => 'Health Gateway check ko db'], 520);
            }
        } catch (Exception $e) {
            return $this->errorResponse(['message' => 'Health Gateway check ko: '.$e], 525);
        }
    }

    public function register(Request $request)
    {

        // data validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        // User Model
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Response
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
        ]);
    }

    // User Login (POST, formdata)
    public function login(Request $request)
    {

        // data validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // JWTAuth
        $token = JWTAuth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (! empty($token)) {

            return response()->json([
                'status' => true,
                'message' => 'User logged in succcessfully',
                'token' => $token,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid details',
        ]);
    }

    // User Profile (GET)
    public function profile()
    {

        $userdata = auth()->user();

        return response()->json([
            'status' => true,
            'message' => 'Profile data',
            'data' => $userdata,
        ]);
    }

    // To generate refresh token value
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
        ]);
    }

    // User Logout (GET)
    public function logout()
    {

        auth()->logout();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
        ]);
    }
}
