@extends('aksara-backend::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{ __('plugin:menu::default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('plugin:menu::default.menu') }}</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">{{ __('plugin:menu::default.menu') }}</h2>
</div>
<!-- /.content__head -->

<div class="content__body page-slider">
    <div class="vertical-tabs row">
        <ul class="nav nav-pills nav-stacked col-md-2">
            @foreach ($menus as $id => $menu)
            <li class="@if( $menu_active_id == $id ) active @endif">
                <a href="#{{ $id }}" data-toggle="pill">{{ __('plugin:menu::default.menu-name', ['name' => $menu['label']]) }}</a>
            </li>
            @endforeach
        </ul>
        <div class="card-box col-md-10">
            {!! Form::open(['route' => 'aksara-menu-save', 'role' => 'form'])!!}
            <div class="tab-content">
                @foreach ($menus as $id => $menu)
                <div class="tab-pane @if( $menu_active_id == $id ) active @endif" id="{{ $id }}">
                    <div class="tab-pane__body repeat-wrap">
                        <div id="{{ $id }}-form-app">
                            <h2>{{ __('plugin:menu::default.menu-name', ['name' => $menu['label']]) }} <a href="#" class="page-title-action" v-on:click="addMenuLevelOne">{{ __('plugin:menu::default.add-menu') }}</a></h2>

                            <!-- Level 1 -->
                            <div v-for="(menu, index_menu) in menus" >
                                <div class="item-box">
                                    <div class="clearfix">
                                        <div class="item-box--title alignleft">
                                            <span>
                                                <span v-if="menu.data.label !='' ">
                                                    ${menu.data.label}
                                                </span>
                                                <span v-else="menu.data.label">
                                                    {{ __('plugin:menu::default.menu') }}
                                                </span>
                                                <a href="#" class="page-title-link repeat-trigger-submenu-3 m-l-10" v-on:click="addMenu(menu,index_menu)">{{ __('plugin:menu::default.add-submenu') }}</a>
                                            </span>
                                        </div>
                                        <div class="alignright btn-action-group">
                                            <a v-if="menu.data.display == 'block' "   href="#" class="btn-action btn-action-primary" title="{{ __('plugin:menu::default.hidden') }}" v-on:click="hideMenu(menu)"><i class="fa fa-minus"></i></a>
                                            <a v-else href="#" class="btn-action btn-action-primary" title="{{ __('plugin:menu::default.show') }}" v-on:click="showMenu(menu)"><i class="fa fa-plus"></i></a>
                                            <a href="#" class="btn-action btn-action-danger" title="{{ __('plugin:menu::default.delete') }}" v-on:click="deleteMenu(menu,index_menu)"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </div>
                                    <transition name="slide-fade">
                                        <div class="item-box--more ss" style='display: none' v-bind:style="{  display: menu.data.display }">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.label') }}</label>
                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                    <input class="form-control" type="text" v-model="menu.data.label" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.classes') }}</label>
                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                    <input class="form-control" type="text" v-model="menu.data.class" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.url') }}</label>
                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                    <input class="form-control" type="text" v-model="menu.data.url" >
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <!-- Level 2  -->
                                <div v-if="menu.menus" class='item-box__depth-1' >
                                    <div v-for="(menu, index_sub_menu) menu in menu.menus">
                                        <div class="item-box">
                                            <div class="clearfix">
                                                <div class="item-box--title alignleft">
                                                    <span>
                                                        <span v-if="menu.data.label !='' ">
                                                            ${menu.data.label}
                                                        </span>
                                                        <span v-else="menu.data.label">
                                                            {{ __('plugin:menu::default.submenu') }}
                                                        </span>
                                                        <a href="#" class="page-title-link repeat-trigger-submenu-3 m-l-10" v-on:click="addMenu(menu,index_menu,index_sub_menu)">{{ __('plugin:menu::default.add-sub-submenu') }} </a>
                                                    </span>
                                                </div>
                                                <div class="alignright btn-action-group">
                                                    <a v-if="menu.data.display == 'block'" href="#" class="btn-action btn-action-primary" title="{{ __('plugin:menu::default.hidden') }}" v-on:click="hideMenu(menu)"><i class="fa fa-minus"></i></a>
                                                    <a v-else href="#" class="btn-action btn-action-primary" title="{{ __('plugin:menu::default.show') }}" v-on:click="showMenu(menu)"><i class="fa fa-plus"></i></a>
                                                    <a href="#" class="btn-action btn-action-danger" title="{{ __('plugin:menu::default.delete') }}" v-on:click="deleteMenu(menu,index_menu,index_sub_menu)"><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </div>
                                            <transition name="slide-fade">
                                                <div class="item-box--more" style='display: none' v-bind:style="{  display: menu.data.display }">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.label') }}</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                            <input class="form-control" type="text" v-model="menu.data.label" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.classes') }}</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                              <input class="form-control" type="text" v-model="menu.data.class" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.url') }}</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                            <input class="form-control" type="text" v-model="menu.data.url" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </transition>
                                        </div>
                                        <!-- Level 3  -->
                                        <div v-if="menu.menus" class='item-box__depth-1' >
                                            <div v-for="(menu, index_sub_sub_menu) in menu.menus">
                                                <div class="item-box">
                                                    <div class="clearfix">
                                                        <div class="item-box--title alignleft">
                                                            <span v-if="menu.data.label !='' ">
                                                                ${menu.data.label}
                                                            </span>
                                                            <span v-else="menu.data.label">
                                                                {{ __('plugin:menu::default.sub-submenu') }}
                                                            </span>
                                                        </div>
                                                        <div class="alignright btn-action-group">
                                                            <a v-if="menu.data.display =='block' "href="#" class="btn-action btn-action-primary" title="{{ __('plugin:menu::default.hidden') }}" v-on:click="hideMenu(menu)"><i class="fa fa-minus"></i></a>
                                                            <a v-else  href="#" class="btn-action btn-action-primary" title="{{ __('plugin:menu::default.show') }}" v-on:click="showMenu(menu)"><i class="fa fa-plus"></i></a>
                                                            <a href="#" class="btn-action btn-action-danger" title="{{ __('plugin:menu::default.delete') }}" v-on:click="deleteMenu(menu,index_menu,index_sub_menu,index_sub_sub_menu)"><i class="fa fa-trash-o"></i></a>
                                                        </div>
                                                    </div>
                                                    <transition name="slide-fade">
                                                        <div class="item-box--more" style='display: none' v-bind:style="{  display: menu.data.display }">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.label') }}</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                      <input class="form-control" type="text" v-model="menu.data.label" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.classes') }}</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input class="form-control" type="text" v-model="menu.data.class" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('plugin:menu::default.url') }}</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                      <input class="form-control" type="text" v-model="menu.data.url" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="menu_data[{{$id}}]" v-bind:value="JSON.stringify(menus)">
                        </div>
                    </div>

                    <div class="tab-pane__footer">
                        <div class="submit-row clearfix">
                            <input type="submit" class="btn btn-md btn-primary alignright" value="{{ __('plugin:menu::default.save-menu', ['name' => $menu['label']]) }}">
                        </div>
                    </div>

                </div>
                @endforeach

            </div>
            {!! Form::close()!!}
            <!-- tab content -->
        </div>
    </div>
</div>



@endsection
