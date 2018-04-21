<div class="alignleft action filter-box">
  <select name={{ $table['inputs']['filter']."[]" }} class="form-control">
    <option value="" selected>@lang('tableview.labels.no_filter')</option>
    @foreach ($filters as $name => $label)
      <option value={{ $name }} {{ (@$table['filtered'][$position] == $name ? 'selected' : '') }} >{{ $label }}</option>
    @endforeach
  </select>
</div>
