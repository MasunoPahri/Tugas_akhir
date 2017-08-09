<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project as Project;
use App\Billing as Bills;
use App\Pengguna as Pengguna;

use Illuminate\Http\Request;

class billingController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$v = session('userSession');
		$s = session('username');

		$pengguna = Pengguna::where('nama_user', '=', $s)->get();
		$id_user = $pengguna[0]['id_user'];

		$proyek = Project::with(['bills'])
			->where('id_konsumen', '=', $id_user)->get();
		// echo dd($proyek[0]->bills);
		if(count($proyek) > 0){
			return view('content.pembayaran',[
				'user' => $s,
				'sess' => $v,
				'bills' => $proyek
			]);
		}else{
			return view('errors.404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($prefix, $idp)
	{
		//TAMPLIKAN HALAMAN KONFIRMASI
		$v = session('userSession');
		$s = session('username');

		$bills = Bills::where('id_proyek', '=', $idp)->get();
		$noInvoice = $bills[0]['invoice_num'];
		
		$proyek = Project::where('id_proyek', '=', $idp)->get();
		$tipe_bayar = $proyek[0]->tipe_bayar;

		// echo $noInvoice;

		return view('content.confirmBill',[
			'user' => $s,
			'sess' => $v,
			'tipeBayar' => $tipe_bayar,
			'invoice' => $noInvoice
		]);
	}

	//KONFIRMASI PEMBAYARAN OLEH ADMIN
	public function confirmed(Request $req){
		$bills = $req->all();
		$invoice = $bills['invoice_num'];
		$idp = $bills['id_proyek'];
		
		$updateBill = Bills::where('invoice_num', '=', $invoice)
					->update(['status_konfirmasi' => 1, 'ket' => 'lunas']);

		$upProjectStatus = Project::where('id_proyek', '=', $idp)
					->update(['status' => 'ongoing']);
		
		return redirect('/adminpanel/bills');
	}

	public function store(Request $req)
	{
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

		return redirect('/WEB/invoice/list');

		//JIKA PEMBAYARAN SUDAH TERKONFIRMASI
		//UBAH STATUS PROYEK MENJADI ONGOING
		//LALU, HAPUS PROYEK TAWARAN DARI PENJAHIT YANG DIPILIH

		// $proyek = Project::where('id_proyek', '=', $idProyek)
		// 				->update(['id_penjahit' => $idPenjahit, 'status' => "ongoing"]);

		// $dltOther = bidList::with(['penjahit'])
		// 			->whereRaw('dipilih = ? and id_penjahit = ?', [0, $idPenjahit])
		// 			->delete();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
