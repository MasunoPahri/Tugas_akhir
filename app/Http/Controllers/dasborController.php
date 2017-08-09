<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pengguna as Pengguna;
use App\Project as Project;
use App\UserToken as UserToken;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class dasborController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 
	//DASBOR KONSUMEN/PENJAHIT
	public function index(Request $req, $prefix, $role){
		$v = session('userSession');
		$s = session('username');

		$uID = Pengguna::where('nama_user', '=', $s)->get();
		$getID = $uID[0]['id_user'];

		$projectList = Project::with(['penawar'])
			->with(['users'])->where('id_konsumen', '=', $getID)
			->orderBy('created_at', 'desc')->get();
		// echo dd($projectList[0]->users);
		if($prefix == "WEB"){
			if($v == $role){
				if($role == "konsumen"){
					return view('content.dasbor',[
						'user' => $s,
						'sess' => $v,
						'status' => "all",
						'viewMode' => $role,
						'projects' => $projectList
					]);
				}else if($role == "penjahit"){
					return view('content.dasbor',[
						'user' => $s,
						'sess' => $v,
						'viewMode' => $role
					]);
				}
			}else{
				return redirect('/form/login');
			}
		}
		else if($prefix == "API"){
			return response()->json(['data' => $projectList]);
		}
	}
	
	public function makeSession($value, $mode){
		session([$mode => $value]);
		$sv = session('userSession');
		return $sv;
	}

	public function makeToken($data){
	    $string = md5(uniqid(rand(), true));
	    $string = substr($string, 0, 8);

		$hash 	= hash('sha256', $data.$string);
		return $hash;
	}

	public function doLogin(Request $req, $prefix){
		$role = "";
		$loginData = $req->all();

		$getPass = Pengguna::where('nama_user', '=', $loginData['username'])->get();
		$user = count($getPass);

		if($user == 0){
			Session::flash('message', "Username Tidak Terdaftar!!! Silahkan masuk kembali...");
			return back();
		}

		$salt 		= $getPass[0]['salt'];
		$hash 		= hash('sha256', $loginData['password']);
		$hashedPass = hash('sha256', $salt.$hash);

		$dataLogin2 = [$loginData['username'], $hashedPass];
		$getUser = Pengguna::whereRaw('nama_user = ? and password = ?', $dataLogin2)->get();
		$user2 =  count($getUser);
		$userData = [];
		
		if($user2 == 1){
			$status_aktif = $getUser[0]['status_aktif'];
			if($status_aktif == 1){
				$userRole = $getUser[0]['peran'];
				if($prefix == "WEB"){
					$this->makeSession($loginData['username'], "username");

					if($userRole == "penjahit"){
						$this->makeSession("penjahit", "userSession");		
						return redirect('/WEB/projects/'.$loginData['username']);
					}
					else if($userRole == "konsumen"){
						$this->makeSession("konsumen", "userSession");	
						return redirect('/WEB/dasbor/konsumen');
					}
					else if($userRole == "admin"){
						$this->makeSession("admin", "userSession");	
						return redirect('/adminpanel/home');
					}
				}
				else if($prefix == "API"){
					$token =  $this->makeToken($getUser[0]['nama_user']);

					$dataLogin3 = [$getUser[0]['id_user'], 'mobile'];
					$getUserToken = UserToken::whereRaw('id_user = ? and device = ?', $dataLogin3)->get();
					$userToken = count($getUserToken);

					if($userToken == 0){
						$newUserToken = UserToken::create([
							'id_user' => $getUser[0]['id_user'],
							'token' => $token,
							'device' => 'mobile'
						]);
					}
					$getUserToken = UserToken::whereRaw('id_user = ? and device = ?', $dataLogin3)->get();
					
					// echo $getUserToken[0]['token'];

					array_push($userData, [
						"username" => $getUser[0]['nama_user'], 
						"password" => $getUser[0]['password'],
						"salt" => $getUser[0]['salt'],
						"token" => $getUserToken[0]['token'] 
					]);

					return response()->json($userData);
					// return $userData[0]['token'];
				}
			}
			else{
				return redirect('/block/complete-data/'.$loginData['username']);
			}
		}else{
			Session::flash('message', "Password Salah!!! Silahkan masuk kembali...");
			return back();
		}
	}
	 
	public function formState($state){
		if ($state == "login"){
            $cL = "checked";
            $cR = "";
		}else{
            $cL = "";
            $cR = "checked";
		}
		
		return view('login', [
			'states' => $state,
			'cL' => "$cL",
			'cR' => "$cR"
		]);
	}

	public function logout(Request $req){
		$req->session()->forget('userSession');
		return redirect('/form/login');
	}



}
