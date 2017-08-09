<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Testimonial as Testimonial;
use App\Pengguna as Pengguna;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class testimoniController extends Controller {

	public function testimonials(Request $req, $prefix, $mode){
		if($mode == "add"){

			$v = session('userSession');
			$s = session('username');

			$uID = Pengguna::where('nama_user', '=', $s)->get();
			$getID = $uID[0]['id_user'];
			// echo $getID;
			$data = $req->all();

			$idProyek 	= $data['id_proyek'];
			$ratting 	= $data['star'];
			$komentar 	= $data['komentar'];
			$idPenjahit = $data['id_penjahit'];

			$newTesti =  Testimonial::create([
				'ratting' 		=> $ratting,
				'komentar' 		=> $komentar,
				'id_penjahit' 	=> $idPenjahit,
				'id_konsumen' 	=> $getID,
				'status_terbit' => 0
			]);
			
			return redirect('/WEB/view-detail/finished/'.$idProyek);
		}
	}
	public function view(Request $req, $mode){
		$v = session('userSession');
		$testimoni = Testimonial::all();

		return view('content.admin.partials.testimonials',[
			'sess' => $v,
			'testimonial' => $testimoni
		]);
	}
	
	public function publish(Request $req, $idt){
		$idTestimoni = Testimonial::where('id_testimoni', '=', $idt)
				->update(['status_terbit' => 1]);
		return redirect('/adminpanel/testimonials/view');
	}

	public function delete(Request $req, $idt){
		$idTestimoni = Testimonial::where('id_testimoni', '=', $idt)
					->delete();
		return redirect('/adminpanel/testimonials/view');
	}
}