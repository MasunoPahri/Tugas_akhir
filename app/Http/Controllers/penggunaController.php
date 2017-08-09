<?php namespace App\Http\Controllers;

use DB;
use Mail;   
use App\Http\Requests;
use App\Pengguna as Pengguna;
use App\SkillPenjahit as Skills;
use App\Testimonial as Testimoni;
use App\Portofolio as Portofolio;
use App\ReportAbuse as Abuse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class penggunaController extends Controller {

	public function tailorList(Request $req, $prefix){
		$v = session('userSession');
		$s = session('username');

		$penjahit = Pengguna::whereRaw('status_aktif = ? and peran = ?', [1, "penjahit"])->get();
		
		if($prefix == "WEB"){
			return view('content.list_penjahit',[
				'user' => $s,
				'sess' => $v,
				'tailors' => $penjahit,
			]);
		}else if($prefix == "API"){
			return response()->json(['data' => $penjahit]);
		}
	}

	public function doRegister(Request $req, $prefix){
		$userdata = $req->all();
        $validator = $this->validator($userdata);

		if($validator->passes()){
			$user = $this->create($userdata)->toArray();
			if($prefix == "WEB"){	
				return redirect('/block/complete-data/'.$userdata['username']);
			}
			else if($prefix == "API"){
				return response()->json([$user]);
			}
		}else{
			Session::flash('message', "Pendaftaran Gagal!");
			return back();
		}	

	}

	public function createSalt(){
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 8);
	}
	
    protected function validator(array $data){
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:tb_pengguna',
            'pwd' => 'required|min:6',
			'repwd' => 'required|min:6|same:pwd'
        ]);
    }
	
    protected function create(array $data){
		$salted 	= $this->createSalt();
		$hash 		= hash('sha256', $data['pwd']);
		$hashedPwd  = hash('sha256', $salted.$hash);

        return Pengguna::create([
            'nama_user' => $data['username'],
            'email' => $data['email'],
            'password' => $hashedPwd,
			'salt' => $salted,
			'peran' => $data['role']
        ]);
    }

	public function viewProfile(Request $req, $prefix, $user){
		$v = session('userSession');
		$s = session('username');
		$tempScore = [];
		$getPortofolio = $idPenjahit = "";
		$getTestimoni = $getTestimoni2 = "";
		$jlh_user = $jlhTestimoni = $highest_score = $total_score =  $index = 0;

		if(is_numeric($user)){
			$mode = "tailorProfile";
			
			//AMBIL ID PENJAHIT
			$userData = Pengguna::where('id_user', '=', $user)->get();
			$idPenjahit = $userData[0]->id_user;

			//HITUNG JUMLAH KONSUMEN YANG MEMBERIKAN TESTIMONI TERHADAP PENJAHIT 'X'
			$getTestimoni = Testimoni::with(['users'])
					->whereRaw('id_penjahit = ? AND status_terbit = ?', [$idPenjahit, 1])->get();
			$jlhTestimoni = count($getTestimoni);

			//CEK APAKAH PENJAHIT MEMILIKI TESTIMONI
			if($jlhTestimoni > 0){
				//LALU HITUNG NILAI INDEX TERTINGGI
				$highest_score = 5 * $jlhTestimoni; 

				//HITUNG JUMLAH KONSUMEN PER SUB PENILAIAN(Sangat Buruk, Buruk, Biasa, Bagus, Sangat Bagus)
				for($i = 1; $i <= 5; $i++){
					$getTestimoni2 = Testimoni::where('id_penjahit', '=', $idPenjahit);
					$user = $getTestimoni2->where('ratting', '=', $i)->count('id_konsumen');
					$temp = $user * $i;
					array_push($tempScore, $temp);
				}

				//JUMLAHKAN SUB PENILAIAN
				$total_score = array_sum($tempScore);

				//HITUNG INDEX PERSENTASE
				$index = ($total_score / $highest_score) * 100;

			}
		}else{
			$mode = "myProfile";
			$userData = Pengguna::where('nama_user', '=', $user)->get();
		}

		// echo dd($total_score);
		
		if($prefix == "WEB"){
			return view('content.profile',[
				'user' => $s,
				'sess' => $v,
				'mode' => $mode,
				'index' => $index,
				'tailor_id' => $idPenjahit,
				'userDetail' => $userData[0],
				'testimoni' => $getTestimoni,
				'portofolio' => $getPortofolio,
				'jlhPenilai' => $jlhTestimoni
			]);
		}else if($prefix == "API"){
			return response()->json(['data' => $userData]);
		}
	}
	
	public function editProfile(Request $req, $prefix, $user){
		$data = $req->all();

		$idUser 	= $data['id_user'];
		$username 	= $data['username'];
		$alamat 	= $data['alamat'];
		$email 		= $data['email'];
		$phone 		= $data['no_telp'];
		
		Pengguna::where('id_user', '=', $idUser)
				->update([
					'nama_user'	=> $username,
					'alamat' 	=> $alamat,
					'email' 	=> $email,
					'no_telp' 	=> $phone
				]);

		return redirect('/WEB/profile/'.$username);
	}

	public function changePassword(Request $req, $prefix, $user){
		$passData = $req->all();
        $validator = $this->passValidator($passData);

		$salted 	= $this->createSalt();
		$hash 		= hash('sha256', $passData['newpass']);
		$passData['newpass']  = hash('sha256', $salted.$hash);
		
		$upUser = Pengguna::where('nama_user', '=', $user)
				->update([
					'password' => $passData['newpass'],
					'salt' => $salted
				]);
		
		return redirect('/WEB/profile/'.$user);
	}
	
	protected function passValidator(array $data){
        return Validator::make($data, [
            'newpass' => 'required|min:6',
			'repass'  => 'required|min:6|same:newpass'
        ]);
    }

	public function changeImageProfile(Request $req, $prefix, $user){
		$files = $req->file('img');
		$imgName = $files->getClientOriginalName();

		$this->upload($files);

		$upUser = Pengguna::where('nama_user', '=', $user)
				->update(['foto' => $imgName]);

		return redirect('/WEB/profile/'.$user);
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
	
	public function block(Request $req, $mode, $user){
		if($mode == "complete-data"){
			$skills = Skills::all();
			
			$userData = Pengguna::where('nama_user', '=', $user)->get();
			$role = $userData[0]->peran;

			return view('complete_data',[
				'role' => $role,
				'user' => $user,
				'skills' => $skills
			]);
		}
		else if($mode == "completed-data"){
			$data = $req->all();
			
			$alamat = $data['alamat'];
			$phone = $data['phone'];

			$files = $req->file('img');

			$imgName = $this->upload($files);

			$upUser = Pengguna::where('nama_user', '=', $user)
					->update([
						'alamat' => $alamat,
						'no_telp' => $phone,
						'foto' => $imgName,
						'status_aktif' => 1
					]);

			if($upUser){
				Session::flash('completed_user', "Berhasil disimpan! Silahkan login kembali");
				return redirect('/form/login');
			}else{
				Session::flash('message', "Gagal disimpan!");
				return redirect('/block/complete-data');
			}
			
		}
	}

	public function report_tailor(Request $req){
		$data = $req->all();
		$content = $data['konten'];
		$tailor_id = $data['id_penjahit'];

		$report_abuse =  Abuse::create([
            'konten' => $content,
            'id_penjahit' => $tailor_id
        ]);
		
		if($report_abuse)
			Session::flash('report_abuse', "Laporan berhasil dikirimkan!");
			return back();
			
		App::abort(500);

	}

}
