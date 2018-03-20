<div class="form-group form-group--table m-b-30">
    <label class="col-form-label">@lang('user::labels.role_name')</label>
    <div class="col-form-input">
        {!! Form::text('name', $role->name, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    @foreach ( $capabilities as $id => $args)
        <div class="col-sm-4">
            <div class="checkbox-group checkbox-role">
                <div class="checkbox-role--parent">
                    <div class="checkbox checkbox-inline checkall">
                        {!! Form::checkbox('permissions[]', $id, (in_array($id, $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="post">{{ $args['name'] }}</label>
                    </div>
                </div>
                <ul class="checkbox-role--advance">
                    @foreach ( $args['capabilities'] as $childId => $childArgs )
                    <li>
                        <div class="checkbox checkbox-inline">
                            {!! Form::checkbox('permissions[]', $childId , (in_array($childId, $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                            <label for="add_post">{{ $childArgs['name'] }}</label>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach


</div>
