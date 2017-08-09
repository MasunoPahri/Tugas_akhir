<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Billing as Bills;
use App\Pengguna as Pengguna;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class adminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function login()
	{
		return view('content.login');
	}

	public function home()
	{
		return view('content.admin.partials.home');
	}

	public function users()
	{
		$v = session('userSession');

		$users = Pengguna::whereRaw('peran != ? AND status_aktif = ?', ['admin', 1])->get();

		return view('content.admin.partials.users',[
			'sess' => $v,
			'users' => $users
		]);
	}

	public function bills()
	{
		$v = session('userSession');

		$allBills = Bills::all();

		return view('content.admin.partials.bills',[
			'sess' => $v,
			'allBills' => $allBills
		]);
	}
	public function dlt_user($user_id){
		
		$pengguna = Pengguna::where('id_user','=',$user_id)->delete();
		return redirect('/adminpanel/users');
	}

	public function sendString(Request $req){
		$string = $req->input('string');
		return redirect('/adminpanel/src-user/'.$string);
	}
	
	public function search_user(Request $req, $string){
		$srcUser = '%'.$string.'%';
		
		$v = session('userSession');

		$users = Pengguna::where('nama_user', 'like', $srcUser)->get();

		return view('content.admin.partials.users',[
			'sess' => $v,
			'users' => $users
		]);
	}
}
