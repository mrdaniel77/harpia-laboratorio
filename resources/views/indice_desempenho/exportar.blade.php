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
    <th>Fornecedor</th>
    <th>CNPJ</th>
    <th>Ano de Referência</th>
    </tr>
</thead>
@foreach ($indice_desempenho as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->fornecedores->razao_social }}</td>
        <td>{{ $item->cnpj }}</td>
        <td>{{ $item->ano_referencia }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($indice_desempenho) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
