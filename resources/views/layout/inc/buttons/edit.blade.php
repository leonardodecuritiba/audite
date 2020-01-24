{{--<a href="{{(isset($field_edit_route) ? $field_edit_route : route($Page->entity.'.edit',$sel['id']))}}"--}}
{{--class="btn btn-simple btn-info  btn-icon edit"--}}
{{--data-toggle="tooltip"--}}
{{--data-placement="top"--}}
{{--title="Editar"><i class="material-icons">edit</i></a>--}}
<a href="{{(isset($field_edit_route) ? $field_edit_route : route($Page->entity.'.edit',$sel['id']))}}"
   class="btn btn-square btn-outline btn-xs btn-success"
   data-toggle="tooltip"
   data-placement="top"
   title="Editar"
   id="{{$sel['id']}}"
><i class="ti ti-pencil"></i>
</a>
