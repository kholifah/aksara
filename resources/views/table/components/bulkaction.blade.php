<!-- bulk action -->
<div class="alignleft action bulk-action">
  <select name={{ $table['inputs']['apply'] }} class="form-control">
    <option disabled selected>@lang('tableview.labels.bulk_action')</option>
    @foreach ($table['bulk_actions'] as $value => $label)
      <option value={{ $value }}>{{ $label }}</option>
    @endforeach
  </select>
  <input name={{ $table['inputs']['bapply'] }} type="submit" class="btn btn-secondary" value=@lang('tableview.labels.apply')>
</div>
<!-- /bulk action -->
