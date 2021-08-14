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
    <th>Produto</th>
    <th>Fornecedor</th>
    <th>Fabricante</th>
    </tr>
</thead>
@foreach ($inspecao_recebidos as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->produto->nome}}</td>
        <td>{{ $item->fornecedor }}</td>
        <td>{{ $item->fabricante }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($inspecao_recebidos) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
