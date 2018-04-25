<div class="alignleft action filter-box">
  <select name={{ $table['inputs']['filter']."[]" }} class="form-control">
    <option value="" selected>{{ $caption ?? __('tableview.labels.no_filter') }}</option>
    @foreach ($filters as $name => $label)
      <option value={{ $name }} {{ (@$table['filtered'][$filter_position] == $name ? 'selected' : '') }} >{{ $label }}</option>
    @endforeach
  </select>
</div>
