@extends('base')

@section('titulo')
Editar ponto do {{$registro->usuario->name}} - {{\Carbon\Carbon::parse($registro->dia)->format('d/M/Y')}}
@endsection

@section('conteudo')
    <form action="{{action('App\Http\Controllers\RegistroController@update',array('registro' => $registro))}}" method="POST" autocomplete="off">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-4 bg-gray-80">
                <div>
                    <table>
                        <table class="table-auto text-xl">
                            <thead>
                              <tr>
                                <th>Etapa</th>
                                <th>Horário</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Entrada</td>
                                <td><input type="datetime-local" name="data_entrada" value="{{$registro->data_entrada != null ? $registro->data_entrada : ''}}" ></td>
                              </tr>
                              <tr>
                                <td>Entrada almoço</td>
                                <td><input type="datetime-local" name="data_entrada_almoco" value="{{$registro->data_entrada_almoco != null ? $registro->data_entrada_almoco : ''}}" ></td>
                              </tr>
                              <tr>
                                <td>Saida almoço</td>
                                <td><input type="datetime-local" name="data_saida_almoco" value="{{$registro->data_saida_almoco != null ? $registro->data_saida_almoco : ''}}" ></td>
                              </tr>
                              <tr>
                                <td>Saida</td>
                                <td><input type="datetime-local" name="data_saida" value="{{$registro->data_saida != null ? $registro->data_saida : ''}}" ></td>
                              </tr>
                            </tbody>
                       </table>

                    </table>
                    <input type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"

                    value="Salvar"/>

                </div>
            </div>
        </div>
        @csrf
    </form>

@endsection
