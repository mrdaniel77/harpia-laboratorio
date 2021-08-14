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
    <th>Nome</th>
    <th>Código</th>
    <th>Responsável</th>
    <th>Data</th>
    </tr>
</thead>
@foreach ($mapa_controle_registros as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->nome }}</td>
        <td>{{ $item->codigo }}</td>
        <td>{{ $item->responsavel }}</td>
        <td>{{ $item->data }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($mapa_controle_registros) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif