@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{__('post-type::default.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}">{{ get_current_post_type_args('label.name') }}</a></li>
    <li class="breadcrumb-item active">{{ get_current_taxonomy_args('label.name') }}</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">{{ __('post-type::default.all-taxonomy', ['taxonomy' => get_current_taxonomy_args('label.name') ]) }}  <a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy().'.create') }}" class="page-title-action">{{ __('post-type::default.add-taxonomy', ['taxonomy' => get_current_taxonomy_args('label.name') ]) }}</a></h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-md-6">
            <div class="tablenav top clearfix" style="margin-bottom: 15px;">
                <div class="alignleft search-box">
                    <form class="posts-filter clearfix" method="get">
                        <input name="search" value="{{ $search }}" type="text" class="form-control">
                        <input type="submit" class="btn btn-secondary" value="{{__('post-type::default.search') }}">
                    </form>
                </div>
                <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 ){{__('post-type::default.items') }} @else {{__('post-type::default.item') }} @endif</span>
                    {!! $terms->links(get_active_backend_view('partials.pagination')) !!}
                </div>
            </div>
            <div class="table-box">
                <table class="datatable-responsive table noborder-top display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{{__('post-type::default.name') }}</th>
                            <th>{{__('post-type::default.slug') }}</th>
                            <th>{{__('post-type::default.parent') }}</th>
                            <th class="no-sort" width="50">{{__('post-type::default.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($terms->count() > 0)
                        @foreach($terms as $term)
                        <tr>
                            <td>{{ $term->name }}</td>
                            <td>{{ $term->slug }}</td>
                            <td>
                                @if($term->parent != 0)
                                {{ $term->term_parent->name }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy().'.edit', $term->id) }}" class="icon-edit"><i title="{{__('post-type::default.edit') }}" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                                <a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy().'.destroy', $term->id) }}" onclick="return confirm({{__('post-type::message.confirm-delete-message') }});" class="icon-delete sa-warning"><i title="{{__('post-type::default.delete') }}" class="fa fa-trash-o"></i></a>


                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="tablenav bottom clearfix">
                <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 ){{__('post-type::default.items') }} @else {{__('post-type::default.item') }} @endif</span>
                   {!! $terms->links(get_active_backend_view('partials.pagination')) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
