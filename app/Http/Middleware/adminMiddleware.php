<?php namespace App\Http\Middleware;

use Closure;

class adminMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$dataRole = $request->role;
		if($dataRole == null)
			$dataRole = session('userSession');	

		// echo dd();
		if($dataRole == "admin")
			return $next($request);
		
		// $request->session()->forget('userSession'); //DELETE SESS WHEN ERROR IN MIDDLEWARE OCCURED
		return redirect('/form/login');
	}

}
