<?php
namespace App\Modules\Plugins\AksaraMultiBas\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Modules\Plugins\AksaraMultiBas\TranslationEngine;

class TranslationController extends Controller
{
    public function generate($postId,$lang)
    {
        $translationEngine = new TranslationEngine();
        $translatedPost = $translationEngine->createPostTranslation($postId,$lang);

        // redirect
        admin_notice('success', 'Translasi berhasil ditambahkan.');
        // dd(get_post_type_args('route',$translatedPost->post_type));

        return redirect()->route('admin.'.get_post_type_args('route',$translatedPost->post_type).'.edit', ['id'=>$translatedPost->id]);
    }

}
