@if($taxonomies)
    @foreach($taxonomies as $taxonomy => $args)
        <div class="card-box post-box">
            <div class="card-box__header">
                <h2>{{ $args['label']['name'] }}</h2>
            </div>
            <div class="card-box__body category-wrap">
                <ul class="unstyle-list js-scroll">
                    <?php
                    $postTerm = get_post_terms($post->id, $taxonomy, ['order_by' => 'name'])->pluck('term_id');
                    $terms = get_terms($taxonomy);
                    ?>
                    @foreach ($terms as $term)
                    <li>
                        <div class="checkbox checkbox-inline">
                            <input value="{{ $term->id }}" name="taxonomy[{{ $taxonomy }}][]" type="checkbox" @if( $postTerm->search($term->id) !== false ) checked @endif >
                            <label >{{ $term->name }}</label>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <a href="{!! route('admin.'.get_current_post_type().'.'.$taxonomy.'.index')!!}">{{ __('plugin:post-type::default.add-taxonomy', ['taxonomy' => array_get($args,'label.name')]) }}</a>
            </div>
        </div>
    @endforeach
@endif
