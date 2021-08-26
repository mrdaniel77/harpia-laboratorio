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
    <th>Data da Revisão/Edição/N°</th>
    <th>Tipo</th>
    <th>Documento</th>
    <th>Código</th>
    <th>N° de exemplares</th>
    <th>Localização</th>
    <th>Data da última análise crítica</th>
    <th>Próxima análise crítica em</th>
    <th>Frequência da análise crítica/verificação</th>
    <th>Atualização em</th>
    <th>Revisão Edição</th>
    <th>Data da Aprovação</th>
    <th>Nº de cópias</th>
    </tr>
</thead>
@foreach ($documento as $item)
<tbody>
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->titulo }}</td>
        <td>{{ $item->revisao_edicao_n }}</td>
        <td>{{ $item->tipo }}</td>
        <td>{{ $item->codigo }}</td>
        <td>{{ $item->n_de_exemplares }}</td>
        <td>{{ $item->localizacao }}</td>
        <td>{{ $item->data_da_ultima_analise_critica}}</td>
        <td>{{ $item->proxima_analise_critica_em}}</td>
        <td>{{ $item->frequencia_da_analise_critica_verificacao}}</td>
        <td>{{ $item->atualizacao_em}}</td>
        <td>{{ $item->revisao_edicao}}</td>
        <td>{{ $item->data_aprovacao}}</td>
        <td>{{ $item->num_copias}}</td>
        <td>
            <a href="{{ $item->documento}}" target="_blank">Abrir arquivo</a>
        </td>
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
