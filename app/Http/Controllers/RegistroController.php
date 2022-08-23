<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RegistroController extends Controller
{

    public function listar_pag()
    {
        $admin = Auth::user()->admin;
        $registros = Auth::user()->admin == 1 ? \App\Models\Registro::query() : \App\Models\Registro::where('user_id', '=', Auth::user()->id);
        $registros = $registros->with('usuario');
        return DataTables::eloquent($registros)
        ->addColumn('nome_usuario', function(Registro $registro){
            return $registro->usuario->name;
        })
        ->addColumn('opcao', function(Registro $registro) use($admin){
            if($admin == 1){
            return "
                <a class=\"inline-flex justify-center py-2 px-4 font-medium rounded-md text-white\" style=\"background-color:#84cc16\" href=\"".action("App\Http\Controllers\RegistroController@edit",array('registro' => $registro))."\">Editar</a>
            ";
            }
            return '';
        })
        ->rawColumns(['opcao'])
        ->toJson();
    }
    public function listar()
    {
        return view('listagem_ponto');
    }

    public function edit(Registro $registro){
        if(Auth::user() != null && Auth::user()->admin == 0){
            return response('',401);
        }
        return view('editar_ponto', [ 'registro' => $registro ]);
    }
    public function update(Registro $registro, Request $request){
        $registro->data_entrada = $request->input('data_entrada');
        $registro->data_entrada_almoco = $request->input('data_entrada_almoco');
        $registro->data_saida_almoco = $request->input('data_saida_almoco');
        $registro->data_saida = $request->input('data_saida');
        $registro->saveOrFail();
        return redirect('/listar/ponto');
    }
    public function index()
    {
        $hoje = Carbon::now();
        $registroHoje = \App\Models\Registro::where('dia', '=', $hoje->toDateString())->where('user_id', '=', Auth::user()->id)->get()->first();

        if ($registroHoje == null) {
            $registroHoje = new \App\Models\Registro;
            $registroHoje->dia = $hoje->toDateString();
            $registroHoje->user_id = Auth::user()->id;
            $registroHoje->saveQuietly();
        }
        return view('registro_ponto', ['ponto' => $registroHoje]);
    }

    public function registrar(Request $request)
    {
        $hoje = Carbon::now();
        $registroHoje = \App\Models\Registro::where('dia', '=', $hoje->toDateString())->where('user_id', '=', Auth::user()->id)->get()->first();;
        // var_dump($request->input('arquivo'));
        if ($registroHoje->status != 'FIM') {
            $idUser = Auth::user()->id;
            $img = $request->input('arquivo');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $idUnico = uniqid($idUser);
            Storage::disk('local')->put("{$idUnico}.png", $fileData);
            $args = [
                'credentials' => [
                    'key' => env('AWS_KEY'),
                    'secret' => env('AWS_SECRET')
                ],
                'region' => 'us-east-1',
                'version' => 'latest'
            ];

            $client = new \Aws\Rekognition\RekognitionClient($args);
            $result = [];
            try {
                $result = $client->compareFaces([
                    'SimilarityThreshold' => 90,
                    'SourceImage' => [
                        'Bytes' => Auth::user()->arquivo_foto
                    ],
                    'TargetImage' => [
                        'Bytes' => Storage::disk('local')->get("{$idUnico}.png")
                    ],
                ]);
            } catch (Exception $ex) {
                return redirect('/registro-ponto')->withErrors(['msg' => 'Erro ao detectar faces.']);
            }
            if (!empty($result['FaceMatches']) && $result["FaceMatches"][0]['Similarity'] > 95.0) {

                switch ($registroHoje->status) {
                    case 'ENTRADA':
                        $registroHoje->data_entrada = Carbon::now();
                        $registroHoje->status = 'ENTRADA_ALMOCO';
                        break;
                    case 'ENTRADA_ALMOCO':
                        $registroHoje->data_entrada_almoco = Carbon::now();
                        $registroHoje->status = 'SAIDA_ALMOCO';
                        break;
                    case 'SAIDA_ALMOCO':
                        $registroHoje->data_saida_almoco = Carbon::now();
                        $registroHoje->status = 'SAIDA';
                        break;
                    case 'SAIDA':
                        $registroHoje->data_saida = Carbon::now();
                        $registroHoje->status = 'FIM';
                        break;
                }

                $registroHoje->saveQuietly();
                return redirect('/registro-ponto');
            }else if(!empty($result['UnmatchedFaces'])){
                return redirect('/registro-ponto')->withErrors(['msg' => 'rosto não identificado para este funcionário.']);
            }
        }
        return redirect('/registro-ponto')->withErrors(['msg' => 'você já registrou o dia todo, contate seu adm para alterar caso errou o registro.']);
    }
}
