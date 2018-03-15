@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Option</li>
</ol>
@endsection

@section('content')
<div class="container">
    <div class="content__head">
        <h2 class="page-title">{{ __('plugin:aksara-multi-bas::default.multi-lang-option') }}</h2>
    </div>
    <!-- /.content__head -->

    <div class="content__body page-slider">
        <div class="vertical-tabs row">
            <div class="card-box col-md-12">
                {!! Form::open(['route' => 'aksara-multibas-option-save', 'role' => 'form', 'class' => 'form-horizontal','id'=>'multibas-option'])!!}
                <div class='row'>
                    <div class='col-md-4'>
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <script>
                                var lang_options = {!! $lang_options !!};
                                var countries = {!! $countries !!};
                                </script>

                                <div class="tab-pane__body">
                                    <h2 class="border-title">{{ __('plugin:aksara-multi-bas::default.add-multi-lang') }}</h2>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:aksara-multi-bas::default.lang') }}</label>
                                        <div class="col-sm-8 col-xs-8 col-xxs-12">
                                            <select v-model="selected_country" class="form-control" >
                                              <option v-for="(lang_option,index) in lang_options" v-bind:value="lang_option">
                                                ${ lang_option.name } - ${lang_option.language_code} / ${lang_option.locale}
                                              </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:aksara-multi-bas::default.name') }}</label>
                                        <div class="col-sm-8 col-xs-8 col-xxs-12">
                                            <input type='text' name='name' class='form-control' v-bind:value="selected_country.name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:aksara-multi-bas::default.flag') }}</label>
                                        <div class="col-sm-8 col-xs-8 col-xxs-12">
                                            <span v-bind:class="'flag-icon flag-icon-'+selected_country.flag_code"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <input class="btn btn-md btn-primary alignright" value="{{ __('plugin:aksara-multi-bas::default.add-lang') }}" v-on:click="addCountry(selected_country)" type="button">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-8'>
                        <div class="tab-content">
                            <div class="tab-pane__body">
                                <h2 class="border-title">{{ __('plugin:aksara-multi-bas::default.registered-lang') }}</h2>
                                <table class='table table-striped'>
                                    <tr>
                                        <th>{{ __('plugin:aksara-multi-bas::default.name') }}</th>
                                        <th>{{ __('plugin:aksara-multi-bas::default.code') }}</th>
                                        <th>{{ __('plugin:aksara-multi-bas::default.locale') }}</th>
                                        <th>{{ __('plugin:aksara-multi-bas::default.flag') }}</th>
                                        <th>{{ __('plugin:aksara-multi-bas::default.default') }}</th>
                                        <th>{{ __('plugin:aksara-multi-bas::default.action') }}</th>
                                    </tr>
                                     <tr v-for="(country,index) in countries">
                                         <td>${country.name}</td>
                                         <td>${country.language_code}</td>
                                         <td>${country.locale}</td>
                                         <td><span v-bind:class="'flag-icon flag-icon-'+country.flag_code"></span></td>
                                         <td>
                                             <span v-if="country.default" class='glyphicon glyphicon-ok'></span>
                                             <span v-else class='glyphicon glyphicon-remove'></span>
                                         </td>
                                         <td>
                                             <a v-on:click="removeCountry(index)" href="#">{{ __('plugin:aksara-multi-bas::default.delete') }}</a> | <a v-on:click="makeDefault(index)" href="#">{{ __('plugin:aksara-multi-bas::default.make-default') }}</a>
                                         </td>
                                     </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane__footer">
                        <div class="submit-row clearfix">
                            <input class="btn btn-md btn-primary alignright" value="{{ __('plugin:aksara-multi-bas::default.save-lang-setting') }}" type="submit">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="countries" v-bind:value="JSON.stringify(countries)">
                <!-- tab content -->
                {!! Form::close()!!}
            </div>
        </div>
    </div>
    <!-- /.content__body -->
</div> <!-- container -->
@endsection
