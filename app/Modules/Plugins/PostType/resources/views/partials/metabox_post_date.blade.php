<div class="card-box post-box">
    <div class="card-box__header">
        <h2>{{ __('plugin:post-type::default.publish-date') }}</h2>
    </div>
    <div class="card-box__body form-horizontal">
        <div class="form-group form-group--table">
            <label class="col-form-label">{{ __('plugin:post-type::default.publish-date') }}</label>
            <div class="col-form-input">
                {!! Form::date('post_date', $post->post_date); !!}
            </div>
        </div>
    </div>
</div>
