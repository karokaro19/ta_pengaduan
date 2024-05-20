<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//user
use Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\notifselesai;

use App\Models\pengaduan;
use App\Models\pengirim;
use App\Models\kategori_artikel;
use App\Models\artikel;

class AdminController extends Controller
{
    //
	
	public function Home(){
		
		$tahun = date('Y');
		$pengaduan = pengaduan::with('foreign_pengirim')->where('status_pengaduan','PROSES')->limit(5)->get();		
		$pengajuan_suratcount1 = pengaduan::whereMonth('created_at','1')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount2 = pengaduan::whereMonth('created_at','2')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount3 = pengaduan::whereMonth('created_at','3')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount4 = pengaduan::whereMonth('created_at','4')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount5 = pengaduan::whereMonth('created_at','5')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount6 = pengaduan::whereMonth('created_at','6')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount7 = pengaduan::whereMonth('created_at','7')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount8 = pengaduan::whereMonth('created_at','8')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount9 = pengaduan::whereMonth('created_at','9')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount10 = pengaduan::whereMonth('created_at','10')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount11 = pengaduan::whereMonth('created_at','11')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();
        $pengajuan_suratcount12 = pengaduan::whereMonth('created_at','12')->where('status_pengaduan', 'SELESAI')->whereYear('created_at',$tahun)->count();			
		
		$countpengajuanselesai = pengaduan::where('status_pengaduan', 'SELESAI')->count();
		$countpengajuandiproses = pengaduan::where('status_pengaduan', 'PROSES')->count();		
		return view('layouts.admin.home', compact('pengaduan','pengajuan_suratcount1','pengajuan_suratcount2'
		,'pengajuan_suratcount3','pengajuan_suratcount4','pengajuan_suratcount5',
		'pengajuan_suratcount6','pengajuan_suratcount7','pengajuan_suratcount8',
		'pengajuan_suratcount9','pengajuan_suratcount10','pengajuan_suratcount11',
		'pengajuan_suratcount12','tahun','countpengajuanselesai','countpengajuandiproses'));
	}
	
	public function tampilpengaduan(){
		$pengaduan = pengaduan::with('foreign_pengirim')->where('status_pengaduan','PROSES')->get();
		return view('layouts.admin.tampilpengaduan', compact('pengaduan'));
	}	

	public function detailpengaduan($id){
		$pengaduan = pengaduan::with('foreign_pengirim')->find($id);
		return view('layouts.admin.detailpengaduan', compact('pengaduan'));
	}

	public function tambahrespon(Request $request){
       $ubh = pengaduan::findorfail($id);
	   $detailpengirim = pengaduan::with('foreign_pengirim')->find($id);
           $dt = [
               'respon' => $request['respon'],
               'status_pengaduan' => 'SELESAI',
           ];	
           $ubh->update($dt);
		   
			$isimail = [
				'title' => 'Informasi Terkait Pengaduan Yang di ajukan',
				'body' => 'Notifikasi Pengajuan Surat Telah Selesai',
				'judul ' => $ubh->judul_pengaduan,
				'jenis_pengaduan' => $ubh->jenis_pengaduan,
				'isi_pengaduan' => $ubh->isi_pengaduan,
				'tanggal_dikirim' => $ubh->created_at
			];		
			$tujuan = $detailpengajuan->email;
			Mail::to($tujuan)->send(new notifselesai($isimail));		   
		  
            return redirect()->route('pengaduan.home')->with('success', 'Pengaduan Berhasil Direspon');
	}	
	
	public function tampilarsip(){
		$pengaduan = pengaduan::with('foreign_pengirim')->where('status_pengaduan','SELESAI')->get();
		return view('layouts.admin.tampilarsip', compact('pengaduan'));
	}	
	
	public function detailarsip($id){
		$pengaduan = pengaduan::with('foreign_pengirim')->find($id);
		return view('layouts.admin.detailarsip', compact('pengaduan'));
	}	
	
	//mulai kategori
	
	public function tampilkategori(){
		$kategori_artikel = kategori_artikel::all();
		return view('layouts.admin.tampilkategori', compact('kategori_artikel'));
	}	
	
