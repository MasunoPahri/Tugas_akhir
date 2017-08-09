<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Portofolio as Portofolio;
use App\Pengguna as Pengguna;

use Illuminate\Http\Request;

class portofolioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $req, $prefix, $mode){
		$data = $req->all();
		$v = session('userSession');
		$s = session('username');
		
		$pengguna = Pengguna::where('nama_user', '=', $s)->get();
		$id_user = $pengguna[0]['id_user'];

		$portofolios = Portofolio::where('id_penjahit', '=', $id_user)->get();
		// echo dd($portofolios);

		if($mode == "list"){
			return view('content.portofolios',[
				'user' => $s,
				'sess' => $v,
				'viewMode' => $mode,
				'portofolios' => $portofolios
			]);
		}else if($mode == "add"){
			$desc 	= $data['desc'];
			$files 	= $req->file('img');

			$imgName = $this->uploads($files);

			$pengguna = Pengguna::where('nama_user', '=', $s)->get();
			$id_user = $pengguna[0]['id_user'];

			// echo dd($id_user);

			$newPorto = Portofolio::create([
				'foto' => $imgName,
				'deskripsi' => $desc,
				'id_penjahit' => $id_user
			]);

			return redirect('/WEB/portofolio/list');
		}
		else if($mode == "dltPorto"){
			$idPorto = $data['id_porto'];
			$portofolios = Portofolio::where('id', '=', $idPorto)->delete();
			
			return redirect('/WEB/portofolio/list');
		}
	}


	public function showPortofolio($prefix, $string){
		$v = session('userSession');
		$s = session('username');

		if($string == "all"){
			$portofolios = Portofolio::all();
			// echo dd($portofolio);
		}else{
			$searchString = '%'.$string.'%';
			$portofolios = Portofolio::where('deskripsi', 'like', $searchString)->get();
			// echo dd($portofolio);
		}

		return view('content.searchPortofolio',[
			'user' => $s,
			'sess' => $v,
			'portofolios' => $portofolios
		]);
	}

	public function sendSearchString(Request $req){
		$searchString = $req->input('cari');
		return redirect('/WEB/portofolio-search/'.$searchString);
	}


	public function uploads($files){

		if(!empty($files)){
			$imgName = $files->getClientOriginalName();
			$files->move(
				base_path().'/public/images/', $imgName
			);
		}
		else{
			$imgName = "img1.png";
		}

		return $imgName;

	}

}
