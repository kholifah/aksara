@if($taxonomies)
    @foreach($taxonomies as $key => $val)
        @if($key == get_current_post_type())
            @foreach($val as $key1 => $val1)
            <div class="card-box post-box">
                <div class="card-box__header">
                    <h2>{{ $val1['label']['name'] }}</h2>
                </div>
                <div class="card-box__body category-wrap">
                    <ul class="unstyle-list js-scroll">
                        <?php
                        $term = get_term($key1);
                        $post_term = get_post_term($post->id, $key1, ['order_by' => 'name']);

                        $all_post_term = [];
                        if($post_term)
                        {
                            foreach ($post_term as $v) {
                                $all_post_term[] = $v->term_id;
                            }
                        }
                        ?>
                        @if($term)
                        @foreach ($term as $v)
                        <li>
                            <div class="checkbox checkbox-inline">
                                <input value="{{ $v->id }}" name="taxonomy[{{ $key1 }}][]" type="checkbox" @if(in_array($v->id, $all_post_term)) checked @endif >
                                <label for="berita">{{ $v->name }}</label>
                            </div>
                        </li>
                        @endforeach
                        @endif

                    </ul>
                </div>
            </div>
            @endforeach
        @endif
    @endforeach
@endif
