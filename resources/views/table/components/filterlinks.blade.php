<!-- filter links -->
<ul class="trash-sistem">
  <?php
    $count = count($filters);
    $current = 0;
  ?>
  @foreach($filters as $filter => $label)
    <li>
      <a href={{ route($route_name, [ $table['inputs']['view'] => $filter ]) }}>{{ $label }}</a> {{ $current < $count-1 ? '|' : '' }}
    </li>
    <?php $current++ ?>
  @endforeach
</ul>
<!-- /filter links -->