	public function tambahkategori(){
		return view('layouts.admin.tambahkategori');
	}		
	
	public function prosestambahkategori(Request $request){
			$kategori_artikel = new kategori_artikel();
			$kategori_artikel->nama_kategori = $request->input('nama_kategori');
			$kategori_artikel->hastag_kategori = $request->input('hastag_kategori');
			$kategori_artikel->save();
			return redirect()->route('kategori.home')->with('success', 'Berhasil Menambah Data');
	}
	
   public function editkategori($id)
   {
       $kategori_artikel = kategori_artikel::find($id);
       return view('layouts.admin.editkategori', compact('kategori_artikel'));		
   }  	
	
   public function prosesupdatekategori(Request $request, $id)
   {
       $ubh = kategori_artikel::findorfail($id);
           $dt = [
               'nama_kategori' => $request['nama_kategori'],
               'hastag_kategori' => $request['hastag_kategori'],
           ];	
           $ubh->update($dt);
           return redirect()->route('kategori.home')->with('success', 'Data Berhasil di ubah');	
   } 	
   
	public function hapuskategori($id){
		$kategori_artikel = kategori_artikel::find($id);
		$kategori_artikel->delete(); 		
		return redirect()->route('kategori.home')->with('success', 'Data Berhasil di hapus');
	}

	// Mulai artikel
	
	public function tampilartikel(){
		$artikel = artikel::with('foreign_kategori')->get();
		return view('layouts.admin.tampilartikel', compact('artikel'));
	}	
	
	public function tambahartikel(){
		$kategori_artikel = kategori_artikel::all();
		return view('layouts.admin.tambahartikel', compact('kategori_artikel'));
	}		
	
	public function prosestambahartikel(Request $request){
		
			$datauser_aktif = Auth::user()->id;
			
			$request->validate([
				'gambar_artikel' => 'mimes:jpeg,bmp,png,gif,svg,pdf|max:2048',
			]);		
			
			$nama_file = $request->gambar_artikel;			
			$filegambar = time().rand(100,999).".".$nama_file->getClientOriginalName();			
		
			$artikel = new artikel();
			$artikel->judul_artikel = $request->input('judul_artikel');
			$artikel->isi_artikel = $request->input('isi_artikel');
			$artikel->users = $datauser_aktif;
			$artikel->gambar_artikel = $filegambar;
			$artikel->kategori = $request->input('kategori');
			$artikel->save();
			
			$nama_file->move(public_path().'/gambarartikel/', $filegambar);
			return redirect()->route('artikel.home')->with('success', 'Berhasil Menambah Data');
	}
	
   public function editartikel($id)
   {
       $artikel = artikel::with('foreign_kategori')->find($id);
	   $kategori_artikel = kategori_artikel::all();
       return view('layouts.admin.editartikel', compact('artikel','kategori_artikel'));		
   }  	
	
   public function prosesupdateartikel(Request $request, $id)
   {
       $ubh = artikel::findorfail($id);
	   $data_awal = $ubh->gambar_artikel;
		if ($request->gambar_artikel == '')
		{	   
           $dt = [
               'judul_artikel' => $request['judul_artikel'],
               'isi_artikel' => $request['isi_artikel'],
               'kategori' => $request['kategori'],
           ];	
           $ubh->update($dt);
           return redirect()->route('artikel.home')->with('success', 'Data Berhasil di ubah');	
		}
		else {
		   
			$request->validate([
				'gambar_artikel' => 'mimes:jpeg,bmp,png,gif,svg,pdf|max:2048',
			]);				   
		   			
           $dt = [
               'judul_artikel' => $request['judul_artikel'],
               'isi_artikel' => $request['isi_artikel'],
               'gambar_artikel' => $data_awal,
               'kategori' => $request['kategori'],
           ];	
		   $request->gambar_artikel->move(public_path().'/gambarartikel/', $data_awal);
           $ubh->update($dt);
           return redirect()->route('artikel.home')->with('success', 'Data Berhasil di ubah');				
		}
   } 	
   
	public function hapusartikel($id){
		$artikel = artikel::find($id);
		$artikel->delete(); 		
		return redirect()->route('artikel.home')->with('success', 'Data Berhasil di hapus');
	}	
	
}
