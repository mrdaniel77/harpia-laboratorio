@include('layout.header')
@include('layout.navbar')
@include('layout.sidebar')

<script>
    @if(isset($mapa_controle_registros) && $mapa_controle_registros->indexacao == 'alfabetica')
        .cronologica{
            display: none;
        }
    @else
        .alfabetica{
            display: none;
        }
    @endif
    </script>

<script>
    @if(isset($mapa_controle_registros) && $mapa_controle_registros->descarte == 'picotar')
        .deletar{
            display: none;
        }
    @else
        .picotar{
            display: none;
        }
    @endif
    </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ isset($mapa_controle_registros) ? 'Editar' : 'Novo' }} Mapa de Controle de Registros</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/mapa_controle">Mapa de Controle de Registros</a></li>
            <li class="breadcrumb-item active">{{ isset($mapa_controle_registros) ? 'Editar' : 'Novo' }}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
          <div class="row card">
            <div class="col card-body">

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br/>
                    @endforeach
                </div>
            @endif
            @isset($mapa_controle_registros)
                <a href="/mapa_controle/novo" class="btn btn-primary">
                    Novo Mapa de Controle
                    <i class="fas fa-plus"></i>
                </a>
            @endisset

  <form action="/mapa_controle/salvar" method="POST">
    @csrf
    <input type="hidden" name="id" value="@if(isset($mapa_controle_registros)){{$mapa_controle_registros->id}}@else{{ old('id') }}@endif">

    <div class="row">
        <div class="col-6">
            <div class="form-outline">
                <label for="codigo" class="form-label">Código:</label>
                <select name="codigo" id="codigo" class="form-control selecao" onchange="habilitaOutro(this.value)">
                    <option value="">Selecione:</option>
                    @foreach ($lista_mestra as $key => $t)
                    <option value="{{ $t->codigo }}" @if(isset($mapa_controle_registros) && $mapa_controle_registros->codigo == $t->codigo)  selected @elseif(old('codigo') == $t->codigo) selected @endif >{{$t->codigo}}</option> 
                    @endforeach
                    <option value="inserir">Outro</option>
                </select>
                <input type="text" id="outro" name="outro" style="display: none;
                float: right;
                margin-top: -37px;
                margin-right: -215px;
                padding: 5px;
                ">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-outline">
                <label for="nome" class="form-label">Nome:</label>
                <select name="nome" id="nome" class="form-control selecao">
                    <option value="">Selecione:</option>
                    @foreach ($lista_mestra as $key => $t)
                      <option value="{{ $t->titulo }}" @if(isset($mapa_controle_registros) && $mapa_controle_registros->nome == $t->titulo)  selected @elseif(old('nome') == $t->titulo) selected @endif >{{$t->titulo}}</option> 
                  @endforeach
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-outline">
                <label for="acesso" class="form-label">Acesso:</label>
                <select name="acesso" id="acesso" class="form-control selecao">
                    <option value="">Selecione:</option>
                    @foreach ($cargo as $key => $t)
                      <option value="{{ $t->cargo }}" @if(isset($mapa_controle_registros) && $mapa_controle_registros->acesso == $t->cargo)  selected @elseif(old('acesso') == $t->cargo) selected @endif >{{$t->cargo}}</option> 
                  @endforeach
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-outline">
                <label for="coleta" class="form-label">Coleta:</label>
                <select name="coleta" id="coleta" class="form-control selecao">
                    <option value="">Selecione:</option>
                    @foreach ($cargo as $key => $t)
                      <option value="{{ $t->cargo }}" @if(isset($mapa_controle_registros) && $mapa_controle_registros->coleta == $t->cargo)  selected @elseif(old('coleta') == $t->cargo) selected @endif >{{$t->cargo}}</option> 
                  @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-outline">
                <label for="armazenamento" class="form-label">Armazenamento:</label>
                <input type="text" name="armazenamento" class="form-control armazenamento" value="@if(isset($mapa_controle_registros)){{$mapa_controle_registros->armazenamento}}@else{{ old('armazenamento') }}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-outline">
                <label for="tempo_retencao" class="form-label">Tempo de Retencão:</label>
                <input type="text" name="tempo_retencao" class="form-control" value="@if(isset($mapa_controle_registros)){{$mapa_controle_registros->tempo_retencao}}@else{{ old('tempo_retencao') }}@endif">
            </div>
        </div>
        <div class="col-5">
            <div class="form-outline">
                <label for="responsavel" class="form-label">Responsável:</label>
                <input type="text" name="responsavel" class="form-control" value="@if(isset($mapa_controle_registros)){{$mapa_controle_registros->responsavel}}@else{{ old('responsavel') }}@endif">
            </div>
        </div>
        <div class="col-3">
            <div class="form-outline">
                <label for="data" class="form-label">Data:</label>
                <input type="date" name="data" class="form-control" value="@if(isset($mapa_controle_registros)){{$mapa_controle_registros->data}}@else{{ old('data') }}@endif">
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-6">
            <div class="form-outline">
                <label for="Indexação" class="form-label">Indexação:</label>
                <label for="cronologica" onclick="alteraTipo('cronologica')">Cronológica</label>
                <input type="radio" class="indexacao" checked name="indexacao" id="cronologica" onclick="alteraTipo('cronologica')" value="cronologica" @if(isset($mapa_controle_registros) && $mapa_controle_registros->indexacao == 'cronologica') checked @elseif(old('indexacao') == "cronologica") checked @endif>
                <label for="alfabetica" onclick="alteraTipo('alfabetica')">Alfabética</label>
                <input type="radio" class="indexacao" name="indexacao" id="alfabetica" onclick="alteraTipo('alfabetica')" value="alfabetica" @if(isset($mapa_controle_registros) && $mapa_controle_registros->indexacao == 'alfabetica') checked @elseif(old('indexacao') == "alfabetica") checked @endif>
            </div>
        </div>
        <div class="col-6">
            <div class="form-outline">
                <label for="descarte" class="form-label">Descarte:</label>
                <label for="deletar" onclick="alteraTipo('deletar')">Deletar</label>
                <input type="radio" class="descarte" checked name="descarte" id="deletar" onclick="alteraTipo('deletar')" value="deletar" @if(isset($mapa_controle_registros) && $mapa_controle_registros->descarte == 'deletar') checked @elseif(old('descarte') == "deletar") checked @endif>
                <label for="picotar" onclick="alteraTipo('picotar')">Picotar</label>
                <input type="radio" class="descarte" name="descarte" id="picotar" onclick="alteraTipo('picotar')" value="picotar" @if(isset($mapa_controle_registros) && $mapa_controle_registros->descarte == 'picotar') checked @elseif(old('descarte') == "picotar") checked @endif>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col" align="end">
            <button type="submit" class="btn btn-success w-25 hover-shadow">
                Salvar 
                <i class="fas fa-save"></i>
            </button>
        </div>
    </div>
</form>
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@include('layout.footer')

<script>
    function habilitaOutro(value) {
        if(value == 'inserir') {
            $('#outro').show();
        }
    }
</script>