<?php

namespace App\Http\Middleware;

use App\Models\Users\UserEntity;
use Closure;

class AuthFinance
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
        // check if user can access finance data

        if( ! $user = \Auth::user() ) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        $user_type = strtolower( $user->user_type ) ;
        $allowed = [ 'admin' , 'finance' ];

        if( ! in_array( $user_type , $allowed  ) ) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        if( ! UserEntity::me() ){
            $user = UserEntity::find( \Auth::user()->id );
            UserEntity::setupMe( $user ) ;
        }

        return $next($request);

    }
}
