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
    <th>Cargo</th>
    <th>Formação</th>
    <th>Responsabilidades</th>
    <th>Pré-Requisitos</th>
    <th>Treinamentos</th>
    </tr>
</thead>
@foreach ($cargo as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{!! nl2br($item->cargo) !!}</td>
        <td>{!! nl2br($item->tipo_formacao) !!}</td>
        <td>
        @foreach ($item->responsabilidades as $item_resp)
            {!! $item_resp->nome . '<br>' !!}
        @endforeach
        </td>
        <td>{!! nl2br($item->qualificacao) !!}</td>
        <td>{!! nl2br($item->habilidades) !!}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($cargo) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
