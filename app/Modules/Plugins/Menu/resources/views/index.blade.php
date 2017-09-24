@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Menu</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">Menu</h2>
</div>
<!-- /.content__head -->

<div class="content__body page-slider">
    <div class="vertical-tabs row">
        <ul class="nav nav-pills nav-stacked col-md-2">
            @foreach ($menus as $id => $menu)
            <li class="@if( $menu_active_id == $id ) active @endif">
                <a href="#{{ $id }}" data-toggle="pill">Menu {{ $menu['label'] }}</a>
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
                            <h2>Menu {{ $menu['label'] }} <a href="#" class="page-title-action" v-on:click="addMenuLevelOne">Add Menu</a></h2>

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
                                                    Menu
                                                </span>
                                                <a href="#" class="page-title-link repeat-trigger-submenu-3 m-l-10" v-on:click="addMenu(menu,index_menu)">Add Sub Menu</a>
                                            </span>
                                        </div>
                                        <div class="alignright btn-action-group">
                                            <a v-if="menu.data.display == 'block' "   href="#" class="btn-action btn-action-primary" title="Hide menu" v-on:click="hideMenu(menu)"><i class="fa fa-minus"></i></a>
                                            <a v-else href="#" class="btn-action btn-action-primary" title="Show menu" v-on:click="showMenu(menu)"><i class="fa fa-plus"></i></a>
                                            <a href="#" class="btn-action btn-action-danger" title="Delete" v-on:click="deleteMenu(menu,index_menu)"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </div>
                                    <transition name="slide-fade">
                                        <div class="item-box--more ss" style='display: none' v-bind:style="{  display: menu.data.display }">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                    <input class="form-control" type="text" v-model="menu.data.label" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Classes</label>
                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                    <input class="form-control" type="text" v-model="menu.data.class" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL</label>
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
                                                            Sub Menu
                                                        </span>
                                                        <a href="#" class="page-title-link repeat-trigger-submenu-3 m-l-10" v-on:click="addMenu(menu,index_menu,index_sub_menu)">Add Sub Sub Menu</a>
                                                    </span>
                                                </div>
                                                <div class="alignright btn-action-group">
                                                    <a v-if="menu.data.display == 'block'" href="#" class="btn-action btn-action-primary" title="Hide menu" v-on:click="hideMenu(menu)"><i class="fa fa-minus"></i></a>
                                                    <a v-else href="#" class="btn-action btn-action-primary" title="Show menu" v-on:click="showMenu(menu)"><i class="fa fa-plus"></i></a>
                                                    <a href="#" class="btn-action btn-action-danger" title="Delete" v-on:click="deleteMenu(menu,index_menu,index_sub_menu)"><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </div>
                                            <transition name="slide-fade">
                                                <div class="item-box--more" style='display: none' v-bind:style="{  display: menu.data.display }">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                            <input class="form-control" type="text" v-model="menu.data.label" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Classes</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                              <input class="form-control" type="text" v-model="menu.data.class" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL</label>
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
                                                                Sub Sub Menu
                                                            </span>
                                                        </div>
                                                        <div class="alignright btn-action-group">
                                                            <a v-if="menu.data.display =='block' "href="#" class="btn-action btn-action-primary" title="Hide menu" v-on:click="hideMenu(menu)"><i class="fa fa-minus"></i></a>
                                                            <a v-else  href="#" class="btn-action btn-action-primary" title="Show menu" v-on:click="showMenu(menu)"><i class="fa fa-plus"></i></a>
                                                            <a href="#" class="btn-action btn-action-danger" title="Delete" v-on:click="deleteMenu(menu,index_menu,index_sub_menu,index_sub_sub_menu)"><i class="fa fa-trash-o"></i></a>
                                                        </div>
                                                    </div>
                                                    <transition name="slide-fade">
                                                        <div class="item-box--more" style='display: none' v-bind:style="{  display: menu.data.display }">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                      <input class="form-control" type="text" v-model="menu.data.label" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input class="form-control" type="text" v-model="menu.data.class" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL</label>
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
                            <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan Menu {{ $menu['label'] }}">
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
