<?php

namespace App\Http\Middleware;

use App\Models\Users\UserEntity;
use Closure;

class AuthStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( ! \Auth::user() || strtolower( \Auth::user()->user_type ) != 'student'  ) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        $user = UserEntity::find( \Auth::user()->id );
        UserEntity::setupMe( $user ) ;

        return $next($request);
    }
}
