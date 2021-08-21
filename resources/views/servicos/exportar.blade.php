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
    <th>Descrição</th>
    <th>Tipo Material</th>
    <th>Tipo Serviço</th>
    <th>Serviço Crítico</th>
    </tr>
</thead>
@foreach ($servico as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->descricao }}</td>
        <td>{{ $item->tipo_material }}</td>
        <td>{{ $item->tipo_servico }}</td>
        <td>{{ $item->servico_critico }}</td>
</tbody>
@endforeach
</table>
<br>
@if(count($servico) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
