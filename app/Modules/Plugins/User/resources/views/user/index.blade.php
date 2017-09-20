@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Semua User</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">Daftar User <a href="{{ route('aksara-user-create') }}" class="page-title-action">Tambah User</a></h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-md-8">
            <form class="posts-filter clearfix">
                <div class="tablenav top clearfix">
                    <div class="alignleft search-box">

                        <input name="search" value="{{ $search }}" type="text" class="form-control">
                        <input type="submit" class="btn btn-secondary" value="Search">

                    </div>
                    <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 )items @else item @endif</span>
                        <span class="pagination-links">
                            {!! $users->links() !!}
                        </span>
                    </div>
                </div>
                <div class="table-box">
                    <table class="datatable-responsive table noborder-top display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="no-sort check-column" width="20">
                                    <div class="checkbox checkbox-single checkall">
                                        <input type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Active</th>
                                <th class="no-sort" width="50">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->count() > 0)
                            @foreach($users as $user)
                            <tr>
                                <td class="check-column">
                                    <div class="checkbox checkbox-single">
                                        <input name="user_id[]" type="checkbox" value="{{ $user->id }}">
                                        <label></label>
                                    </div>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    @if($user->active == 1)
                                    Active
                                    @else
                                    Non Active
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('aksara-user-edit', $user->id) }}" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                                    <a onclick="return confirm('Are you sure?');" href="{{ route('aksara-user-destroy', $user->id) }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
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
                            <option disabled selected>Bulk Action</option>
                            <option value='destroy'>Delete</option>
                        </select>
                        <input name="bapply" type="submit" class="btn btn-secondary" value="Apply">
                    </div>
                    <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 )items @else item @endif</span>
                        {!! $users->links() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
