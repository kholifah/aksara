<?php
namespace App\Modules\Plugins\PostType\Http;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Plugins\PostType\Model\Taxonomy;
use App\Modules\Plugins\PostType\Model\Term;
use App\Modules\Plugins\PostType\Model\Post;
use Illuminate\Support\Facades\File;
use App\Repositories\PostRepositoryInterface;

class PostController extends Controller
{
    public function __construct(PostRepositoryInterface $post)
    {
        $this->post = $post;
    }

    public function index(Request $request)
    {

        $posts = Post::setPostType();

        //@TODO dipindah ke controller untuk quick edit, gaboleh di index
        if ($request->get('bapply'))
        {
            if($request->input('apply'))
            {
                $apply = $request->input('apply');
                if($apply == 'trash'){
                    if($request->input('post_id'))
                    {
                        $post_id = $request->input('post_id');
                        foreach ($post_id as $v) {
                            $this->trash($v);
                        }
                    }
                } else if($apply == 'restore'){
                    if($request->input('post_id'))
                    {
                        $post_id = $request->input('post_id');
                        foreach ($post_id as $v) {
                            $this->restore($v);
                        }
                    }
                } else if($apply == 'destroy'){
                    if($request->input('post_id'))
                    {
                         $post_id = $request->input('post_id');
                        foreach ($post_id as $v) {
                            $this->destroy($v);
                        }
                    }
                }
            }
        }

        if ($request->get('bapplyall'))
        {
            $this->destroy_all();
        }

        $preGetPost = \Eventy::filter('aksara.post-type.'.get_current_post_type().'.index.pre-get-post', ['posts'=>$posts,'postsQueryArgs'=>[]] );

        $posts = $preGetPost['posts'];
        $postsQueryArgs = $preGetPost['postsQueryArgs'];

        $total = $posts->count();
        $count_post = [
            'all' => $this->post->get_total(),
            'publish' => $this->post->get_total_publish(),
            'draft' => $this->post->get_total_draft(),
            'pending' => $this->post->get_total_pending(),
            'trash' => $this->post->get_total_trash(),
        ];

        // Filter untuk manipulasi query
        $posts = $posts->select('posts.*')->paginate(10);
        $taxonomies = get_taxonomies(get_current_post_type());

        // Table Column
        $cols = \Eventy::filter('aksara.post-type.'.get_current_post_type().'.index.table.column',[],get_current_post_type());

        return view('plugin:post-type::post.index', compact('posts', 'postsQueryArgs', 'total', 'count_post','cols','taxonomies'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $post = new Post();
        $post->post_type = get_current_post_type();
        return view('plugin:post-type::post.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $post = new Post();

        $data = $request->all();
        $data['post_type'] = get_current_post_type();

        if ($request->file('post_image')) {
            if ($request->file('post_image')->isValid()) {
                $destinationPath = 'img/'; // upload path
                $extension = $request->file('post_image')->getClientOriginalName();
                $fileName = rand(11111, 99999) . '_' . str_replace(' ', '', $extension);
                $request->file('post_image')->move($destinationPath, $fileName);
                $data['post_image'] = $fileName;
            }
        } else {
            $data['post_image'] = '';
        }

        $validator = $post->validate($data);

        if ($validator->fails())
        {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return back()->withInput();
        }

        $post->post_type = get_current_post_type();
        $post->post_author = \Auth::user()->id;
        $post->post_date = date('Y-m-d H:i:s');
        $post->post_modified = date('Y-m-d H:i:s');
        $post->post_status = $data['post_status'];
        $post->post_title = $request->input('post_title','') == null ? "" : $request->input('post_title','') ;
        $post->post_slug = $request->input('post_slug','') == null ? "" : $request->input('post_slug','') ;
        $post->post_content = $request->input('post_content','') == null ? "" : $request->input('post_content','') ;
        $post->post_image = $data['post_image'];
        $post->save();

        \Eventy::action('aksara.post-type.'.get_current_post_type().'.create', $post, $request);

//        set_post_meta($post->id, 'post_content', $data['post_content'], false);
//        set_post_meta($post->id, 'post_slug', $data['slug'], false);

        if(isset($data['taxonomy']))
        {
            foreach ($data['taxonomy'] as $k => $v)
            {
                if($v)
                    foreach ($v as $v1) {
                        set_post_term($post->id, $k, (int)$v1);
                    }
            }
        }
        admin_notice('success', 'Data berhasil ditambahkan.');

        return redirect()->route('admin.'.get_current_post_type_slug().'.edit',['id'=>$post->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        // $metabox = \App::make('metabox');

        return view('plugin:post-type::post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $data = $request->all();
        $data['post_type'] = get_current_post_type();

        $validator = $post->validate($data);
        if ($validator->fails())
        {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return back()->withInput();
        }
        if ($request->file('post_image')) {
            if ($request->file('post_image')->isValid()) {
                $destinationPath = 'img/'; // upload path
                $extension = $request->file('post_image')->getClientOriginalName();
                if (File::exists($destinationPath . $post->post_image))
                {
                    File::delete($destinationPath . $post->post_image);
                }
                $fileName = rand(11111, 99999) . '_' . str_replace(' ', '', $extension);
                $request->file('post_image')->move($destinationPath, $fileName);
                $data['post_image'] = $fileName;
            }
        }
        $data['post_type'] = get_current_post_type();

        if(isset($data['post_type']))
            $post->post_type = get_current_post_type();
        if(isset($data['post_status']))
            $post->post_status = $data['post_status'];

        $post->post_title = $request->input('post_title','') == null ? "" : $request->input('post_title','') ;
        $post->post_slug = $request->input('post_slug','') == null ? "" : $request->input('post_slug','') ;
        $post->post_content = $request->input('post_content','') == null ? "" : $request->input('post_content','') ;

        if(isset($data['post_image']))
            $post->post_image = $data['post_image'];

        $post->post_author = \Auth::user()->id;
        $post->post_modified = date('Y-m-d H:i:s');
        $post->save();

        \Eventy::action('aksara.post-type.'.get_current_post_type().'.update',$post,$request);
        $key = [];
        if(isset($data['taxonomy']))
        {
            foreach ($data['taxonomy'] as $k => $v)
            {
                if($v)
                {
                    foreach ($v as $v1) {
                        set_post_term($id, $k, (int)$v1);
                        $key[] = (int)$v1;
                    }
                }
            }

        }

        if($key)
            \App\Modules\Plugins\PostType\Model\TermRelationship::where('post_id', $id)->whereNotIn('term_id', $key)->delete();
        else
            \App\Modules\Plugins\PostType\Model\TermRelationship::where('post_id', $id)->delete();
        admin_notice('success', 'Data berhasil diubah.');

        return redirect()->route('admin.'.get_current_post_type_slug().'.edit',['id'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post)
        {
            if ($post->post_image != '')
            {
                $destinationPath = 'img/'; // upload path
                if (File::exists($destinationPath . $post->post_image))
                {
                    File::delete($destinationPath . $post->post_image);
                }
            }
            delete_post_meta($id);
            delete_post_term($id);
            $post->delete();
            admin_notice('success', 'Data berhasil dihapus.');
        } else {
            admin_notice('danger', 'Tidak ada data yang dihapus.');
        }

        \Eventy::action('aksara.post-type.'.get_current_post_type().'.destroy',$post,$request);

        return redirect()->route('admin.'.get_current_post_type_slug().'.index', ['post_status' => 'trash']);
    }

    public function delete_img($id)
    {
        $post = Post::find($id);
        if ($post->post_image != '')
        {
            $destinationPath = 'img/'; // upload path
            if (File::exists($destinationPath . $post->post_image))
            {
                if(File::delete($destinationPath . $post->post_image))
                {
                $post->update(['post_image' => '']);
                return TRUE;
                } else {
                    return TRUE;
                }
            }
        }
    }

    public function trash($id)
    {
        $post = Post::find($id);
        if(set_post_meta($id, 'trash_meta_status', $post->post_status, false))
            $post->update(['post_status' => 'trash']);
        admin_notice('success', 'Data berhasil dipindah ke Trash.');
        return redirect()->route('admin.'.get_current_post_type_slug().'.index');
    }

    public function restore($id)
    {
        $post = Post::find($id);
        if(get_post_meta($id, 'trash_meta_status'))
            $post->update(['post_status' => get_post_meta($id, 'trash_meta_status')]);
        delete_post_meta($id, 'trash_meta_status');
        admin_notice('success', 'Data berhasil dikembalikan ke '.$post->post_status.'.');
        return redirect()->route('admin.'.get_current_post_type_slug().'.index', ['post_status' => $post->post_status]);
    }

    public function destroy_all()
    {
        $posts = Post::where('post_status', 'trash')->get();
        if($posts->count())
        {
            foreach ($posts as $v) {
                $this->destroy($v->id);
            }
            admin_notice('success', 'Semua data berhasil dihapus.');
        } else {
            admin_notice('danger', 'Data gagal dihapus.');
        }
        return redirect()->route('admin.'.get_current_post_type_slug().'.index');
    }


}
