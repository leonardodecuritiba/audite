<button data-href="{{(isset($field_cancel_route) ? $field_cancel_route : route($Page->entity.'.cancel',$sel['id']))}}"
        data-refresh="{{(isset($refresh) ? $refresh : 1)}}"
        class="btn btn-simple  btn-danger btn-icon"
        onclick="showDeleteTableMessage(this)"
        type="button"
        data-entity="{{(isset($field_cancel) ? $field_cancel : $Page->name).': '.$sel['name']}}"><i
            class="material-icons">cancel</i></button>
