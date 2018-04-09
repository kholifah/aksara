@extends_backend('layouts.layout')
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{__('post-type::default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('post-type::default.all-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}</li>
</ol>
@endsection
@section('content')
<div class="content__head">
    <h2 class="page-title">{{ __('post-type::default.all-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}
        @if( array_search_key_recursive('admin.'.get_current_post_type_args('slug').'.create',\Config::get('aksara.admin-menu.admin-sub-menu'),false) )
        <a href="{{ route('admin.'.get_current_post_type_args('slug').'.create') }}" class="page-title-action">{{ __('post-type::default.add-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}</a>
        @endif
    </h2>
</div>
<!-- /.content__head -->
<div class="content__body">
    <ul class="trash-sistem">
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('slug').'.index') }}" <?php if ($viewData['post_status'] == '') echo 'class="current"' ?> >{{__('post-type::default.all') }}</a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('slug').'.index') }}?post_status=publish" <?php if ($viewData['post_status'] == 'publish') echo 'class="current"' ?>>{{ status_post('publish',get_current_post_type()) }}</a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('slug').'.index') }}?post_status=draft" <?php if ($viewData['post_status'] == 'draft') echo 'class="current"' ?>>{{ status_post('draft',get_current_post_type()) }}</a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('slug').'.index') }}?post_status=pending" <?php if ($viewData['post_status'] == 'pending') echo 'class="current"' ?>>{{ status_post('pending',get_current_post_type()) }} </a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('slug').'.index') }}?post_status=trash" <?php if ($viewData['post_status'] == 'trash') echo 'class="current"' ?>>{{ status_post('trash',get_current_post_type()) }} </a>
        </li>
    </ul>
    <form action="" class="posts-filter clearfix">
    <div class="tablenav top clearfix">
        <div class="alignleft action bulk-action">
                <select name="apply" class="form-control">
                    @if($viewData['post_status'] == 'trash')
                        <option disabled selected>{{__('post-type::default.bulk-action') }}</option>
                        <option value='restore'>{{__('post-type::default.restore') }}</option>
                        <option value='destroy'>{{__('post-type::default.delete-permanently') }}</option>
                    @else
                        <option disabled selected>{{__('post-type::default.bulk-action') }}</option>
                        <option value='trash'>{{__('post-type::default.move-trash') }}</option>
                    @endif
                </select>
                <input name="bapply" type="submit" class="btn btn-secondary" value="{{__('post-type::default.apply') }}">

        </div>
        <div class="alignleft action filter-box">
            @foreach($taxonomies as $taxonomy)
            <?php
                $terms = get_terms(array_get($taxonomy,'id'));
                $terms = $terms->pluck('name','id');
                $terms = $terms->toArray();

                $termSelect = [ 0 => __('post-type::default.all-taxonomy', ['taxonomy' => array_get($taxonomy,'label.name')])] ;
                $termSelect = $termSelect + $terms;
            ?>
            {!! Form::select('taxonomy['.array_get($taxonomy,'id').']', $termSelect, @$viewData['taxonomy'][array_get($taxonomy,'id')], array('class' => 'form-control')); !!}
            @endforeach
            <input name="bfilter" type="submit" class="btn btn-secondary" value="{{__('post-type::default.filter') }}">
        </div>
        <div class="alignleft search-box">
            <input name="search" value="{{ $viewData['search'] }}" type="text" class="form-control">
            <input name="bsearch" type="submit" class="btn btn-secondary" value="{{__('post-type::default.search') }}">
        </div>
        <div class="tablenav-pages"><span class="displaying-num">{{ $viewData['total'] }} @if($viewData['total'] > 1 ){{__('post-type::default.items') }} @else {{__('post-type::default.item') }} @endif</span>
            {!! $posts->links(get_active_backend_view('partials.pagination')) !!}
        </div>
    </div>
    <div class="table-box">
        <table class=" table noborder-top display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    @foreach ($cols as $colId => $colArgs)
                    <th class="{!! $colId !!} {!! @$colArgs['class']!!}"
                        @foreach ($colArgs as $colAttributeName => $colAttributeValue)
                            @if(!in_array($colAttributeName,['class','title']))
                                {!! $colAttributeName.'="'.$colAttributeValue.'"' !!}
                            @endif
                        @endforeach
                        >
                        {!! $colArgs['title'] !!}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if($posts->count() > 0)
                @foreach($posts as $post)
                <tr>
                    @foreach ($cols as $colId => $colArgs)
                    @action('aksara.post-type.'.get_current_post_type().'.index.table.row',$colId,$post)
                    @endforeach
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="tablenav bottom clearfix">
        <div class="alignleft action bulk-action">
            <select name="apply" class="form-control">
                @if($viewData['post_status'] == 'trash')
                    <option disabled selected>{{__('post-type::default.bulk-action') }}</option>
                    <option value='restore'>{{__('post-type::default.restore') }}</option>
                    <option value='destroy'>{{__('post-type::default.delete-permanently') }}</option>
                @else
                    <option disabled selected>{{__('post-type::default.bulk-action') }}</option>
                    <option value='trash'>{{__('post-type::default.move-trash') }}</option>
                @endif
            </select>
            <input name="bapply" type="submit" class="btn btn-secondary" value="{{__('post-type::default.apply') }}">
        </div>
        @if($viewData['post_status'] == 'trash')
        <div class="alignleft">
            <input name="bapplyall" type="submit" class="btn btn-secondary" value="{{__('post-type::default.empty-trash') }}">
        </div>
        @endif
        <div class="tablenav-pages"><span class="displaying-num">{{ $viewData['total'] }} @if($viewData['total'] > 1 ) {{__('post-type::default.items') }} @else {{__('post-type::default.item') }} @endif</span>
            {!! $posts->links(get_active_backend_view('partials.pagination')) !!}
        </div>
    </div>
    </form>
</div>
@endsection
