@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}">{{ get_current_post_type_args('label.name') }}</a></li>
    <li class="breadcrumb-item active">{{ get_current_taxonomy_args('label.name') }}</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">Pengaturan {{ get_current_taxonomy_args('label.name') }}  <a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy().'.create') }}" class="page-title-action">Tambah {{ get_current_taxonomy_args('label.name') }}</a></h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-md-6">
            <div class="tablenav top clearfix" style="margin-bottom: 15px;">
                <div class="alignleft search-box">
                    <form class="posts-filter clearfix" method="get">
                        <input name="search" value="{{ $search }}" type="text" class="form-control">
                        <input type="submit" class="btn btn-secondary" value="Search">
                    </form>
                </div>
                <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 )items @else item @endif</span>
                    {!! $terms->links() !!}
                </div>
            </div>
            <div class="table-box">
                <table class="datatable-responsive table noborder-top display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th class="no-sort" width="50">Action</th>
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
                                <a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy().'.edit', $term->id) }}" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                                <a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy().'.destroy', $term->id) }}" onclick="return confirm('Yakin ingin menghapus data?');" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>


                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="tablenav bottom clearfix">
                <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 )items @else item @endif</span>
                   {!! $terms->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
