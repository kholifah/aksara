<div class="card-box post-box">
    <div class="card-box__header">
        <h2>{{ __('plugin:aksara-multi-bas::default.translation') }}</h2>
    </div>
    <div class="card-box__body">
        <div class="form-img clearfix">
            <table class='table'>
                @foreach($postLists as $postList)
                <tr>
                    <td><span class="flag-icon flag-icon-{{$postList['language']['flag_code']}}" ></span></td>
                    @if( $postList['post'] )
                    <td>
                        <a href="{{ route('admin.'.get_current_post_type_args('route').'.edit', $postList['post']->id) }}">
                            @if( get_post_title($postList['post']) == "" )
                            Untitled
                            @else
                            {{ get_post_title($postList['post']) }}
                            @endif
                        </a>
                    </td>
                    @else
                    <td>
                        <a href="{{ route('aksara-multibas-generate-translation',['postId'=>$post->id,'lang'=>$postList['language']['language_code']]) }}">
                        <span class="glyphicon glyphicon-plus"></span>
                        {{ __('plugin:aksara-multi-bas::default.create-translation') }}
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>
