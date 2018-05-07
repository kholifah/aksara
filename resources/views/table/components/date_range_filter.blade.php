<div class="alignleft action filter-box">{{ $caption ?? __('tableview.labels.date_range') }}</div>
<div class="alignleft action filter-box">
  {!! HtmlInput::date($column_name.'_filter_from', @$table['date_range_filtered'][$column_name.'_from'], ['class'=>'form-control']) !!}
</div>
<div class="alignleft action filter-box">@lang('tableview.labels.to')</div>
<div class="alignleft action filter-box">
  {!! HtmlInput::date($column_name.'_filter_to', @$table['date_range_filtered'][$column_name.'_to'], ['class'=>'form-control']) !!}
</div>

