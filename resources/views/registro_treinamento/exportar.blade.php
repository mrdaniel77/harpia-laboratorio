<style>
    table {
        border-collapse: collapse;
    }
    th, td {
      border: 1px solid #000;
    }
</style>
<table>
<thead>
    <tr>
    <th scope="col">#</th>
    <th>Título</th>
    <th>Carga Horária</th>
    <th>Data Inicial</th>
    <th>Data Final</th>
    </tr>
</thead>
@foreach ($registro_treinamento as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->titulo }}</td>
        <td>{{ $item->carga_horaria }}</td>
        <td>{{ $item->data_inicial }}</td>
        <td>{{ $item->data_final }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($registro_treinamento) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
