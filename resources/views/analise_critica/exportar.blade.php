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
    <th>Métodos Definidos</th>
    <th>Pessoal Qualificado</th>
    <th>Capacidade de Recursos</th>
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
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($analise_critica) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
