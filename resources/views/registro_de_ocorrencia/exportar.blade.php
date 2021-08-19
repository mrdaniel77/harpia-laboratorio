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
    <th>Número</th>
    <th>Origem</th>
    <th>Data de Abertura</th>
    <th>Descrever Correção</th>
    <th>Registro de AC nº</th>
    <th>Parecer Técnico</th>
    <th>Observações</th>
    </tr>
</thead>
@foreach ($registro as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->numero }}</td>
        <td>{{ $item->origem }}</td>
        <td>{{ $item->data_de_abertura}}</td>
        <td>{{ $item->descrever_correcao}}</td>
        <td>{{ $item->registro_de_AC_n}}</td>
        <td>{{ $item->parecer_tecnico}}</td>
        <td>{{ $item->observacoes}}</td>
    </tr>
</tbody>
@endforeach
</table>
<br>
@if(count($registro) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
