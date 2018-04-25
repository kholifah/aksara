<div class="alignleft action filter-box">
  <!-- TODO here should be the column name -->
  <?php
    $columnFilters = @$table['inputs']['column_filters'][$column_name] ?? [];
  ?>
  <select name={{ $column_name . '_filter' }} class="form-control">
    <option value="" selected>{{ $caption ?? __('tableview.labels.no_filter') }}</option>
    @foreach ($columnFilters as $key => $label)
      <option value={{ $key }} {{ (@$table['column_filtered'][$column_name] == $key ? 'selected' : '') }} >{{ $label }}</option>
    @endforeach
  </select>
</div>

