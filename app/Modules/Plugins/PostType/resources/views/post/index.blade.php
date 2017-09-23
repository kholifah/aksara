@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Semua {{ get_current_post_type_args('label.name') }}</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">Semua {{ get_current_post_type_args('label.name') }}
        @if( array_search_value_recursive('admin.'.get_current_post_type_args('route').'.create',\Config::get('aksara.admin_sub_menu')) )
        <a href="{{ route('admin.'.get_current_post_type_args('route').'.create') }}" class="page-title-action">Tambah {{ get_current_post_type_args('label.name') }}</a>
        @endif
    </h2>
</div>
<!-- /.content__head -->
<div class="content__body">

    <ul class="trash-sistem">
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}" <?php if ($viewData['post_status'] == '') echo 'class="current"' ?> >All <span class="count">({{ $count_post['all'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}?post_status=publish" <?php if ($viewData['post_status'] == 'publish') echo 'class="current"' ?>>{{ status_post('publish',get_current_post_type()) }} <span class="count">({{ $count_post['publish'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}?post_status=draft" <?php if ($viewData['post_status'] == 'draft') echo 'class="current"' ?>>{{ status_post('draft',get_current_post_type()) }} <span class="count">({{ $count_post['draft'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}?post_status=pending" <?php if ($viewData['post_status'] == 'pending') echo 'class="current"' ?>>{{ status_post('pending',get_current_post_type()) }} <span class="count">({{ $count_post['pending'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}?post_status=trash" <?php if ($viewData['post_status'] == 'trash') echo 'class="current"' ?>>{{ status_post('trash',get_current_post_type()) }} <span class="count">({{ $count_post['trash'] }})</span></a>
        </li>
    </ul>
    <form action="" class="posts-filter clearfix">
    <div class="tablenav top clearfix">
        <div class="alignleft action bulk-action">

                <select name="apply" class="form-control">
                    @if($viewData['post_status'] == 'trash')
                        <option disabled selected>Bulk Action</option>
                        <option value='restore'>Restore</option>
                        <option value='destroy'>Delete Permanently</option>
                    @else
                        <option disabled selected>Bulk Action</option>
                        <option value='trash'>Move to Trash</option>
                    @endif
                </select>
                <input name="bapply" type="submit" class="btn btn-secondary" value="Apply">

        </div>
        <div class="alignleft action filter-box">
            @foreach($taxonomies as $taxonomy)
            <?php
                $terms = get_terms(array_get($taxonomy,'id'));
                $terms = $terms->pluck('name','id');
                $terms = $terms->toArray();

                $termSelect = [ 0=>'All '.array_get($taxonomy,'label.name') ] ;
                $termSelect = $termSelect + $terms;
            ?>
            {!! Form::select('taxonomy['.array_get($taxonomy,'id').']', $termSelect, @$viewData['taxonomy'][array_get($taxonomy,'id')], array('class' => 'form-control')); !!}
            @endforeach
            <input name="bfilter" type="submit" class="btn btn-secondary" value="Filter">
        </div>
        <div class="alignleft search-box">
            <input name="search" value="{{ $viewData['search'] }}" type="text" class="form-control">
            <input name="bsearch" type="submit" class="btn btn-secondary" value="Search">
        </div>
        <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 )items @else item @endif</span>
            {!! $posts->links() !!}
        </div>
    </div>
    <div class="table-box">
        <table class="datatable-responsive table noborder-top display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    @foreach ($cols as $colId => $colArgs)
                    <th class="{!! $colId !!} {!! @$colArgs['class']!!}"
                        @if(@$colArgs['width'])
                            {!! 'width="'.$colArgs['width'].'"'!!}
                        @endif
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
                    <option disabled selected>Bulk Action</option>
                    <option value='restore'>Restore</option>
                    <option value='destroy'>Delete Permanently</option>
                @else
                    <option disabled selected>Bulk Action</option>
                    <option value='trash'>Move to Trash</option>
                @endif
            </select>
            <input name="bapply" type="submit" class="btn btn-secondary" value="Apply">
        </div>
        @if($viewData['post_status'] == 'trash')
        <div class="alignleft">
            <input name="bapplyall" type="submit" class="btn btn-secondary" value="Empty Trash">
        </div>
        @endif
        <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 ) items @else item @endif</span>
            {!! $posts->links() !!}
        </div>
    </div>
    </form>
</div>

@endsection
