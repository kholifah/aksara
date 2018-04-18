<!-- filter links -->
<ul class="trash-sistem">
  <?php
    $count = count($table['filter_links']);
    $current = 0;
  ?>
  @foreach($table['filter_links'] as $label => $url)
    <li>
      <a href={{ $url }}>{{ $label }}</a> {{ $current < $count-1 ? '|' : '' }}
    </li>
    <?php $current++ ?>
  @endforeach
</ul>
<!-- /filter links -->

