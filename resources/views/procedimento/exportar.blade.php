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
    <th>Rev</th>
    <th>Data</th>
    <th>Analista</th>
    <th>Lote</th>
    <th>Responsável</th>
    </tr>
</thead>
@foreach ($procedimento as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->rev}}</td>
        <td>{{ $item->data}}</td>
        <td>{{ $item->analista}}</td>
        <td>{{ $item->lote}}</td>
        <td>{{ $item->responsavel}}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($procedimento) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
