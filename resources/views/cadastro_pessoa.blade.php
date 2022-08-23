@extends('base')

@section('titulo')
    Cadastro Pessoa
@endsection

@section('conteudo')
<form  enctype="multipart/form-data" action="{{action('App\Http\Controllers\UsuarioController@salvar')}}" method="POST" autocomplete="off">
    <div class="shadow overflow-hidden sm:rounded-md">
      <div class="px-4 py-5 bg-white sm:p-6">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-3 md:col-span-2">
                <label for="email" class="block text-md font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="px-2 mt-1 h-8 leading-4 focus:ring-indigo-500 block w-full shadow-md md:text-md border-indigo-300">
          </div>
          <div class="col-span-3 md:col-span-2">
            <label for="nome" class="block text-md font-medium text-gray-700">Nome</label>
            <input type="text" name="nome" id="nome" class="px-2 mt-1 h-8 leading-4 focus:ring-indigo-500 block w-full shadow-md md:text-md border-indigo-300">
          </div>
          <div class="col-span-3 md:col-span-2">
            <label for="senha" class="block text-md font-medium text-gray-700">Senha</label>
            <input type="password" name="senha" id="senha" class="px-2 mt-1 h-8 leading-4 focus:ring-indigo-500 block w-full shadow-md md:text-md border-indigo-300">
          </div>

        </div>
      </div>
      <div class="px-4 py-5 bg-white sm:p-6">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-3 md:col-span-2">
                <label for="departamento" class="block text-md font-medium text-gray-700">Departamento</label>
                <select name="departamento">
                    <option value="">Selecione</option>
                    <option value="TI">TI</option>
                    <option value="DIRETORIA">Diretoria</option>
                    <option value="FINANCEIRO">Financeiro</option>
                    <option value="CONTABIL">Contábil</option>
                </select>
          </div>

        </div>
      </div>
      <div class="px-4 py-4 bg-gray-80" >
        <div>
            <label class="block text-sm font-medium text-gray-700"> Foto </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
              <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                  <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                  <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <span>Suba o arquivo</span>
                    <input id="file-upload" name="foto" type="file" class="sr-only">
                  </label>
                  <p class="pl-1">ou arraste</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
              </div>
            </div>
          </div>
      </div>
      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Enviar</button>
      </div>
    </div>
    @csrf
  </form>
@endsection
