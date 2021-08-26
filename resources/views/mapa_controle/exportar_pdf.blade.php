<style>
    table {
        border-collapse: collapse;
    }
    th, td {
      border: 1px solid #000;
    }
</style>
<h1 class="m-0">Mapa de Controle de Registros</h1>
<table>
<thead>
    <tr>
        <th scope="col">#</th>
        <th>Nome</th>
        <th>Código</th>
        <th>Responsável</th>
        <th>Data</th>
        <th>Armazenamento</th>
        <th>Indexação</th>
</tr>
</thead>
@foreach ($mapa_controle as $item)
<tbody>
<tr>
    <td>{{ $item->id }}</td>
    <td>{{ $item->nome }}</td>
    <td>{{ $item->codigo }}</td>
    <td>{{ $item->responsavel }}</td>
    <td>{{ $item->data }}</td>
    <td>{{ $item->armazenamento }}</td>
    <td>{{ $item->indexacao }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($mapa_controle) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif