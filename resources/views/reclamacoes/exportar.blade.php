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
    <th>Responsável pela abertura</th>
    <th>Descrição</th>
    <th>Data abertura</th>
    <th>Reclamante</th>
    </tr>
</thead>
@foreach ($reclamacao as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{$item->colaborador->nome}}</td>
        <td>{!! nl2br($item->descricao) !!}</td>
        <td>{{ $item->data_abertura}}</td>
        <td>{{ $item->reclamante }}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($reclamacao) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
