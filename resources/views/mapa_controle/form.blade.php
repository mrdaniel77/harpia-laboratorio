@include('layout.header')
@include('layout.navbar')
@include('layout.sidebar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ isset($mapa_controle) ? 'Editar' : 'Novo' }} Mapa de Controle de Registros</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/mapa_controle">Mapa de Controle de Registros</a></li>
            <li class="breadcrumb-item active">{{ isset($mapa_controle) ? 'Editar' : 'Novo' }}</li>
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
            @isset($mapa_controle)
                <a href="/mapa_controle/novo" class="btn btn-primary">
                    Novo Mapa de Controle
                    <i class="fas fa-plus"></i>
                </a>
            @endisset

  <form action="/mapa_controle/salvar" method="POST">
    @csrf
    <input type="hidden" name="id" value="@if(isset($mapa_controle)){{$mapa_controle->id}}@else{{ old('id') }}@endif">

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="codigo" class="form-label">Código:</label>
                <input type="number" name="codigo" class="form-control" required value="@if(isset($mapa_controle)){{$mapa_controle->codigo}}@else{{ old('codigo') }}@endif">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="servico">CPF</label>
                <input type="radio" class="tipo" name="tipo" id="tipo_cpf">
                <label for="servico">CNPJ</label>
                <input type="radio" class="tipo" name="tipo" id="tipo_cnpj">
                <input type="text" name="cpf_cnpj" class="form-control cpf_cnpj" id="cpf_cnpj" readonly required value="@if(isset($mapa_controle)){{$mapa_controle->cpf_cnpj}}@else{{old('cpf_cnpj')}}@endisset">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" class="form-control" value="@if(isset($mapa_controle)){{$mapa_controle->email}}@else{{old('email')}} @endif" >
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" name="telefone" class="form-control telefone" value="@if(isset($mapa_controle)){{$mapa_controle->telefone}}@else{{ old('telefone') }}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="cep" class="form-label">CEP:</label>
                <input type="text" name="cep" class="form-control cep" value="@if(isset($mapa_controle)){{$mapa_controle->cep}}@else{{old('cep')}}@endif">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="logradouro" class="form-label">Logradouro:</label>
                <input type="text" name="logradouro" class="form-control" value="@if(isset($mapa_controle)){{$mapa_controle->logradouro}}@else{{old('logradouro')}}@endif">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="numero" class="form-label">Numero:</label>
                <input type="number" name="numero" class="form-control" value="@if(isset($mapa_controle)){{$mapa_controle->numero}}@else{{old('numero')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="cidade" class="form-label">Cidade:</label>
                <input type="text" name="cidade" class="form-control" value="@if(isset($mapa_controle)){{$mapa_controle->cidade}}@else{{old('cidade')}}@endif">
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label for="bairro" class="form-label">Bairro:</label>
                <input type="text" name="bairro" class="form-control" value="@if(isset($mapa_controle)){{$mapa_controle->bairro}}@else{{old('bairro')}}@endif">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="uf" class="form-label">UF:</label>
                <input type="text" name="uf" class="form-control" maxlength="2" value="@if(isset($mapa_controle)){{$mapa_controle->uf}}@else{{old('uf')}}@endif">
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="responsavel_tecnico" class="form-label">Responsável Técnico:</label>
                <input type="text" name="responsavel_tecnico" class="form-control" value="@if(isset($mapa_controle)){{$mapa_controle->responsavel_tecnico}}@else{{old('responsavel_tecnico')}}@endif">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="responsavel_financeiro" class="form-label">Responsável Financeiro:</label>
                <input type="text" name="responsavel_financeiro" class="form-control" value="@if(isset($mapa_controle)){{$mapa_controle->responsavel_financeiro}}@else{{old('responsavel_financeiro')}}@endif">
            </div>
        </div>
  
    </div>
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
         
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@include('layout.footer')