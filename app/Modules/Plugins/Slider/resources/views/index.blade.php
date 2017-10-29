@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Option</li>
</ol>
@endsection
@section('content')
<div class="container">
    <div class="content__head">
        <h2 class="page-title">Slider</h2>
    </div>
    <!-- /.content__head -->
    <div class="content__body page-slider">
        <div class="vertical-tabs row">
            <ul class="nav nav-pills nav-stacked col-md-2">
                <li class="active">
                    <a href="#homepage" data-toggle="pill">Slider Homepage</a>
                </li>
                <li>
                    <a href="#person" data-toggle="pill">Slider Person</a>
                </li>
                <li>
                    <a href="#tab_c" data-toggle="pill">Slider C</a>
                </li>
                <li>
                    <a href="#tab_d" data-toggle="pill">Slider D</a>
                </li>
            </ul>
            <div class="card-box col-md-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="homepage">
                        <form action="">
                            <div class="tab-pane__body repeat-wrap">
                                <h2>Slider Homepage <a href="javascript:void(0);" class="page-title-action repeat-trigger" data-max="10">Tambah Item Slide</a></h2>
                                <div class="item-box repeatable-base">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete hidden" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style=""></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-box repeatable">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete hidden" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style="display: none;"></textarea><div class="CodeMirror cm-s-ambiance"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea style="position: absolute; bottom: -1em; padding: 0px; width: 1px; height: 1em; outline: medium none;" autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" wrap="off"></textarea></div><div class="CodeMirror-vscrollbar" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1" draggable="true"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines"><div style="position: relative; outline: medium none;"><div class="CodeMirror-measure"><span><span>​</span>x</span></div><div class="CodeMirror-measure"><pre class="CodeMirror-line"><span><span style="display: inline-block; width: 1px; margin-right: -1px;" cm-text="">&nbsp;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code"></div></div></div></div></div><div style="position: absolute; height: 30px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-box repeatable">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style="display: none;"></textarea><div class="CodeMirror cm-s-ambiance"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea style="position: absolute; bottom: -1em; padding: 0px; width: 1px; height: 1em; outline: medium none;" autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" wrap="off"></textarea></div><div class="CodeMirror-vscrollbar" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1" draggable="true"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines"><div style="position: relative; outline: medium none;"><div class="CodeMirror-measure"><span><span>​</span>x</span></div><div class="CodeMirror-measure"><pre class="CodeMirror-line"><span><span style="display: inline-block; width: 1px; margin-right: -1px;" cm-text="">&nbsp;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code"></div></div></div></div></div><div style="position: absolute; height: 30px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-box repeatable">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style="display: none;"></textarea><div class="CodeMirror cm-s-ambiance"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea style="position: absolute; bottom: -1em; padding: 0px; width: 1px; height: 1em; outline: medium none;" autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" wrap="off"></textarea></div><div class="CodeMirror-vscrollbar" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1" draggable="true"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines"><div style="position: relative; outline: medium none;"><div class="CodeMirror-measure"><span><span>​</span>x</span></div><div class="CodeMirror-measure"><pre class="CodeMirror-line"><span><span style="display: inline-block; width: 1px; margin-right: -1px;" cm-text="">&nbsp;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code"></div></div></div></div></div><div style="position: absolute; height: 30px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane__footer">
                                <div class="submit-row clearfix">
                                    <a href="#" class="btn btn-md btn-danger alignleft">Hapus Slider Homepage</a>
                                    <input class="btn btn-md btn-primary alignright" value="Simpan Slider Homepage" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="person">
                        <form action="">
                            <div class="tab-pane__body repeat-wrap">
                                <h2>Slider Person <a href="javascript:void(0);" class="page-title-action repeat-trigger" data-max="10">Tambah Item Slide</a></h2>
                                <div class="item-box repeatable-base">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete hidden" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style=""></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-box repeatable">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete hidden" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style="display: none;"></textarea><div class="CodeMirror cm-s-ambiance"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea style="position: absolute; bottom: -1em; padding: 0px; width: 1px; height: 1em; outline: medium none;" autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" wrap="off"></textarea></div><div class="CodeMirror-vscrollbar" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1" draggable="true"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines"><div style="position: relative; outline: medium none;"><div class="CodeMirror-measure"><span><span>​</span>x</span></div><div class="CodeMirror-measure"><pre class="CodeMirror-line"><span><span style="display: inline-block; width: 1px; margin-right: -1px;" cm-text="">&nbsp;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code"></div></div></div></div></div><div style="position: absolute; height: 30px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-box repeatable">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style="display: none;"></textarea><div class="CodeMirror cm-s-ambiance"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea style="position: absolute; bottom: -1em; padding: 0px; width: 1px; height: 1em; outline: medium none;" autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" wrap="off"></textarea></div><div class="CodeMirror-vscrollbar" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1" draggable="true"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines"><div style="position: relative; outline: medium none;"><div class="CodeMirror-measure"><span><span>​</span>x</span></div><div class="CodeMirror-measure"><pre class="CodeMirror-line"><span><span style="display: inline-block; width: 1px; margin-right: -1px;" cm-text="">&nbsp;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code"></div></div></div></div></div><div style="position: absolute; height: 30px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-box repeatable">
                                    <div class="clearfix toggle-showmore">
                                        <div class="item-box--title alignleft">Slider Item</div>
                                        <div class="alignright btn-action-group">
                                            <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-box--more">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control form-item-title" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <textarea name="" id="code-editor" cols="30" rows="10" class="code-editor" style="display: none;"></textarea><div class="CodeMirror cm-s-ambiance"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea style="position: absolute; bottom: -1em; padding: 0px; width: 1px; height: 1em; outline: medium none;" autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" wrap="off"></textarea></div><div class="CodeMirror-vscrollbar" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1" draggable="true"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines"><div style="position: relative; outline: medium none;"><div class="CodeMirror-measure"><span><span>​</span>x</span></div><div class="CodeMirror-measure"><pre class="CodeMirror-line"><span><span style="display: inline-block; width: 1px; margin-right: -1px;" cm-text="">&nbsp;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code"></div></div></div></div></div><div style="position: absolute; height: 30px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Foto Mobile</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <div class="form-img clearfix">
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                    <p class="info-error">type file yang anda pilih salah</p>
                                                    <label class="form-file-wrapper btn btn-secondary">
                                                        Pilih Foto
                                                        <input class="file" name="gambar-utama" type="file">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Text Tombol</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Tombol Slider</label>
                                            <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane__footer">
                                <div class="submit-row clearfix">
                                    <a href="#" class="btn btn-md btn-danger alignleft">Hapus Slider Person</a>
                                    <input class="btn btn-md btn-primary alignright" value="Simpan Slider Person" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- tab content -->
            </div>
        </div>
    </div>
    <!-- /.content__body -->
</div>
@endsection