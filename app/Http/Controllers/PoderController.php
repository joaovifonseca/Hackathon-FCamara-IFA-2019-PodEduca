<?php

namespace App\Http\Controllers;

use App\Poder;
use App\Missoes;
use Illuminate\Http\Request;

class PoderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request) {
        $poderes = $this->listar();

        $message = $request->session()->get('message');
        $request->session()->remove('message');

        return view("dashboard.admin.poderes.listar", compact('poderes', 'message'));
    }

    public function participantePoderes(Request $request) {
        $poderes = $this->listar();

        return view("dashboard.participante.poderes", compact('poderes', 'poderes'));
    }

    public function cadastrarForm() {
        $poder = new Poder();
        return view("dashboard.admin.poderes.cadastrar", compact('poder', $poder));
    }

    public function cadastrar(Request $request) {
        Poder::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'icone_url' => $request->icone_url,
        ]);

        return redirect()->route('poder.listar');
    }

    public function remover($id) {
        $Poder = Poder::find($id);
        $Poder->delete();
        return redirect()->route('poder.listar');
    }

    public function editarForm($id) {
        $poder = Poder::find($id);
        return view('dashboard.admin.poderes.cadastrar', compact('poder', $poder));
    }

    public function editar(Request $request, $id) {
        $Poder = Poder::find($id);
        $Poder->nome            = $request->nome;
        $Poder->descricao             = $request->descricao;
        $Poder->icone_url      = $request->icone_url;
        $Poder->save();
        return redirect()->route('poder.listar');
    }

    public function perfil($id) {
        $poder = Poder::find($id);
        $missoes = Missoes::where('poder_id', $id)->get();
        return view('dashboard.participante.poder', compact('poder', $poder), compact('missoes', $missoes));
    }

    private function listar() {
        return Poder::all(); 
    }

    public function listarJSON() {
        $teste = Poder::all();
        return $teste; 
    }
}
