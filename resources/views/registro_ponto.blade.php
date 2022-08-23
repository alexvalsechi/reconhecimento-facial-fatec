@extends('base')

@section('titulo')
    Registro Ponto
@endsection

@section('conteudo')
    <form enctype="multipart/form-data" action="{{route('registrar')}}" method="POST" autocomplete="off">
        <div class="grid grid-cols-12">
            <div class="col-span-9">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6 ">
                        <video class="" autoplay id="video"></video>
                        <canvas style="width:100%;display:none;" id="canvas"></canvas>
                        <img id="capturar_foto" style="display:none;width:100%;" class="responsive" />
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-center">
                    <button onclick="capturarFoto()" type="button"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Registrar
                        ponto</button>
                </div>
            </div>
            <div class="col-span-3">
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
                        <td>{{$ponto->data_entrada != null ? \Carbon\Carbon::parse($ponto->data_entrada)->format('d/M/Y H:i:s') : '-'}}</td>
                      </tr>
                      <tr>
                        <td>Entrada almoço</td>
                        <td>{{$ponto->data_entrada_almoco != null ? \Carbon\Carbon::parse($ponto->data_entrada_almoco)->format('d/M/Y H:i:s') : '-'}}</td>
                      </tr>
                      <tr>
                        <td>Saida almoço</td>
                        <td>{{$ponto->data_saida_almoco != null ? \Carbon\Carbon::parse($ponto->data_saida_almoco)->format('d/M/Y H:i:s') : '-'}}</td>
                      </tr>
                      <tr>
                        <td>Saida</td>
                        <td>{{$ponto->data_saida != null ? \Carbon\Carbon::parse($ponto->data_saida)->format('d/M/Y H:i:s') : '-'}}</td>
                      </tr>
                    </tbody>
               </table>
            </div>
            <input type="hidden" name="arquivo" id="arquivo" />
        </div>
        @csrf
    </form>
    <script>
        let canvas = document.getElementById('canvas');
        let arquivo = document.getElementById('arquivo');
        async function capturarFoto() {
            canvas.width = 1024;
            canvas.height = 728;
            canvas.getContext('2d').drawImage(video, 0, 0, 1024, 728);

            $("#capturar_foto").attr('src', canvas.toDataURL());
            $("#capturar_foto").show();
            $("#canvas").hide();
            $("#video").hide();

            arquivo.value = canvas.toDataURL('image/png');
            $("form").submit();


        }

        function handleStream(stream) {
            let video = document.getElementById('video');
            video.srcObject = stream;

            video.play();
        }
        $(async function() {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: 1024,
                    height: 728,
                    aspectRatio: 16 / 9
                }
            });
            handleStream(stream);
        });

        @if ($errors->any())
            alert("{{$errors->first()}}");
        @endif
    </script>
@endsection
