<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\pengaduan;
use App\Models\pengirim;
use App\Models\kategori_artikel;
use App\Models\artikel;

class HomepageController extends Controller
{
    //
	public function index(){
		$artikel = artikel::orderBy('created_at', 'DESC')->with('foreign_kategori')->get();
		return view('layouts.homepage.index', compact('artikel'));
	}
	public function detailartikel($id){
		$artikelterbaru = artikel::orderBy('id','DESC')->limit(5)->get();
		$artikel = artikel::with('foreign_kategori')->find($id);
		return view('layouts.homepage.detailartikel', compact('artikel','artikelterbaru'));
	}

	public function artikel(){
        $artikel = artikel::all();
		return view('layouts.homepage.artikel', compact('artikel'));    
	}  
	
	public function cariartikel(Request $request){
//        $modul = modul::paginate(2);
		$datacari = $request->input('cari');
		$artikel = artikel::where('judul_artikel','like',"%".$datacari."%")->paginate(2);
		return view('layouts.homepage.artikel', compact('artikel'));    
	}  	

	public function tampilpengaduan(){
		return view('layouts.homepage.pengaduan');
	}	
	
	public function tambahpengaduan(Request $request){
		
			//$datauser_aktif = Auth::user()->id;	

			$nama_file_ktp = $request->ktp;			
			$file_ktp = time().rand(100,999).".".$nama_file_ktp->getClientOriginalName();			
		
			$pengirim = new pengirim();
			$pengirim->nama = $request->input('name');
			$pengirim->nik = $request->input('nik');
			$pengirim->email = $request->input('email');
			$pengirim->alamat = $request->input('alamat');
			$pengirim->no_telp = $request->input('no_telp');
			$pengirim->pekerjaan = $request->input('pekerjaan');
			$pengirim->ktp = $file_ktp;
			$pengirim->save();
			
			$nama_file_pendukung = $request->file_pendukung;			
			$file_pendukung = time().rand(100,999).".".$nama_file_pendukung->getClientOriginalName();			
		
			$pengaduan = new pengaduan();
			$pengaduan->judul_pengaduan = $request->input('judul_pengaduan');
			$pengaduan->jenis_pengaduan = $request->input('jenis_pengaduan');
			$pengaduan->isi_pengaduan = $request->input('isi_pengaduan');
			$pengaduan->status_pengaduan = 'PROSES';
			$pengaduan->file_pendukung = $file_pendukung;
			$pengaduan->id_pengirim  = $pengirim->id ;
			$pengaduan->save();
			
			$nama_file_pendukung->move(public_path().'/file_pendukung/', $file_pendukung);
			$nama_file_ktp->move(public_path().'/foto_ktp/', $file_ktp);
			return redirect()->route('homepage.pengaduan')->with('success', 'Berhasil Menambah Data');
	}	
	
}
