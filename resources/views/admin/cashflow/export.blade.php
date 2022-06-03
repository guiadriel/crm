<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th>Tipo</th>
        <th>Valor</th>
        <th>Valor projetado</th>
        <th>Status</th>
        <th>Categoria</th>
        <th>Subcategoria</th>
        <th>Aluno</th>
        <th>Forma de pagamento</th>
        <th>Nº Contrato</th>
        <th>Dt. Vencimento</th>
        <th>Dt. Pagamento</th>
    </tr>
    </thead>
    <tbody>
    @foreach($entries as $entry)
        <tr>
            <td>{{ $entry->id }}</td>
            <td>{{ $entry->description }}</td>
            <td>
                @if ($entry->type === 'outcome')
                    SAÍDA
                @endif

                @if ($entry->type === 'income')
                    ENTRADA
                @endif
            </td>
            <td data-format="R$ #,##">{{ $entry->value }}</td>
            <td data-format="R$ #,##">

                @if ($entry->type === 'outcome')
                    {{ $entry->bill->intended_amount }}
                @else
                    0.00
                @endif
            </td>
            <td>{{$entry->status->description ?? ''}}</td>
            <td>{{$entry->category->name ?? ''}}</td>
            <td>{{$entry->subCategory->name ?? ''}}</td>
            <td>{{$entry->student->name ?? ''}}</td>
            <td>
                @if ($entry->type == 'income')
                    {{$entry->payment_method}}
                @endif
            </td>
            <td>{{$entry->contract->number ?? ''}}</td>
            <td>

                @if ($entry->type === 'outcome')
                    {{$entry->bill->due_date ?? ''}}
                @endif

                @if ($entry->type === 'income')
                    {{$entry->receipt->expected_date ?? ''}}
                @endif

            </td>
            <td>{{$entry->payment_date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
