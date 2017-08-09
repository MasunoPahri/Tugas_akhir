<?php namespace App\Http\Middleware;

use Closure;

class konsumenMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$routeName = explode("/", $request->path());;
	    $route = $routeName[0];

		if($route == "WEB"){
			$dataRole = $request->role;
	
			if($dataRole == null)
				$dataRole = session('userSession');	
			// echo $dataRole;

			if($dataRole == "konsumen")
				return $next($request);
			
			// $request->session()->forget('userSession'); //DELETE SESS WHEN ERROR IN MIDDLEWARE OCCURED
			return redirect('/form/login');
		}else if($route =="API"){
			return $next($request);
		}
	}

}
