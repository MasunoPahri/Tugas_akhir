<?php namespace App\Http\Middleware;

use Closure;

class SessionMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($request->session()->has('userSession'))
			return $next($request);
		
		$request->session()->forget('userSession'); //DELETE SESS WHEN ERROR IN MIDDLEWARE OCCURED
		return redirect('/form/login');

	}

}
