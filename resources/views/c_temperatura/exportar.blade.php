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
    <th>Dia</th>
    <th>Hora</th>
    <th>Responsável	</th>
    <th>Observações</th>
    </tr>
</thead>
@foreach ($c_temperatura as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->dia }}</td>
        <td>{{ $item->hora }}</td>
        <td>{{ $item->colaborador->nome }}</td>
        <td>{{ $item->observacoes }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($c_temperatura) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
