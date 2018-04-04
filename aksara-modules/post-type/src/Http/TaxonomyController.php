<?php

namespace Plugins\PostType\Http;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Plugins\PostType\Model\Taxonomy;
use Plugins\PostType\Model\Term;
use Plugins\PostType\Model\TermRelationship;
use Plugins\PostType\Repository\TaxonomyRepositoryInterface;

class TaxonomyController extends Controller
{
    //public function __construct(TaxonomyRepositoryInterface $term)
    //{
    //    $this->term = $term;
    //}

    public function index(Request $request)
    {
        $terms = Term::orderBy('terms.id');

        $taxonomy = Taxonomy::where('taxonomy_name', get_current_taxonomy())->first();

        $terms = $terms->where('terms.taxonomy_id', $taxonomy->id);

        if ($request->input('search')) {
            $search = $request->input('search');
            $terms = $terms->leftjoin('terms as terms1', 'terms1.id', '=', 'terms.parent');
            $terms = $terms->where('terms.name', 'LIKE', '%'.$search.'%')->orWhere('terms1.name', 'LIKE', '%'.$search.'%');
        } else {
            $search = '';
        }

        $total = $terms->count();
        $terms = $terms->select('terms.*')->paginate(10);


        return view('post-type::taxonomy.index', compact('terms', 'taxonomy', 'search', 'total'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $term = new Term();
        $term->parent = 0;
        if ($request->input('taxonomy')) {
            $taxo = $request->input('taxonomy');
        } else {
            $taxo = 'category';
        }

        $taxonomy = Taxonomy::where('taxonomy_name', get_current_taxonomy())->first();
        $parent = Term::orderBy('name')->where('taxonomy_id', $taxonomy->id)->get()->pluck('name', 'id');

        $parent = reset($parent);
        $parent['0'] = '-';

        return view('post-type::taxonomy.create', compact('term', 'taxonomy', 'parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // if($data['slug'])
        // {
        //     $data['slug'] = $this->term->getSlug(str_slug($data['slug'],'-'));
        // } else {
        //     $data['slug'] = $this->term->getSlug(str_slug($data['name'],'-'));
        // }

        $data = add_term($data['taxonomy'], $data['name'], $data['slug'], $data['parent']);

        if ($data) {
            admin_notice('success', __('post-type::message.add-success-message'));
            return redirect()->route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.index');
        } elseif (!$data) {
            return redirect()->route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.create')
                            ->withInput();
        } elseif (!$data->fails()) {
            return redirect()->route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.create')
                            ->withErrors($data)
                            ->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = Term::find($id);
        $taxonomy = Taxonomy::find($term->taxonomy_id);
        $parent = Term::orderBy('name')->where('taxonomy_id', $taxonomy->id)->where('id', '<>', $id)->get()->pluck('name', 'id');
        $parent = reset($parent);
        $parent['0'] = '-';

        return view('post-type::taxonomy.edit', compact('term', 'taxonomy', 'parent'));
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
        $data = $request->all();

        $data = update_term($data['id'], $data['name'], $data['slug'], $data['parent']);

        if (!$data) {
            return redirect()->route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.edit', $id)
//                            ->withErrors($validator)
                            ->withInput();
        }
        admin_notice('success', __('post-type::message.edit-success-message'));
        return redirect()->route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $term = Term::find($id);
        if ($term) {
            TermRelationship::where('term_id', $id)->delete();
            delete_term($id);
        }
        admin_notice('success', __('post-type::message.delete-success-message'));
        return redirect()->route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.index');
    }
}
