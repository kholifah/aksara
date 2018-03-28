@extends('aksara::layouts.layout') @section('content')
<!-- Page Header -->
<header class="masthead"
    @if(get_post_featured_image($data['post']->id))
        style="background-image: url('{{ get_post_featured_image($data['post']->id,'masthead') }}')"
    @endif
>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>{{ get_post_title($data['post']) }}</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
    {!! get_post_content($data['post']) !!}

      <form name="sentMessage" id="contactForm" novalidate>
        <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label>@lang('aksara::global.name')</label>
            <input type="text" class="form-control" placeholder="{{ __('aksara::global.name-placeholder') }}" id="name" required data-validation-required-message="{{ __('aksara::validation.required-message', ['field' => __('aksara::global.name')]) }}">
            <p class="help-block text-danger"></p>
          </div>
        </div>
        <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label>@lang('aksara::global.email')</label>
            <input type="email" class="form-control" placeholder="{{ __('aksara::global.email-placeholder') }}" id="email" required data-validation-required-message="{{ __('aksara::validation.required-message', ['field' => __('aksara::global.email')]) }}">
            <p class="help-block text-danger"></p>
          </div>
        </div>
        <div class="control-group">
          <div class="form-group col-xs-12 floating-label-form-group controls">
            <label>@lang('aksara::global.phone-number')</label>
            <input type="tel" class="form-control" placeholder="{{ __('aksara::global.phone-number-placeholder') }}" id="phone" required data-validation-required-message="{{ __('aksara::validation.required-message', ['field' => __('aksara::global.phone-number')]) }}">
            <p class="help-block text-danger"></p>
          </div>
        </div>
        <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label>@lang('aksara::global.message')</label>
            <textarea rows="5" class="form-control" placeholder="{{ __('aksara::global.message-placeholder') }}" id="message" required data-validation-required-message="{{ __('aksara::validation.required-message', ['field' => __('aksara::global.message')]) }}"></textarea>
            <p class="help-block text-danger"></p>
          </div>
        </div>
        <br>
        <div id="success"></div>
        <div class="form-group">
          <button type="submit" class="btn btn-secondary" id="sendMessageButton">@lang('aksara::global.save')</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
