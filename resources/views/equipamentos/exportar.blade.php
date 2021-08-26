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
    <th>Equipamento</th>
    <th>Nome</th>
    <th>Quantidade</th>
    <th>Modelo</th>
    <th>Código</th>
    <th>Materiais</th>
    </tr>
</thead>
@foreach ($equipamentos as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->equipamento }}</td>
        <td>{{ $item->nome }}</td>
        <td>{{ $item->quantidade }}</td>
        <td>{{ $item->modelo }}</td>
        <td>{{ $item->codigo }}</td>
        <td>{{ $item->materiais }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($equipamentos) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
