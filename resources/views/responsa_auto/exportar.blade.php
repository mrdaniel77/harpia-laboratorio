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
    <th>Colaborador</th>
    <th>Autorizador</th>
    <th>Cargo</th>
    </tr>
</thead>
@foreach ($responsa_auto as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{!! nl2br($item->colaborador->nome) !!}</td>
        <td>{!! nl2br($item->autorizador->nome) !!}</td>
        <td>{!! nl2br($item->cargo->cargo) !!}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($responsa_auto) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
