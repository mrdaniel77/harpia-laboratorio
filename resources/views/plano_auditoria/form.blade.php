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
            <h1 class="m-0">{{ isset($plano_auditoria) ? 'Editar' : 'Novo' }} Plano de auditoria</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/plano_auditoria">Plano de auditoria</a></li>
            <li class="breadcrumb-item active">{{ isset($plano_auditoria) ? 'Editar' : 'Novo' }}</li>
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
          <div class="row">
            <div class="col">
              @isset($plano_auditoria->id)
             
              <a href="/plano_auditoria/novo" class="btn btn-primary">
                Novo Plano de auditoria
                <i class="fas fa-plus"></i>
              </a> 
              @endisset
              
            </div>
          </div>
          <br>
         

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

  <form action="/plano_auditoria/salvar" method="POST">
    @csrf
    <input type="hidden" name="id" value="@isset($plano_auditoria){{$plano_auditoria->id}}@endisset">
  <div class="row">
    <div class="col-5">
      <div class="form-group">
        <label for="referencia" class="form-label">Referência:</label>
        <input required type="referencia" name="referencia" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->referencia}}@else{{old('referencia')}} @endif" >
    </div>
    </div>
    <div class="col-5">
      <div class="form-group">
        <label for="setor_id" class="form-label">Nome da organização:</label>
        <select  required name="setor_id" id="setor_id" class="form-control">
          <option value="">Selecione um Responsável</option>
          @foreach($setores as $item)
            <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->setor_id == $item->id) selected @elseif(old('setor_id') == $item->id) selected @endif>{{$item->setor}}
            </option>
          @endforeach
        </select>
    </div>
    </div>
    <div class="col-2">
      <label for="setor_id" class="form-label">Novo Setor:</label>
      <a href="/setores/novo" class="btn btn-primary">
         Novo Setor
        <i class="fas fa-plus"></i>
      </a> 
    </div>
  </div>
  <div class="row">
    <div class="col-3">
      <div class="form-group">
          <label for="telefone" class="form-label">Telefone:</label>
          <input type="text" name="telefone" class="form-control telefone" value="@if(isset($plano_auditoria)){{$plano_auditoria->telefone}}@else{{ old('telefone') }}@endif">
      </div>
  </div>
  <div class="col-5">
    <div class="form-group">
        <label for="email" class="form-label">E-mail:</label>
        <input type="email" name="email" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->email}}@else{{old('email')}} @endif" >
    </div>
</div>
<div class="col-4">
  <div class="form-group">
      <label for="email" class="form-label">Avaliação:</label>
      <input type="text" name="avaliacao" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->avaliacao}}@else{{old('avaliacao')}} @endif" >
  </div>
</div>
  </div>
  <div align='center'>
    <h3>Programa da auditoria</h3>
  </div>
  <hr>
  <br>
  <div class="row">
    <div class="col-6">
      <div class="form-group">
          <label for="carregar documento:" class="form-label">Documento base:</label>
          <input type="file" name="documento" class="form-control ">
              <a href="#" target="_blank">Ver documento</a> 
      </div>
  </div>
  <div class="col-6">
    <div class="form-group">
        <label for="email" class="form-label">Requisitos a serem avaliados:</label>
        <input type="text" name="requisitos" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->requisitos}}@else{{old('requisitos')}} @endif" >
    </div>
  </div>      
  </div>
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <label for="objetivo">Objetivo da auditoria:</label>
        <textarea class="form-control" id="objetivo" name="objetivo"  rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->objetivo}}@else{{ old('objetivo')}}@endif</textarea>
      </div>
    </div>
    <div class="col-6">
      <div class="form-group">
        <label for="abg_programa">Abrangência do programa:</label>
        <textarea class="form-control" id="abg_programa" name="abg_programa"  rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->abg_programa}}@else{{ old('abg_programa')}}@endif</textarea>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="riscos">Riscos do programa:</label>
        <textarea class="form-control" id="riscos" name="riscos"  rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->riscos}}@else{{ old('riscos')}}@endif</textarea>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <div  class="form-group">
        <label  for="" class="form-label">Data de ínicio da auditoria:</label>
        <input required  type="date" min="{{ date('Y-m-d') }}" name="data_abertura" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->data_abertura}}@else{{old('data_abertura')}}@endif" >
    </div> 
    </div>
    <div class="col-6">
      <div class="form-group">
        <label for="data_encerramento" class="form-label">Data de término da auditoria:</label>
        <input  type="date" name="data_encerramento" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->data_encerramento}}@else{{old('data_encerramento')}} @endif" @if(!isset($plano_auditoria->id)) disabled @endif  @if(isset($plano_auditoria->data_abertura)) min="{{ $plano_auditoria->data_abertura }}" @endif>
    </div> 
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <label for="relato">Relato:</label>
        <textarea class="form-control" id="relato" name="relato"  rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->relato}}@else{{ old('relato')}}@endif</textarea>
      </div>
    </div>
    <div class="col-6">
      <div class="form-group">
        <label for="metodo">Método:</label>
        <textarea class="form-control" id="metodo" name="metodo"  rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->metodo}}@else{{ old('metodo')}}@endif</textarea>
      </div>
    </div>
  </div>
  
    <div class="row">
        <div class="col" align="end">
            <br>
            @isset($responsa_auto->id)
            <a href="/responsa_auto/gerar_pdf/{{ $responsa_auto->id }}" class="btn btn-danger"  target="_blank">
              Gerar PDF
              <i class="fas fa-file-pdf"></i>
            </a>
            @endisset
            <button type="submit" class="btn btn-success w-25 hover-shadow">
                Salvar 
                <i class="fas fa-save"></i>
            </button>
        </div>
    </div>
  </form>
  
</div>
</div>
         
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@include('layout.footer')


<script>
 $(function () {

$('#teste').datetimepicker({

    minDate:new Date()

});

});

$(document).ready(function() {
    $('.js-example-basic-multiple').select2();

    $('#cargo_id').change(function(){
      let cargo = $(this).val()
      $.ajax({
          url: "/cargos/responsabilidades/" + cargo,
        })
        .done(function( data ) {
          $('#lista_responsabilidades option').each(function() {
            $(this).remove();
          });
          $.each(data.responsabilidades, function (i, item) {
              $('#lista_responsabilidades').append($('<option>', { 
                  value: item.nome,
                  text : item.nome 
              }));
          });



        });
      });
});
</script>