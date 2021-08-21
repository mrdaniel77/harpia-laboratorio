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
    <th>Tipo</th>
    <th>Cnpj</th>
    <th>Razão Social</th>
    <th>Telefone</th>
    <th>E-mail</th>
    </tr>
</thead>
@foreach ($fornecedor as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->tipo }}</td>
        <td>{{ $item->cnpj }}</td>
        <td>{{ $item->razao_social }}</td>
        <td>{{ $item->telefone }}</td>
        <td>{{ $item->email }}</td>
</tbody>
@endforeach
</table>
<br>
@if(count($fornecedor) < 1)
<div class="alert alert-info" style="margin-left: 61px; margin-right: 61px;">
    Nenhum registro encontrado!
</div>
@endif
