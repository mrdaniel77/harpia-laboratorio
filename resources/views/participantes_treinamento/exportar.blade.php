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
    <th>Setor</th>
    <th>Nome</th>
    </tr>
</thead>
@foreach ($participantes_treinamento as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->setor }}</td>
        <td>{{ $item->nome }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($participantes_treinamento) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
