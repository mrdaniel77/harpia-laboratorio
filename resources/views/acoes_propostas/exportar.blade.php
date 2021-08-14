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
    <th>Origem</th>
    <th>Ação</th>
    <th>Responsável</th>
    <th>Prazo</th>
    <th>Prazo Final</th>
    <th>Necessária Prorrogação</th>
    <th>Data de Encerramento</th>
    </tr>
</thead>
@foreach ($acoes_propostas as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->origem }}</td>
        <td>{{ $item->acao }}</td>
        <td>{{ $item->responsavel }}</td>
        <td>{{ $item->prazo }}</td>
        <td>{{ $item->prazo_final }}</td>
        <td>{{ $item->necessaria_prorrogacao }}</td>
        <td>{{ $item->data_encerramento }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($acoes_propostas) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
