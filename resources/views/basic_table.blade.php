<div class="content__body">
  <div class="row">
    <div class="col-md-8">
      <form class="posts-filter clearfix">
        <div class="tablenav top clearfix">
          <div class="alignleft search-box">

            <input name="search" value="{{ $table->getSearch() }}" type="text" class="form-control">
            <input type="submit" class="btn btn-secondary" value=@lang('tableview.labels.search')>

          </div>
          <div class="tablenav-pages"><span class="displaying-num">{{ $table->getTotal() }} {{ trans_choice('tableview.labels.items', $table->getTotal()) }}</span>
            <span class="pagination-links">
              {!! $table->paginationLinks() !!}
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
                @foreach($table->getColumnLabels() as $label)
                  <th>{{ $label }}</th>
                @endforeach
                <th>&nbsp</th>
              </tr>
            </thead>
            <tbody>
              @if(!$table->empty())
                @foreach($table->getRows() as $row)
                  <tr>
                    <td class="check-column">
                      <div class="checkbox checkbox-single">
                        <input name="id[]" type="checkbox" value="{{ $row['id'] }}">
                        <label></label>
                      </div>
                    </td>
                    @foreach($row['fields'] as $field)
                      <td>{{ $field }}</td>
                    @endforeach
                    <td>
                      <!-- TODO take edit and delete link out to presenter -->
                      <a href="{{ $row['url']['edit'] }}" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                      <a onclick='{{ "return confirm('".__('tableview.messages.confirm_delete')."');" }}' href="{{ $row['url']['delete'] }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
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
              <option disabled selected>@lang('tableview.labels.bulk_action')</option>
              <option value='destroy'>@lang('tableview.labels.delete')</option>
            </select>
            <input name="bapply" type="submit" class="btn btn-secondary" value=@lang('tableview.labels.apply')>
          </div>
          <div class="tablenav-pages"><span class="displaying-num">{{ $table->getTotal() }} {{ trans_choice('tableview.labels.items', $table->getTotal()) }}</span>
            {!! $table->paginationLinks() !!}
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.content__body -->
