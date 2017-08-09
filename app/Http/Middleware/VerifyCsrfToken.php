<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

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
	    
	    if ($route == 'API' ) {
		
            header("Access-Control-Allow-Origin: *");
    
            // ALLOW OPTIONS METHOD
            $headers = [
                'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
            ];
    		
            // if($request->getMethod() == "OPTIONS") {
            //     // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            //     return response()
            //         ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            //         ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin');
            // }
    		
    		return $next($request)
                ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin');
                foreach($headers as $key => $value)
                    $response->header($key, $value);
            return $response;
        }
        
        // echo $request;
        
		return parent::handle($request, $next);
	}

}
