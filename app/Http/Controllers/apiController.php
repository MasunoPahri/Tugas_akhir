<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Billing as Bills;	
use App\Images as Images;
use App\Project as Project;
use App\Tawaran as bidList;
use App\Pengguna as Pengguna;
use App\Perbaikan as Reture;
use App\ReportAbuse as Abuse;
use App\UserToken as UserToken;
use App\Portofolio as Portofolio;
use App\Testimonial as Testimonial;
use App\CustomSizeProject as CustomSizeProject;
use App\StandartSizeProject as StandartSizeProject;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class apiController extends Controller {

	protected function passValidator(array $data){
        return Validator::make($data, [
            'newpass' => 'required|min:6',
			'repass'  => 'required|min:6|same:newpass'
        ]);
    }
	public function createSalt(){
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 8);
	}
	public function upload($files){
		if(!empty($files)){
			$imgName = $files->getClientOriginalName();
			// echo dd($imgName);
			$files->move(
				base_path().'/public/images/', $imgName
			);
		}else{
			$imgName = "img1.png";
		}

		return $imgName;
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
	public function tailorRate($tailor_id){
		$tempScore = [];
		$getTestimoni = $getTestimoni2 = "";
		$jlh_user = $jlhTestimoni = $highest_score = $total_score =  $index = 0;
		
		//HITUNG JUMLAH KONSUMEN YANG MEMBERIKAN TESTIMONI TERHADAP PENJAHIT 'X'
		$getTestimoni = Testimonial::with(['users'])
				->where('id_penjahit', '=', $tailor_id)->get();
		$jlhTestimoni = count($getTestimoni);

		//CEK APAKAH PENJAHIT MEMILIKI TESTIMONI
		if($jlhTestimoni > 0){
			//LALU HITUNG NILAI INDEX TERTINGGI
			$highest_score = 5 * $jlhTestimoni; 

			//HITUNG JUMLAH KONSUMEN PER SUB PENILAIAN(Sangat Buruk, Buruk, Biasa, Bagus, Sangat Bagus)
			for($i = 1; $i <= 5; $i++){
				$getTestimoni2 = Testimonial::where('id_penjahit', '=', $tailor_id);
				$user = $getTestimoni2->where('ratting', '=', $i)->count('id_konsumen');
				$temp = $user * $i;
				array_push($tempScore, $temp);
			}

			//JUMLAHKAN SUB PENILAIAN
			$total_score = array_sum($tempScore);

			//HITUNG INDEX PERSENTASE
			$index = ($total_score / $highest_score) * 100;
			
			return $index;
		}
	}


	public function createProject(){
		$projectData = $req->all();
		$count = count($projectData['kategori']);

		$projectDB = Project::all();
		$jlhProject = count($projectDB) + 1;
		$projectMainData 	= new Project;

		if($projectData['sizingMode'] == "standart")
			$projectMainData->id_proyek 	= "STD".$jlhProject; 
		else
			$projectMainData->id_proyek 	= "CSTM".$jlhProject;

		$loggedInUser = UserToken::where('token', '=', $projectData['token']);
		$getID = $loggedInUser[0]['id_user'];

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
				$projectSize->id_proyek  = "STD".$jlhProject;
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
		// return response()->json([$user]);

		if(!$projectMainData->save() && !$projectSize->save() && !$projectSize2->save())
            App::abort(500);
	}

	public function myprofile($token){
		$userToken = $token;

		$loggedInUser = UserToken::where('token', '=', $userToken)->get();
		$getID = $loggedInUser[0]['id_user'];
		// echo dd($loggedInUser);

		$userData = Pengguna::where('id_user', '=', $getID)->get();
		return response()->json($userData);
	}

	public function edit_profile(Request $req, $token){
		$data = $req->all();

		$username 	= $data['username'];
		$alamat 	= $data['alamat'];
		$email 		= $data['email'];
		$phone 		= $data['no_telp'];

		$loggedInUser = UserToken::where('token', '=', $token)->get();
		$getID = $loggedInUser[0]['id_user'];
		
		Pengguna::where('id_user', '=', $getID)
				->update([
					'nama_user'	=> $username,
					'alamat' 	=> $alamat,
					'email' 	=> $email,
					'no_telp' 	=> $phone
				]);

		return response()->json($username);
	}

	public function list_portofolio(){
		$portofolios = Portofolio::with(['penjahit'])->get();

		return response()->json($portofolios);
	}
	
	public function tailors(){
		$penjahit = Pengguna::with(['skills'])
			->where('peran', '=', 'penjahit')->get();

		return response()->json($penjahit);
	}

	public function projects($mode, $token){
		$userToken = $token;

		$loggedInUser = UserToken::where('token', '=', $userToken)->get();
		$getID = $loggedInUser[0]['id_user'];

		if($mode == "all"){
			$projectList = Project::with(['penawar'])
				->where('id_konsumen', '=', $getID)->orderBy('created_at', 'desc')->get();
		}else{
			$projectList = Project::with(['penawar'])->with(['users'])
				->whereRaw('id_konsumen = ? AND status = ?', [$getID, $mode])
				->orderBy('created_at', 'desc')->get();
		}


		return response()->json($projectList);
	}

	public function invoices($token){
		$userToken = $token;

		$loggedInUser = UserToken::where('token', '=', $userToken)->get();
		$getID = $loggedInUser[0]['id_user'];

		$invoices = Project::with(['bills'])
			->where('id_konsumen', '=', $getID)->get();
		
		return response()->json($invoices);
	}

	public function invoiceForm($project_id){
		$bills = Bills::with(['proyek'])
				->where('id_proyek', '=', $project_id)->get();

		if(count($bills) > 0){
			$noInvoice = $bills[0]['invoice_num'];
			$tipe_bayar = $bills[0]->proyek->tipe_bayar;
			
			// $proyek = Project::where('id_proyek', '=', $idp)->get();

			return response()->json([
				'no_invoice' => $noInvoice,
				'tipe_bayar' => $tipe_bayar
			]);
		}else{
			return response()->json(0);
		}
	}

	public function sendConfirm(Request $req){
		$data 		= $req->all();
		$invoice 	= $data['invoice'];
		$tipeBayar 	= $data['billingType'];
		$rekfrom 	= $data['rekfrom'];
		$rekto 		= $data['rekto'];
		$cash 		= $data['cash'];
		$imgProof 	= $req->file('approvalImg');
		$proofName  = $imgProof->getClientOriginalName();
		
		$imgProof->move(
			base_path().'/public/images/', $proofName
		);

		$updateBill = Bills::whereRaw('invoice_num = ? AND jlh_bayar = ?', [$invoice, $cash])
				->update([
					'tipe_bayar' => $tipeBayar,
					'rek_pengirim' => $rekfrom,
					'rek_penerima' => $rekto,
					'bukti' => $proofName,
					'ket' => "pending",
				]);
		
		return response()->json($updateBill);
	}

	public function view_tailorProfile($mode, $tailor_id){

		if($mode == "testimoni"){
			$userData = Pengguna::with(['testimoni' => function($q){
				$q->with(['users']);
			}])->where('id_user', '=', $tailor_id)->get();
			return response()->json($userData);
		}
		else if($mode == "portofolio"){
			$userData = Pengguna::with(['portofolio'])
				->where('id_user', '=', $tailor_id)->get();
			return response()->json($userData[0]->portofolio);
		}
		else if($mode == "about"){
			$userData = Pengguna::where('id_user', '=', $tailor_id)->get();
    		$index = $this->tailorRate($tailor_id);
			return response()->json([
    			'data' => $userData,
    			'ratting' => $index
    		]);
		}
	}

	public function project_detail($mode, $project_id){
		$project = $tailorProject = "";

		$projectData = Project::where('id_proyek', '=', $project_id)->get();
		$sizeMode = $projectData[0]->mode_pengukuran;

		if($sizeMode == "standart" || $sizeMode == "Standart"){
			$project = Project::with(['stdSize'])
					->where('id_proyek', '=', $project_id)->get();
		}
		else if($sizeMode == "customize" || $sizeMode == "Customize"){
			$project = Project::with(['customSize'])
					->where('id_proyek', '=', $project_id)->get();
		}
		
		if($mode != "draf"){
			$tailorProject = Project::with(['users'])
				->where('id_proyek', '=', $project_id)->get();
		}else{
			$tailorProject = "";
		}

		return response()->json([
			'data' => $project,
			'tailorData' => $tailorProject
		]);
	}

	public function publishProject($project_id){
		$upProject = Project::where('id_proyek', '=', $project_id)
				->update(['status' => 'pending']);

		return response()->json($upProject);
	}

	public function saveImages(Request $req, $prefix){
		$images = $req->file('foto');
		$imgRefID = $req->input('itemPakaian');

		if(!empty($images)){
			foreach($images as $image){
				$imgName = $image->getClientOriginalName();
				// echo dd($image);
				$imgSave = new Images;
				$imgSave->images = $imgName;
				$imgSave->id_item = $imgRefID;
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
		
		return response()->json($upProject);
	}

	public function changePassword(Request $req, $token){
		$passData = $req->all();
        $validator = $this->passValidator($passData);

		$loggedInUser = UserToken::where('token', '=', $token)->get();
		$getID = $loggedInUser[0]['id_user'];

		$salted 	= $this->createSalt();
		$hash 		= hash('sha256', $passData['newpass']);
		$passData['newpass']  = hash('sha256', $salted.$hash);
		
		$upUser = Pengguna::where('id_user', '=', $getID)
				->update([
					'password' => $passData['newpass'],
					'salt' => $salted
				]);

		return response()->json($upUser);
	}

	public function changeImageProfile(Request $req, $token){
		$files = $req->file('img');
		$imgName = $files->getClientOriginalName();

		$loggedInUser = UserToken::where('token', '=', $token)->get();
		$getID = $loggedInUser[0]['id_user'];

		$this->upload($files);

		$upUser = Pengguna::where('id_user', '=', $getID)
				->update(['foto' => $imgName]);

		return response()->json($upUser);
	}

	public function bid_list($project_id){
		$rattingList = [];

		$bill = Bills::whereRaw('id_proyek = ? AND status_konfirmasi = ?', [$project_id, 0])->get();
		$hasBill = count($bill);

		//cek apakah proyek tsb sudah melakukan konfirmasi atau tidak
		if($hasBill == 1){
			//jika ya, tampilkan penjahit terpilih
			$daftarPenawar = BidList::with(['proyek'])
						->with(['penjahit'])
						->whereRaw('id_proyek = ? AND dipilih = ?', [$project_id, 1])
						->orderBy('harga', 'asc')
						->get();
		}else{
			//jika tidak, tampilkan penjahit yang belumterpilih
			$daftarPenawar = BidList::with(['proyek'])
					->with(['penjahit'])
					->whereRaw('id_proyek = ? AND dipilih = ?', [$project_id, 0])
					->orderBy('harga', 'asc')
					->get();
		}

		// echo $tailor_id = $daftarPenawar[0]->penjahit->id_user;
		foreach($daftarPenawar as $list){
			$tailor_id = $list->penjahit->id_user;
			$index = [
				'id_user' => $tailor_id,
				'index' => $this->tailorRate($tailor_id)
			];
			array_push($rattingList, $index);
		}

		return response()->json([
			'data' => $daftarPenawar,
			'ratting' => $rattingList
		]);
	}

	public function theBidder(Request $req){
		$data = $req->all();
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
		
		return response()->json($idProyek);
	}

	public function sendTestimoni(Request $req, $token){
		$data = $req->all();

		$loggedInUser = UserToken::where('token', '=', $token)->get();
		$getID = $loggedInUser[0]['id_user'];

		$data = $req->all();

		$idPenjahit = $data['id_penjahit'];
		$ratting 	= $data['star'];
		$komentar 	= $data['komentar'];

		$newTesti =  Testimonial::create([
			'ratting' 		=> $ratting,
			'komentar' 		=> $komentar,
			'id_penjahit' 	=> $idPenjahit,
			'id_konsumen' 	=> $getID,
			'status_terbit' => 0
		]);

		return response()->json($newTesti);
	}

	public function sendReture(Request $req, $token, $idp){
		$data = $req->all();
		$idPenjahit	= $data['id_penjahit'];
		$komentar 	= $data['komentar']; 
		
		$loggedInUser = UserToken::where('token', '=', $token)->get();
		$getID = $loggedInUser[0]['id_user'];

		$newPorto = Reture::create([
			'deskripsi' => $komentar,
			'id_penjahit' => $idPenjahit,
			'id_konsumen' => $id_user,
			'id_proyek' => $idp
		]);
	}

	public function report_tailor(Request $req){
		$data = $req->all();

		$content = $data['konten'];
		$tailor_id = $data['id_penjahit'];

		$report_abuse =  Abuse::create([
            'konten' => $content,
            'id_penjahit' => $tailor_id
        ]);

		return response()->json($report_abuse);
	}
}
