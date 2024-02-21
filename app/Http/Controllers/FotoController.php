<?php

namespace App\Http\Controllers;

use App\Models\Coment;
use App\Models\Foto;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{
    public function upload(Request $request)
    {
        $foto = new Foto();
        $foto->judul = $request->judul;
        $foto->deskripsi = $request->deskripsi;
        $foto->user_id = Auth::user()->id;
        if ($request->file('foto')) {
            $request->file('foto')->move('img/', $request->file('foto')->getClientOriginalName());
            $foto->foto = $request->file('foto')->getClientOriginalName();
        }

        $foto->save();

        return redirect("/");
    }

    public function index()
    {
        $data = Foto::get();

        return view('page.home', compact('data'));
    }

    public function album()
    {
        $userId = auth()->id();
        $data = Foto::where('user_id', $userId)->get();
        return view('page.album', compact('data'));
    }


    public function detail($id)
    {
        $data = Foto::find($id);
        $comentar = Coment::where("foto_id", $data->id)->get();
        $liked = Like::where('foto_id', $data->id)
            ->get();

        return view("page.detail", compact('data', 'comentar', 'liked'));
    }

    public function hapus_foto($id)
    {
        $foto = Foto::find($id);
        $foto->delete();

        return redirect("/");
    }

    public function coment(Request $request, $id)
    {

        $data = Foto::find($id);

        Coment::create([
            "user_id" => Auth::user()->id,
            "foto_id" => $data->id,
            "comentar" => $request->comentar
        ]);

        return back();
    }

    public function like(Request $request, $id)
    {
        $request->validate([
            "user_id" => 'required',
        ]);


        $foto = Foto::find($id);

        if (!$foto) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan');
        }

        $like = Like::create([
            'user_id' => $request->user_id,
            'foto_id' => $foto->id,
            'liked' => true
        ]);

        if ($like) {
            return redirect()->back()->with('success', 'Like berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan like');
        }
    }
    public function unlike(Request $request, $id)
    {
        $request->validate([
            "user_id" => 'required',
        ]);

        $foto = Foto::find($id);

        if (!$foto) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan');
        }

        $like = Like::where('user_id', $request->user_id)
            ->where('foto_id', $foto->id)
            ->delete();

        if ($like) {
            return redirect()->back()->with('success', 'Unlike berhasil');
        } else {
            return redirect()->back()->with('error', 'Gagal melakukan unlike');
        }
    }
}
