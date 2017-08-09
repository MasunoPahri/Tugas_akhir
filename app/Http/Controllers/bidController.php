<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bid as Bids;
use App\Tawaran as BidList;
use App\Project as Project;
use App\Pengguna as Pengguna;

use Illuminate\Http\Request;

class bidController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function makeBid($prefix, $idp)
	{
		$v = session('userSession');
		$s = session('username');

		return view('content.makeBid',[
			'user' => $s,
			'sess' => $v,
			'pid' => $idp
		]);
	}

	public function bid(Request $req, $prefix)
	{
		$bids = $req->all();
		
		$idProject = [];
		$s = session('username');

		$pengguna = Pengguna::where('nama_user', '=', $s)->get();
		$id_user = $pengguna[0]['id_user'];

		//SIMPAN TAWARAN SEMENTARA
		$newBid = new Bids;
		$newBid->dipilih = 0;
		$newBid->harga = $bids['bidprice'];
		$newBid->lama_pengerjaan = $bids['timerange'];
		$newBid->id_penjahit = $id_user;
		$newBid->id_proyek = $bids['idp'];
		$newBid->save();
		array_push($idProject, $bids['idp']);


		// echo dd($idProject);

		$newBid->tailorsBid()->sync($idProject, false);
		
		if(!$newBid->save()){
			App::abort(500);
		}
		
		return redirect('/WEB/projects/'.$s);
	}

	public function bidList(Request $req, $prefix, $idp){
		$v = session('userSession');
		$s = session('username');

		$daftarPenawar = BidList::with(['penjahit'])->where('id_proyek', '=', $idp)->get();
		// foreach($daftarPenawar as $data){
		// 	echo $data->proyek->nama_proyek;
		// 	echo $data->penjahit->nama_user;
		// }

		// $daftarPenawar = Project::where('id_proyek', '=', $idp)->get();
		
		// foreach($daftarPenawar as $p){
		// 	foreach($p->bidListing as $u){
		// 		echo $u->lama_pengerjaan;
		// 	}
		// }

		if($prefix == "WEB"){
			return view('content.bid_list',[
				'user' => $s,
				'sess' => $v,
				'bidList' => $daftarPenawar
			]);
		}else if($prefix == "API"){
			return response()->json(['data' => $getUser]);
		}
	}

	public function changeBidPrice()
	{
		//
	}

	public function priceBid()
	{
		//
	}

	public function bidDone($prefix, $idp)
	{
		$s = session('username');
		$uID = Pengguna::where('nama_user', '=', $s)->get();
		$getID = $uID[0]['id_user'];	

		//ISI FIELD 'id_penjahit' DI TABEL 'tb_proyek', Lalu..
		//UBAH STATUS PROYEK jadi "ONGOING"
		$getProject = Project::find($idp);
		$getProject->status = "ongoing";
		$getProject->id_penjahit = $getID;
		$getProject->save();
	}


}
