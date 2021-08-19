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
    <th>Título</th>
    <th>Código</th>
    <th>Localização</th>
    <th>Documento</th>
    </tr>
</thead>
@foreach ($documento as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->titulo }}</td>
        <td>{{ $item->codigo }}</td>
        <td>{{ $item->localizacao }}</td>
        <td>{{ $item->documento}}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($documento) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
