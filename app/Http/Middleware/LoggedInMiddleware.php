<?php namespace App\Http\Middleware;

use Closure;

class LoggedInMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{	
		echo $prefix;
		if($request->session()->has('userSession'))
			return redirect('/'.$prefix.'/'.session('userSession'));
		
		return redirect('/form/login');
	}

}
