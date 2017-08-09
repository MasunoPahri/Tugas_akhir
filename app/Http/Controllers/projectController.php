<?php namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bid as Bids;
use App\Billing as Bills;
use App\Project as Project;
use App\Images as Images;
use App\Pengguna as Pengguna;
use App\Tawaran as bidList;
use App\Perbaikan as Reture;
use App\CustomSizeProject as CustomSizeProject;
use App\StandartSizeProject as StandartSizeProject;

use Illuminate\Http\Request;

class projectController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	
	//DAFTAR PROYEK YANG DAPAT DI "BID"
	public function allProjects(Request $req, $prefix){
		$v = session('userSession');
		$s = session('username');

		$pengguna = Pengguna::where('nama_user', '=', $s)->get();
		$id_user = $pengguna[0]['id_user'];

		//cek apakah penjahit berhak melakukan penawaran
		$cekStatus = $cek = "";
		$getData = bidList::with(['proyek'])
					->whereRaw('id_penjahit = ? AND dipilih = ?', [$id_user, 1])->get();
		$cek = count($getData);
		// echo dd($getData[1]->proyek->status);

		$projectList = Project::with(['penawar'])
			->where('status', '=', 'pending')->orderBy('created_at', 'desc')->get();
		// echo count($projectList2->first()->penawar()->get());
		// echo dd($projectList);

		if($prefix == "WEB"){
			return view('content.projects',[
				'user' => $s,
				'sess' => $v,
				'hasProject' => $cek,
				'projects' => $projectList
				// 'projects2' => $projectList2
			]);
		}else if($prefix == "API"){
			return response()->json(['data' => $projectList]);
		}
	}

	public function userProjects($prefix, $status, $page){
		$s = session('username');
		$v = session('userSession');

		$uID = Pengguna::where('nama_user', '=', $s)->get();
		$getID = $uID[0]['id_user'];	

		if($status == "all"){
			$projectList = Project::with(['penawar'])
				->where('id_konsumen', '=', $getID)->orderBy('created_at', 'desc')->get();
		}else{
			$projectList = Project::with(['penawar'])
				->whereRaw('id_konsumen = ? AND status = ?', [$getID, $status])
				->orderBy('created_at', 'desc')->get();
		}

			// echo dd($status);

		return view('content.dasbor',[
			'user' => $s,
			'sess' => $v,
			'viewMode' => $v,
			'status' => $status,
			'projects' => $projectList
		]);
	}

	//DAFTAR PROYEK PENJAHIT YANG SUDAH DI "BID"
	public function projects(Request $req, $prefix, $name){
		$v = session('userSession');	
		$s = session('username');
		
		$pengguna = Pengguna::where('nama_user', '=', $name)->get();
		$id_user = $pengguna[0]['id_user'];

		$blist = bidList::where('id_penjahit', '=', $id_user)->get();
		// echo dd($blist);

		if($prefix == "WEB"){
			return view('content.jobs_penjahit',[
				'user' => $s,
				'sess' => $v,
				'biddedProject' => $blist
			]);
		}else if($prefix == "API"){
			return response()->json(['data' => $proyek]);
		}
	}

	public function create(Request $req, $prefix, $mode){
		$v = session('userSession');
		$s = session('username');
		$imgs = '';

		$userData = Pengguna::whereRaw("nama_user = ?", [$s])->get();
		$address = $userData[0]->alamat;

		if($mode == "new"){
			return view('content.newProject',[
				'user' => $s,
				'sess' => $v,
				'alamat' => $address,
				'viewMode' => "new"
			]);
		}
		else if($mode == "sizing"){
			$basicData = $req->all();

			$judul = $basicData['title'];
			$alamat = $basicData['address'];
			$jnsBayar = $basicData['priceType'];
			$tipeUkur = $basicData['sizingType'];

			return view('content.newProject',[
				'user' => $s,
				'sess' => $v,
				'title'=> $judul,
				'address' => $alamat,
				'price_type' => $jnsBayar,
				'viewMode' => $tipeUkur
			]);
		}
		else if($mode == "deliverData"){
			$secondData = $req->all();

			$userData = Pengguna::whereRaw("nama_user = ?", [$s])->get();
			$address = $userData[0]->alamat;

			$imgs = $req->file('image');
			
			$allData = [
				'user' => $s,
				'sess' => $v,
				'alamat' => $address,
				'dataSec' => $secondData,
				'viewMode' => 'deliverData'
			];

			return view('content.newProject', $allData);

		}
		else if($mode == "confirm"){
			$confirmData = $req->all();
			$count =  count($confirmData['kategori']);

			$uID = Pengguna::where('nama_user', '=', $s)->get();;
			$getID = $uID[0]['id_user'];

			$allData = [
				'user' => $s,
				'sess' => $v,
				'userID' => $getID,
				'count'=> $count,
				'finalData' => $confirmData,
				'viewMode' => 'confirm'
			];

			return view('content.newProject', $allData);
		}
	}

	public function store(Request $req, $prefix){
		$s = session('username');

		$projectData = $req->all();
		$count = count($projectData['kategori']);

		// echo dd($projectData);
		
		$uID = Pengguna::where('nama_user', '=', $s)->get();
		$getID = $uID[0]['id_user'];

		$projectDB = Project::all();
		$jlhProject = count($projectDB) + 1;
		$projectMainData 	= new Project;
		
		// $uID = Pengguna::where('nama_user', '=', $s)->get();;
		// $getID = $uID[0]['id_user'];

		if($projectData['sizingMode'] == "standart"){
			$idProject = "STD".$jlhProject;
		}
		else{
			$idProject = "CSTM".$jlhProject; 	
		}

		$projectMainData->id_proyek 		= $idProject;
		$projectMainData->nama_proyek 		= $projectData['title']; 
		$projectMainData->mode_pengukuran 	= $projectData['sizingMode'];
		$projectMainData->id_konsumen		= $getID;
		$projectMainData->status 			= "draf";
		$projectMainData->tipe_bayar 		= $projectData['priceType'];
		$projectMainData->save();

		if($projectData['sizingMode'] == "standart"){
 
			for($i=0; $i < $count; $i++){
				$projectSize 	= new StandartSizeProject;
				$projectSize->kategori 	 = $projectData['kategori'][$i];
				$projectSize->ukuran 	 = $projectData['letterSize'][$i];
				$projectSize->jlhPakaian = $projectData['jlhPakaian'][$i];
				$projectSize->deskripsi  = $projectData['desc'][$i];
				$projectSize->id_proyek  = $idProject;
				$projectSize->save();
			}
		}	
		else if($projectData['sizingMode'] == "customize"){
			for($i=0; $i < $count; $i++){
				$projectSize2 	= new CustomSizeProject;
				$projectSize2->kategori   = $projectData['kategori'][$i];
				
				$projectSize2->l_badan 	  = $projectData['l_badan'][$i];
				$projectSize2->l_pinggang = $projectData['l_pinggang'][$i];
				$projectSize2->l_pinggul  = $projectData['l_pinggul'][$i];
				$projectSize2->l_pundak   = $projectData['l_pundak'][$i];
				$projectSize2->p_lengan   = $projectData['p_lengan'][$i];
				$projectSize2->p_blazzer  = $projectData['p_blazzer'][$i];

				$projectSize2->pjgCelana  = $projectData['pjgCelana'][$i];
				$projectSize2->k_pinggang = $projectData['k_pinggang'][$i];
				$projectSize2->l_pisak    = $projectData['l_pisak'][$i];
				$projectSize2->k_kaki     = $projectData['k_kaki'][$i];

				$projectSize2->deskripsi  = $projectData['desc'][$i];
				$projectSize2->id_proyek  = $idProject;
				$projectSize2->save();
			}
		}

		if(!$projectMainData->save() && !$projectSize->save() && !$projectSize2->save())
            App::abort(500);

        return redirect('/WEB/view-detail/draf/'.$idProject);
	}

	public function publishProject(Request $req, $prefix, $idp){

		$upProject = Project::where('id_proyek', '=', $idp)
							->update(['status' => 'pending']);

		return redirect('/WEB/view-detail/pending/'.$idp);
	}

	public function saveImages(Request $req, $prefix, $sizeMode){
		$images = $req->file('foto');
		$imgRefID = $req->input('itemPakaian');

		if(!empty($images)){
			foreach($images as $image){
				$imgName = $image->getClientOriginalName();
				// echo dd($image);
				$imgSave = new Images;
				$imgSave->images = $imgName;
				$imgSave->id_item = $imgRefID;
				$imgSave->mode_pengukuran = $sizeMode;
				$imgSave->save();

				if($imgSave->save()){
					$image->move(
						base_path().'/public/images/', $imgName
					);
				}else{
					App::abort(500);
				}
			}
		}
		$r = redirect()->getUrlGenerator()->previous();
		return redirect($r);
	}

	public function uploads(Request $req, $prefix){
	
		$files = $req->file('foto');

		if(!empty($files)){
			foreach($files as $file){
				$imgName = $file->getClientOriginalName();
				$file->move(
					base_path().'/public/images/', $imgName
				);
			}
		}

	}

	public function viewDetail(Request $req, $prefix, $mode, $idp){
		$v = session('userSession');
		$s = session('username');

		if($mode == "pending")
			$viewMode = "pendingView";
		else if($mode == "ongoing")
			$viewMode = "ongoingView";
		else if($mode == "finished")
			$viewMode = "finishedView";
		else if($mode == "tailorProjects")
			$viewMode = "tailorProjectsView";
		else
			$viewMode = "generalView";

		$pengguna = Pengguna::where('nama_user', '=', $s)->get();
		$id_user = $pengguna[0]['id_user'];
		
		$getProyek = Project::with(['penawar'])
					->whereRaw('id_proyek = ? AND status = ?', [$idp, $mode])->get();
		$tipeBayar = $getProyek[0]['tipe_bayar'];
		$cekProject = count($getProyek);
		
		// echo dd($getSize);
		if($cekProject != 0){
			
			if($getProyek[0]["mode_pengukuran"] == "standart")
				$getSize = StandartSizeProject::with(['design' => function($q){
					$q->where('mode_pengukuran', '=', 'standart');
				}])->where('id_proyek', '=', $idp)->get();
			else
				$getSize = CustomSizeProject::with(['design' => function($q){
					$q->where('mode_pengukuran', '=', 'customize');
				}])->where('id_proyek', '=', $idp)->get();
			
			// echo dd($getSize);
			$bill = Bills::whereRaw('id_proyek = ? AND status_konfirmasi = ?', [$idp, 0])->get();
			$hasBill = count($bill);

			//cek apakah proyek tsb sudah melakukan konfirmasi atau tidak
			if($hasBill == 1){
				//jika ya, tampilkan penjahit terpilih
				$daftarPenawar = BidList::with(['penjahit'])
							->whereRaw('id_proyek = ? AND dipilih = ?', [$idp, 1])
							->orderBy('harga', 'asc')
							->get();
			}else{
				//jika tidak, tampilkan penjahit yang belumterpilih
				$daftarPenawar = BidList::with(['penjahit'])
					->whereRaw('id_proyek = ? AND dipilih = ?', [$idp, 0])
					->orderBy('harga', 'asc')
					->get();
			}

			// echo dd($daftarPenawar);

			//cek apakah penjahit berhak melakukan penawaran
			$cekStatus = $cek = "";
			$getData = bidList::whereRaw('id_penjahit = ? AND dipilih = ?', [$id_user, 1])->get();
			$cek = count($getData);
			// echo dd($getData);
			
			return view('content.projectDetail',[
				'user' => $s,
				'sess' => $v,
				'idProyek' => $idp,
				'hasBill' => $hasBill,
				'proyek' => $getProyek,
				'hasProject' => $cek,
				'viewMode' => $viewMode,
				'tipe_bayar' => $tipeBayar,
				'projectAttr' => $getSize,
				'bidList' => $daftarPenawar,
				'iterate' => 0
			]);
		}else{
			return view('errors.404');
		}
	}

	public function theBidders(Request $req, $prefix, $mode){
		if($prefix == "WEB"){
			$data = $req->all();
			if($mode == "start"){
				$idProyek = $data['idproyek'];
				$idPenjahit = $data['iduser'];
				$tipe_bayar = $data['tipe_bayar'];

				$theBidder = bidList::with(['penjahit'])
							->whereRaw('id_proyek = ? and id_penjahit = ?', [$idProyek, $idPenjahit])
							->update(['dipilih' => 1]);
				
				//TANDAI PENJAHIT YANG MENGERJAKAN PROYEK
				$tailorProject = Project::where('id_proyek', '=', $idProyek)
							->update(['id_penjahit' => $idPenjahit]);

				$theBidder2 = bidList::with(['penjahit'])
							->whereRaw('id_proyek = ? and id_penjahit = ?', [$idProyek, $idPenjahit])
							->get();

				$harga = $theBidder2[0]['harga'];
				
				//BUAT DATA INVOICE
				$this->makeInvoice($idProyek, $harga, $tipe_bayar);

				return redirect('/WEB/invoice/confirm/'.$idProyek);

			}else if($mode == "final"){
				
			}
		}else if($prefix == "API"){
			// return response()->json(['data' => $proyek]);
		}
	}

	public function makeInvoice($idp, $harga, $tipe_bayar){
		//MAKE INVOICE NUMBER
		$invoiceNum = $this->makeInvoiceNum($idp);

		//SAVE PRICE FROM SELECTED TAILOR
		$project = Project::where('id_proyek', '=', $idp)
			->update(['harga' => $harga]);

		if($project){
			//GET PROJECT THEN GET 'tipe_bayar' AND 'harga'
			$project = Project::where('id_proyek', '=', $idp)->get();
			if($tipe_bayar == "cicilan")
				$jlhBayar = ($project[0]['harga'])*0.5;
			else
				$jlhBayar = ($project[0]['harga']);

			$newBill = new Bills;
			$newBill->invoice_num = $invoiceNum;
			$newBill->jlh_bayar = $jlhBayar;
			$newBill->status_konfirmasi = 0;
			$newBill->id_proyek = $idp;
			$newBill->ket = "Belum Dibayar";
			
			$newBill->save();

			if(!$newBill->save())
				App::abort(500);

		}	
		 
	}

	public function makeInvoiceNum($data){
	    $string = md5(uniqid(rand(), true));
	    $string = substr($string, 0, 8);

		return $string;
	}

	public function finished(Request $req, $prefix, $idp){
		
		$v = session('userSession');
		$s = session('username');

		$getProject = Project::where('id_proyek', '=', $idp)
					->update(['status' => "finished"]);
		$getBid = BidList::where('id_proyek', '=', $idp)
				->update(['dipilih' => 2]);
		
		return redirect("/WEB/projects/".$s);
	}

	public function testimonials(Request $req, $prefix, $idp){
		return view('content.make_testimonial');
	}

	public function reture(Request $req, $prefix, $idp){
		$s = session('username');

		$data = $req->all();
		$idPenjahit	= $data['id_penjahit'];
		$komentar 	= $data['komentar']; 
		
		$pengguna = Pengguna::where('nama_user', '=', $s)->get();
		$id_user = $pengguna[0]['id_user'];

		$newPorto = Reture::create([
			'deskripsi' => $komentar,
			'id_penjahit' => $idPenjahit,
			'id_konsumen' => $id_user,
			'id_proyek' => $idp
		]);

		return redirect('WEB/view-detail/finished/'.$idp);
	}
}
