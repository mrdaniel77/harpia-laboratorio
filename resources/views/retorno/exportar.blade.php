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
    <th>Responsável</th>
    <th>Data</th>
    <th>Descrição</th>
    </tr>
</thead>
@foreach ($retorno as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{$item->colaborador->nome}}</td>
        <td>{{ $item->data_retorno }}</td>
        <td>{{ $item->descricao }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($retorno) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
