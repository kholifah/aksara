@extends_backend('layouts.layout')
@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">@lang('sample-master::supplier.labels.all_suppliers')</li>
  </ol>
@endsection

@section('content')
  <div class="content__head">
    <h2 class="page-title">@lang('sample-master::supplier.labels.supplier_list')
      <a href="{{ route('sample-supplier-create') }}" class="page-title-action">@lang('sample-master::supplier.labels.add_supplier')</a></h2>
  </div>
  <!-- /.content__head -->

  <div class="content__body">
    <div class="row">
      <div class="col-md-8">
        <form class="posts-filter clearfix">
          <div class="tablenav top clearfix">
            <div class="alignleft search-box">

              <input name="search" value="{{ $search }}" type="text" class="form-control">
              <input type="submit" class="btn btn-secondary" value=@lang('sample-master::global.search')>

            </div>
            <div class="tablenav-pages"><span class="displaying-num">{{ $total }} {{ trans_choice('sample-master::global.items', $total) }}</span>
              <span class="pagination-links">
                {!! $suppliers->links() !!}
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
                  <th>@lang('sample-master::supplier.labels.name')</th>
                  <th>@lang('sample-master::supplier.labels.phone')</th>
                  <th>&nbsp</th>
                </tr>
              </thead>
              <tbody>
                @if($suppliers->count() > 0)
                  @foreach($suppliers as $supplier)
                    <tr>
                      <td class="check-column">
                        <div class="checkbox checkbox-single">
                          <input name="id[]" type="checkbox" value="{{ $supplier->id }}">
                          <label></label>
                        </div>
                      </td>
                      <td>{{ $supplier->supplier_name }}</td>
                      <td>{{ $supplier->supplier_phone }}</td>
                      <td>
                        <a href="{{ route('sample-supplier-edit', $supplier->id) }}" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                        <a onclick='{{ "return confirm('".__('sample-master::supplier.messages.confirm_delete')."');" }}' href="{{ route('sample-supplier-destroy', $supplier->id) }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
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
                <option disabled selected>@lang('sample-master::global.bulk_action')</option>
                <option value='destroy'>@lang('sample-master::global.delete')</option>
              </select>
              <input name="bapply" type="submit" class="btn btn-secondary" value=@lang('sample-master::global.apply')>
            </div>
            <div class="tablenav-pages"><span class="displaying-num">{{ $total }} @if($total > 1 )items @else item @endif</span>
              {!! $suppliers->links() !!}
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

