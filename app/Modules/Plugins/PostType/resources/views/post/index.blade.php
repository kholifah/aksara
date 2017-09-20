@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Semua {{ get_current_post_type_args('label.name') }}</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">Semua {{ get_current_post_type_args('label.name') }} <a href="{{ route('admin.'.get_current_post_type_slug().'.create') }}" class="page-title-action">Tambah {{ get_current_post_type_args('label.name') }}</a></h2>
</div>
<!-- /.content__head -->
<div class="content__body">

    <ul class="trash-sistem">
        <li>
            <a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}" <?php if ($post_status == '') echo 'class="current"' ?> >All <span class="count">({{ $count_post['all'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}?post_status=publish" <?php if ($post_status == 'publish') echo 'class="current"' ?>>{{ status_post('publish',get_current_post_type()) }} <span class="count">({{ $count_post['publish'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}?post_status=draft" <?php if ($post_status == 'draft') echo 'class="current"' ?>>{{ status_post('draft',get_current_post_type()) }} <span class="count">({{ $count_post['draft'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}?post_status=pending" <?php if ($post_status == 'pending') echo 'class="current"' ?>>{{ status_post('pending',get_current_post_type()) }} <span class="count">({{ $count_post['pending'] }})</span></a> |
        </li>
        <li>
            <a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}?post_status=trash" <?php if ($post_status == 'trash') echo 'class="current"' ?>>{{ status_post('trash',get_current_post_type()) }} <span class="count">({{ $count_post['trash'] }})</span></a>
        </li>
    </ul>
    <form action="" class="posts-filter clearfix">
    <div class="tablenav top clearfix">
        <div class="alignleft action bulk-action">

                <select name="apply" class="form-control">
                    @if($post_status == 'trash')
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
            <?php
            $term = get_term('category');
            $aterm[0] = 'All Category';
            if($term)
            {
                foreach ($term as $v)
                {
                    $aterm[] = $v->name;
                }
            }
            ?>
            {!! Form::select('category', $aterm, $category, array('class' => 'form-control')); !!}
            <input name="bfilter" type="submit" class="btn btn-secondary" value="Filter">
        </div>
        <div class="alignleft search-box">
            <input name="search" value="{{ $search }}" type="text" class="form-control">
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
                    <th class="no-sort check-column" width="20">
                        <div class="checkbox checkbox-single checkall">
                            <input type="checkbox">
                            <label></label>
                        </div>
                    </th>
                    <th>Judul</th>
                    <?php
                    $taxonomies = (\Config::get('aksara.taxonomy'));
                    ?>
                    @if($taxonomies)
                    @foreach($taxonomies as $key => $val)
                    @if($key == get_current_post_type())
                    @foreach($val as $key1 => $val1)
                        <th width="100">{{ $val1['label']['name'] }}</th>
                    @endforeach
                    @endif
                    @endforeach
                    @endif

                    <th width="100">Status</th>
                    <th class="no-sort" width="50">Edit</th>
                </tr>
            </thead>
            <tbody>
                @if($posts->count() > 0)
                @foreach($posts as $post)
                <tr>
                    <td class="check-column">
                        <div class="checkbox checkbox-single">
                            <input name="post_id[]" type="checkbox" value="{{ $post->id }}">
                            <label></label>
                        </div>
                    </td>
                    <td>{{ $post->post_title }}</td>
                    @if($taxonomies)
                    @foreach($taxonomies as $key => $val)
                    @if($key == get_current_post_type())
                    @foreach($val as $key1 => $val1)
                        <td>
                            <?php
                            $post_term = get_post_term($post->id, $key1, ['order_by' => 'name']);
                            if($post_term){
                                $u = 0;
                                foreach ($post_term as $v) {
                                    if($u == 0)
                                    {
                                        echo $v->term->name;
                                    } else {
                                        echo ', '.$v->term->name;
                                    }
                                    $u++;
                                }
                            }
                            ?>

                        </td>
                    @endforeach
                    @endif
                    @endforeach
                    @endif


                    <td>
                        {{ status_post($post->post_status) }}
                    </td>
                    <td>
                        @if($post_status == 'trash')
                        <a href="{{ route('admin.'.get_current_post_type_slug().'.restore', $post->id) }}" class="icon-edit sa-warning"><i title="Restore" class="fa fa-reply"></i></a>
                        <a onclick="return confirm('Yakin ingin menghapus data?');" href="{{ route('admin.'.get_current_post_type_slug().'.destroy', $post->id) }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
                        @else
                        <a href="{{ route('admin.'.get_current_post_type_slug().'.edit', $post->id) }}" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                        <a onclick="return confirm('Yakin ingin memindahkan data ke trash?');" href="{{ route('admin.'.get_current_post_type_slug().'.trash', $post->id) }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="tablenav bottom clearfix">
        <div class="alignleft action bulk-action">
            <select name="apply" class="form-control">
                @if($post_status == 'trash')
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
        @if($post_status == 'trash')
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
