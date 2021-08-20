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
            {{ $error }}<br />
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
                  <input required type="referencia" name="referencia" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->referencia}}@else{{old('referencia')}} @endif">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  <label for="setor_organizacao" class="form-label">Nome da organização:</label>
                  <select required name="setor_organizacao" id="setor_organizacao" class="form-control">
                    <option value="">Selecione um setor</option>
                    @foreach($setores as $item)
                    <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->setor_organizacao == $item->id) selected @elseif(old('setor_organizacao') == $item->id) selected @endif>{{$item->setor}}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-2">
                <label for="" class="form-label">Novo Setor:</label>
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
                  <input type="email" name="email" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->email}}@else{{old('email')}} @endif">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="avaliacao" class="form-label">Avaliação:</label>
                  <input type="text" name="avaliacao" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->avaliacao}}@else{{old('avaliacao')}} @endif">
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
                  <label for="doc_base" class="form-label">Documento base:</label>
                  <input type="text" name="doc_base" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->doc_base}}@else{{old('doc_base')}} @endif">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="form-label">Requisitos a serem avaliados:</label>
                  <input type="text" name="requisitos" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->requisitos}}@else{{old('requisitos')}} @endif">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="objetivo">Objetivo da auditoria:</label>
                  <textarea class="form-control" id="objetivo" name="objetivo" rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->objetivo}}@else{{ old('objetivo')}}@endif</textarea>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="abg_programa">Abrangência do programa:</label>
                  <textarea class="form-control" id="abg_programa" name="abg_programa" rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->abg_programa}}@else{{ old('abg_programa')}}@endif</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="riscos">Riscos do programa:</label>
                  <textarea class="form-control" id="riscos" name="riscos" rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->riscos}}@else{{ old('riscos')}}@endif</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="" class="form-label">Data de ínicio da auditoria:</label>
                  <input required type="date" min="{{ date('Y-m-d') }}" name="data_abertura" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->data_abertura}}@else{{old('data_abertura')}}@endif">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="data_encerramento" class="form-label">Data de término da auditoria:</label>
                  <input type="date" name="data_encerramento" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->data_encerramento}}@else{{old('data_encerramento')}} @endif" @if(!isset($plano_auditoria->id)) disabled @endif @if(isset($plano_auditoria->data_abertura)) min="{{ $plano_auditoria->data_abertura }}" @endif>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="relato">Relato:</label>
                  <textarea class="form-control" id="relato" name="relato" rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->relato}}@else{{ old('relato')}}@endif</textarea>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="metodo">Método:</label>
                  <textarea class="form-control" id="metodo" name="metodo" rows="3" required> @if(isset($plano_auditoria)){{$plano_auditoria->metodo}}@else{{ old('metodo')}}@endif</textarea>
                </div>
              </div>
            </div>
            <div align='center'>
              <h3>Seleção e atribuições da equipe auditora</h3>
            </div>
            <hr>
            <br>
            <div class="row">
              <div class="col-12">
                <div class="card card-primary card-tabs">
                  <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Avaliador líder</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Avaliador especialista</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Atribuições</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                      <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <div>
                          <h3>Avaliador líder</h3>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="avaliador_lider" class="form-label">Avaliador líder:</label>
                              <select required name="avaliador_lider" id="avaliador_lider" class="form-control">
                                <option value="">Selecione um avaliador</option>
                                @foreach($colaboradores_id as $item)
                                <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->avaliador_lider == $item->id) selected @elseif(old('avaliador_lider') == $item->id) selected @endif>{{$item->nome}}
                                </option>
                                @endforeach
                              </select>
                            </div>
                          </div>                          
                          <div class="col-6">
                            <br>
                            @if(isset($plano_auditoria) && count($plano_auditoria->atribuicoes_lider) > 0)
                            @foreach ($plano_auditoria->atribuicoes_lider as $item)
                            <div id="inputFormRow">
                              <div class="input-group mb-3"> 
                                <input type="text" name="atribuicoes_lider[]" class="form-control m-input" placeholder="Adicionar atribuições" autocomplete="off" value="{{ $item->nome }}">
                                <div class="input-group-append">                
                                  <button id="removeRow" type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </div>
                            </div>
                            @endforeach
                            @else
                            <div id="inputFormRow">
                              <div class="input-group mb-3"> 
                                <input type="text" name="atribuicoes_lider[]" class="form-control m-input" placeholder="Adicionar atribuições" autocomplete="off" value="">
                                <div class="input-group-append">                
                                  <button id="removeRow" type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </div>
                            </div>
                            @endif

                              <div id="newRow"></div>
                              <button id="addRow" type="button" class="btn btn-info"> 
                                <i class="fas fa-plus"></i>
                                Adicionar</button>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        <div>
                          <h3>Avaliadores especialista</h3>
                        </div>
                        <hr>
                        <div class="row" id="dadosrow">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="avaliador_especialista" class="form-label">Avaliador especialista:</label>
                              <select required name="avaliador_especialista" id="avaliador_especialista" class="form-control">
                                <option value="">Selecione um avaliador</option>
                                @foreach($colaboradores_id as $item)
                                <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->avaliador_especialista == $item->id) selected @elseif(old('avaliador_especialista') == $item->id) selected @endif>{{$item->nome}}
                                </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-5">
                            <div class="form-group">
                              <label for="setor_avaliador" class="form-label">Setor:</label>
                              <select required name="setor_avaliador" id="setor_avaliador" class="form-control">
                                <option value="">Selecione um Setor</option>
                                @foreach($setores as $item)
                                <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->setor_avaliador == $item->id) selected @elseif(old('setor_avaliador') == $item->id) selected @endif>{{$item->setor}}
                                </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col">
                            <label for="" class="form-label">Excluir</label>
                            <div class="input-group-append">                
                                  <button id="deletaespecialista" type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                          </div>
                        </div>
                        <div id="novarow"></div>
                        <div class="row">
                              <button id="addNovoAvaliador" type="button" class="btn btn-info"> 
                                <i class="fas fa-plus"></i>
                                Adicionar</button>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                        <div>
                          <h3>Atribuições</h3>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col">
                            <br>
                            <div id="atribuicoes">
                              <div class="input-group mb-3"> 
                                <input type="text" name="" class="form-control m-input" placeholder="Adicionar atribuições" autocomplete="off" value="">
                                <div class="input-group-append">                
                                  <button id="apagarow" type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </div>
                            </div>
                              <div id="rowbranco"></div>
                              <button id="botarrow" type="button" class="btn btn-info"> 
                                <i class="fas fa-plus"></i>
                                Adicionar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
              </div>
            </div>
            <div align='center'>
              <h3>Escopo da avaliação</h3>
            </div>
            <hr>
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label for="item" class="form-label">Item:</label>
                  <input type="text" name="item" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->item}}@else{{ old('item') }}@endif">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="matriz" class="form-label">Matriz:</label>
                  <input type="text" name="matriz" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->matriz}}@else{{ old('matriz') }}@endif">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="ensaio" class="form-label">Ensaio:</label>
                  <input type="text" name="ensaio" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->ensaio}}@else{{ old('ensaio') }}@endif">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="metodo_escopo" class="form-label">Método:</label>
                  <input type="text" name="metodo_escopo" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->metodo_escopo}}@else{{ old('metodo_escopo') }}@endif">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="setor_escopo" class="form-label">Setor:</label>
                  <select required name="setor_escopo" id="setor_escopo" class="form-control">
                    <option value="">Selecione um Setor</option>
                    @foreach($setores as $item)
                    <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->setor_escopo == $item->id) selected @elseif(old('setor_escopo') == $item->id) selected @endif>{{$item->setor}}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div align='center'>
              <h3>Plano da auditoria</h3>
            </div>
            <hr>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="data_plano" class="form-label">Data:</label>
                  <input type="date" name="data_plano" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->data_plano}}@else{{old('data_plano')}} @endif">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="atividade" class="form-label">Atividade:</label>
                  <input type="text" name="atividade" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->atividade}}@else{{ old('atividade') }}@endif">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label for="processo" class="form-label">Processo:</label>
                  <input type="text" name="processo" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->processo}}@else{{ old('processo') }}@endif">
                </div>
              </div>
             <div class="col-4">
                <div class="form-group">
                  <label for="item_plano" class="form-label">Item:</label>
                  <input type="text" name="item_plano" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->item_plano}}@else{{ old('item_plano') }}@endif">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="itens_normativos" class="form-label">Itens normativos:</label>
                  <input type="text" name="itens_normativos" class="form-control" value="@if(isset($plano_auditoria)){{$plano_auditoria->itens_normativos}}@else{{ old('itens_normativos') }}@endif">
                </div>
              </div>
            </div>
            <div align='center'>
              <h3>Auditores</h3>
            </div>
              <div class="row" id="rowauditores">
                <div class="col-10">
                  <div class="form-group">
                    <label for="auditores" class="form-label">Auditor:</label>
                    <select required name="auditores" id="auditores" class="form-control">
                      <option value="">Selecione um auditor</option>
                      @foreach($colaboradores_id as $item)
                      <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->auditores == $item->id) selected @elseif(old('auditores') == $item->id) selected @endif>{{$item->nome}}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="" class="form-label">Excluir</label>
                  <div class="input-group-append">                
                        <button id="deletaauditor" type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                </div>
              </div>
              <div id="rowaddauditor"></div>
              <div class="row">
                    <button id="addnovoauditor" type="button" class="btn btn-info"> 
                      <i class="fas fa-plus"></i>
                      Adicionar</button>
              </div>
              <br>
              <hr>
              <div class="row">
                <div class="col-10">
                  <div class="form-group">
                    <label for="auditor_lider_plano" class="form-label">Auditor líder:</label>
                    <select required name="auditor_lider_plano" id="auditor_lider_plano" class="form-control">
                      <option value="">Selecione um auditor</option>
                      @foreach($colaboradores_id as $item)
                      <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->auditor_lider_plano == $item->id) selected @elseif(old('auditor_lider_plano') == $item->id) selected @endif>{{$item->nome}}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            <div class="row">
              <div class="col" align="end">
                <br>
                @isset($plano_auditoria->id)
                <a href="/plano_auditoria/gerar_pdf/{{ $plano_auditoria->id }}" class="btn btn-danger" target="_blank">
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
  $(function() {

    $('#teste').datetimepicker({

      minDate: new Date()

    });

  });

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();

    $('#cargo_id').change(function() {
      let cargo = $(this).val()
      $.ajax({
          url: "/cargos/responsabilidades/" + cargo,
        })
        .done(function(data) {
          $('#lista_responsabilidades option').each(function() {
            $(this).remove();
          });
          $.each(data.responsabilidades, function(i, item) {
            $('#lista_responsabilidades').append($('<option>', {
              value: item.nome,
              text: item.nome
            }));
          });



        });
    });
  });
