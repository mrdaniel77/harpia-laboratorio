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
          <h1 class="m-0">Análise Crítica</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item "><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Análise Crítica</li>
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

      <div class="card">
        <div class="card-header">
          <a href="/analise_critica/novo" class="btn btn-primary">
            Nova Análise Crítica
            <i class="fas fa-plus"></i>
          </a>
          
          <a href="/analise_critica/exportar?pesquisa=<?php echo Request::get('pesquisa'); ?>" class="btn btn-success" target="_blank">
            Exportar
            <i class="fas fa-file-excel"></i>
          </a>

          <div class="card-tools">
            <form action="">
              <div class="input-group input-group" style="width: 150px;">
                <input type="text" name="pesquisa" class="form-control float-right" placeholder="Pesquisar" value="{{ $pesquisa }}">

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
         <!-- /.card-header -->
         <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap table-bordered ">
           <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Responsável</th>
                    <th>Métodos Definidos</th>
                    <th>Pessoal Qualificado</th>
                    <th>Capacidade de Recursos</th>
                    <th>Ações</th>
                </tr>
              </thead>
              @foreach ($analise_critica as $item)
              <tbody>
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->colaborador->nome }}</td>
                  <td>{{ $item->metodos_definidos  }}</td>
                  <td>{{ $item->pessoal_qualificado }}</td>
                  <td>{{ $item->capacidade_recursos }}</td>
                  
                    <td>
                      <a href="analise_critica/editar/{{ $item->id }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="#" class="btn btn-danger" onclick="deleta('/analise_critica/deletar/{{ $item->id }}')">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                </tr>
              </tbody>
              @endforeach
            </table> 
            @if(count($analise_critica) <1 )
              <div class="alert alert-info">Nenhuma análise encontrada</div>
            @endif
              
            </div>     
          </div>
          <!-- /.card-body -->
      </div>
      <div class="row">
        <div class="col">
          {{ $analise_critica->links() }}
        </div>
      </div>
      
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
      
@include('layout.footer')
