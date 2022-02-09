<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class CheckAdminUser
{
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param JWT $auth
     */
    public function __construct(JWT $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return JsonResponse|mixed
     * @throws JWTException
     */
    public function handle($request, Closure $next)
    {
        $email = $this->auth->parseToken()->getClaim('sub');
        $user = auth()->user() ?? User::with('role')->whereEmail($email)->firstOrFail();

        if (($user->isSuperAdmin())) {
            return response()->json([
                'error' => [
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'User Forbidden',
                ],
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