</script>
<script type="text/javascript">
  // add row
  $("#addRow").click(function () {
      var html = '';
      html += '<div id="inputFormRow">';
      html += '<div class="input-group mb-3">';
      html += '<input type="text" name="atribuicoes_lider[]" class="form-control m-input" placeholder="Adicionar atribuições" autocomplete="off">';
      html += '<div class="input-group-append">';
      html += '<button id="removeRow" type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>';
      html += '</div>';
      html += '</div>';

      $('#newRow').append(html);
  });

  // remove row
  $(document).on('click', '#removeRow', function () {
      $(this).closest('#inputFormRow').remove();
  });

  $("#addNovoAvaliador").click(function() {
    var html = '';
    html += `<div class="row" id='dadosrow' >
                          <div class="col-6">
                            <div class="form-group">
                              <label for="avaliador_especialista" class="form-label">Avaliador especialista:</label>
                              <select required name="avaliador_especialista[]" id="avaliador_especialista" class="form-control">
                                <option value="">Selecione um avaliador</option>
                                @foreach($colaboradores_id as $item)
                                <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->avaliador_especialista == $item->id) selected @elseif(old('avaliador_especialista') == $item->id) selected @endif>{{$item->nome}}
                                </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-5">
                            <div class="form-group">
                              <label for="setor_avaliador" class="form-label">Setor:</label>
                              <select required name="setor_avaliador" id="setor_avaliador" class="form-control">
                                <option value="">Selecione um Setor</option>
                                @foreach($setores as $item)
                                <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->setor_avaliador == $item->id) selected @elseif(old('setor_avaliador') == $item->id) selected @endif>{{$item->setor}}
                                </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col">
                            <label for="setor_avaliador" class="form-label">Excluir</label>
                            <div class="input-group-append">                
                                  <button id="deletaespecialista" type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                          </div>
                        </div>`;
  $('#novarow').append(html);


  // remove row
  $(document).on('click', '#deletaespecialista', function () {
      $(this).closest('#dadosrow').remove();
  });
  })
