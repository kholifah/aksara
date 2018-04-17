<div class="content__body">
  <div class="row">
    <div class="col-md-8">
      <form class="posts-filter clearfix">
        <div class="tablenav top clearfix">
          <div class="alignleft search-box">

            <input name={{ $table['inputs']['search'] }} value="{{ $table['search'] }}" type="text" class="form-control">
            <input type="submit" class="btn btn-secondary" value=@lang('tableview.labels.search')>

          </div>
          <div class="tablenav-pages"><span class="displaying-num">{{ $table['total'] }} {{ trans_choice('tableview.labels.items', $table['total']) }}</span>
            <span class="pagination-links">
              {!! $table['links'] !!}
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
                @foreach($table['column_labels'] as $label)
                  <th>{{ $label }}</th>
                @endforeach
                <th>&nbsp</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($table['rows']))
                @foreach($table['rows'] as $row)
                  <tr>
                    <td class="check-column">
                      <div class="checkbox checkbox-single">
                        <input name={{ $table['row_identifier']."[]" }} type="checkbox" value="{{ $row[$table['row_identifier']] }}">
                        <label></label>
                      </div>
                    </td>
                    @foreach($row['fields'] as $field)
                      <td>{{ $field }}</td>
                    @endforeach
                    <td>
                      @if ($row['url']['edit'] != false)
                        <a href="{{ $row['url']['edit'] }}" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                      @endif
                      @if ($row['url']['delete'] != false)
                        <a onclick='{{ "return confirm('".__('tableview.messages.confirm_delete')."');" }}' href="{{ $row['url']['delete'] }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
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
            <select name={{ $table['inputs']['apply'] }} class="form-control">
              <option disabled selected>@lang('tableview.labels.bulk_action')</option>
              <option value='destroy'>@lang('tableview.labels.delete')</option>
            </select>
            <input name={{ $table['inputs']['bapply'] }} type="submit" class="btn btn-secondary" value=@lang('tableview.labels.apply')>
          </div>
          <div class="tablenav-pages"><span class="displaying-num">{{ $table['total'] }} {{ trans_choice('tableview.labels.items', $table['total']) }}</span>
            {!! $table['links'] !!}
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.content__body -->
