<?php
// modify post ordering

function save_metabox_thumbnail($post)
{
    if (\Request::input('post_thumbnail')) {
        set_post_meta($post->id, 'featured_image_post_id', \Request::input('post_thumbnail'));
    }
    else {
        delete_post_meta($post->id, 'featured_image_post_id');
    }
}

function save_metabox_page_template($post)
{
    if (\Request::input('page_template')) {
        set_post_meta($post->id, 'page_template', \Request::input('page_template'));
    }
    else {
        delete_post_meta($post->id, 'page_template');
    }

    return $post;
}

function render_metabox_page_template($post)
{
    $pageTemplates = $pageTemplates = \Config::get('aksara.post-type.page-templates', []);
    $pageTemplate = get_page_template($post);

    if (sizeof($pageTemplates) == 0) {
        return;
    }

    $pageTemplatesDefault['default'] = 'Default';
    // FLIP LIKE A PRO
    $pageTemplates = array_flip($pageTemplates);

    $pageTemplates = $pageTemplatesDefault + $pageTemplates ;

    echo view('post-type::partials.metabox-page-template', compact('pageTemplates', 'pageTemplate'))->render();
}

function render_metabox_media($post)
{
    echo view('post-type::partials.metabox-media', compact('post'))->render();
}


function render_metabox_thumbnail($post)
{
    aksara_media_uploader();
    echo view('post-type::partials.metabox-thumbnail', compact('post', 'taxonomies'))->render();
}

function render_metabox_taxonomy($post)
{
    $taxonomies = get_taxonomies($post->post_type);

    if (!$taxonomies) {
        return;
    }

    echo view('post-type::partials.metabox-taxonomy', compact('post', 'taxonomies'))->render();
}

function render_metabox_save_post($post)
{
    echo view('post-type::partials.metabox-save-post', compact('post'))->render();
}

function render_metabox_editor($post)
{
    aksara_admin_enqueue_script(url('assets/modules-v2/post-type/plugins/tinymce/tinymce.min.js'));
    \Eventy::addAction('aksara.admin.footer', function () {
?>
        <script type="text/javascript">
        $(document).ready(function () {
            if ($("#texteditor").length > 0) {
                tinymce.init({
                selector: "textarea#texteditor",
                    theme: "modern",
                    height: 300,
                    menubar: false,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | code",
                    style_formats: [
            {title: 'Header 1', format: 'h1'},
            {title: 'Header 2', format: 'h2'},
            {title: 'Header 3', format: 'h3'},
            {title: 'Header 4', format: 'h4'},
            {title: 'Header 5', format: 'h5'},
            {title: 'Header 6', format: 'h6'},
            {title: 'Code', icon: 'code', format: 'code'}
        ]
            });
            }
        });
        </script>
<?php
    });

    echo view('post-type::partials.metabox-editor', compact('post'))->render();
}

function render_metabox_title($post)
{
    echo view('post-type::partials.metabox-title', compact('post'))->render();
}