</script>

<script>
  
  $("#botarrow").click(function () {
      var html = '';
      html += '<div id="atribuicoes">';
      html += '<div class="input-group mb-3">';
      html += '<input type="text" name="" class="form-control m-input" placeholder="Adicionar atribuições" autocomplete="off">';
      html += '<div class="input-group-append">';
      html += '<button id="apagarow" type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>';
      html += '</div>';
      html += '</div>';

      $('#rowbranco').append(html);
  });

  // remove row
  $(document).on('click', '#apagarow', function () {
      $(this).closest('#atribuicoes').remove();
  });
</script>


<script>
  $("#addnovoauditor").click(function() {
    var html = '';
    html += `<div class="row" id='rowauditores'>
                <div class="col-10">
                  <div class="form-group">
                    <label for="auditores" class="form-label">Auditor:</label>
                    <select required name="auditores" id="auditores" class="form-control">
                      <option value="">Selecione um auditor</option>
                      @foreach($colaboradores_id as $item)
                      <option value="{{$item->id}}" @if(isset($plano_auditoria) &&$plano_auditoria->auditores == $item->id) selected @elseif(old('auditores') == $item->id) selected @endif>{{$item->nome}}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="" class="form-label">Excluir</label>
                  <div class="input-group-append">                
                        <button id="deletaauditor" type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                </div>
              </div>`;
  $('#rowaddauditor').append(html);
});

  // remove row
  $(document).on('click', '#deletaauditor', function () {
      $(this).closest('#rowauditores').remove();
  });
</script>
