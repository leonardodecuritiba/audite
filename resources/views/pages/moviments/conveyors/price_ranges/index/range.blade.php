
<table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
    <thead>
    <tr>
        <th>ID</th>
        <th>Localidade</th>
        <th>Descrição</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>ID</th>
        <th>Localidade</th>
        <th>Descrição</th>
        <th>Ações</th>
    </tr>
    </tfoot>
    <tbody>
    @foreach($prices as $sel)
        <tr>
            <td>{{$sel->id}}</td>
            <td>{{$sel['city_formatted']}}</td>
            <td>
                <b>Coleta:</b> {{$sel['short_description_collect']}}
                <br>
                <b>Entrega:</b> {{$sel['short_description_delivery']}}</td>
            <td>
                @include('layout.inc.buttons.delete',['field_delete_route' => $sel->getDestroyRoute(), 'field_delete' => 'Localidade atendida'])
            </td>
        </tr>
    @endforeach
    </tbody>
</table>