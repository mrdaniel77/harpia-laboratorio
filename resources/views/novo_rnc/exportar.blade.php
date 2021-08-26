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
    <th>Código</th>
    <th>Número</th>
    <th>Data de Abertura</th>
    <th>Responsável</th>
    <th>Classificação da Ação</th>
    <th>Origem</th>
    </tr>
</thead>
@foreach ($novo_rnc as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->codigo }}</td>
        <td>{{ $item->numero }}</td>
        <td>{{ $item->data_abertura }}</td>
        <td>{{ $item->responsavel }}</td>
        <td>{{ $item->classificacao_acao }}</td>
        <td>{{ $item->origem }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($novo_rnc) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
