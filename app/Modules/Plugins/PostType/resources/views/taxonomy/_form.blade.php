<div class="form-group form-group--table {!! $errors->has('name') ? 'error' : '' !!}">
    <label class="col-form-label">{{ __('plugin:post-type::default.title') }}</label>
    <div class="col-form-input">
        {!! Form::text('name', $term->name, ['class'=>'form-control']) !!}
        {!! Form::hidden('id', $term->id, ['class'=>'form-control']) !!}
        {!! Form::hidden('taxonomy', $taxonomy->taxonomy_name, ['class'=>'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('slug') ? 'error' : '' !!}">
    <label class="col-form-label">{{ __('plugin:post-type::default.slug') }}</label>
    <div class="col-form-input">
        {!! Form::text('slug', $term->slug, ['class'=>'form-control']) !!}
        {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('parent') ? 'error' : '' !!}">
    <label class="col-form-label">{{ __('plugin:post-type::default.parent') }}</label>
    <div class="col-form-input">
        {!! Form::select('parent', $parent, $term->parent, array('class' => 'form-control')); !!}
        {!! $errors->first('parent', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="submit-row clearfix">
    {!! Form::submit( __('plugin:post-type::default.save'), ['class'=>'btn btn-md btn-primary alignright']) !!}
</div>