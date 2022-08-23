@extends('base')

@section('titulo')
Listagem Pontos
@endsection

@section('conteudo')
    <form action="#" method="POST" autocomplete="off">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-4 bg-gray-80">
                <div>
                    <table id="pontos" class="display" style="width:100%">

                    </table>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(function () {

table = $('#pontos').DataTable({
     dom: 'Blfrtip',
     lengthMenu: [[25, 50, 100, -1], [25,50,100,'Todos']],
     processing: true,
     serverSide: true,
     ajax: "{{ action('App\Http\Controllers\RegistroController@listar_pag') }}",
     language: { url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json' },
     columns: [
         {data: 'id', name: 'id', title: 'ID'},
         {data: 'nome_usuario', name: 'nome_usuario', title:'Nome'},
         {data: 'dia', name: 'dia', title: 'Dia registro'},
         {data:'data_entrada', name:'data_entrada', title:'Data Entrada'},
         {data:'data_entrada_almoco', name:'data_entrada_almoco', title:'Data Entrada Almoço'},
         {data:'data_saida_almoco', name:'data_saida_almoco', title:'Data Saida Almoço'},
         {data:'data_saida', name:'data_saida', title:'Data Saida'},
        {data: 'opcao',  name: 'opcao', title: 'Opções'}
     ],

     search: {
     "regex": true
     }
 });

});
    </script>
@endsection
