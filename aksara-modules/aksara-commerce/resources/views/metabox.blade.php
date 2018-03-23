<div class="card-box">
    <div class="card-box__header">
        <h2>@lang('aksara-commerce::global.product-information')</h2>
    </div>
    <div class="card-box__body">
        <div action="" class="form-horizontal">
            <div class="form-group row">
                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">@lang('aksara-commerce::global.price')</label>
                <div class="col-sm-10 col-xs-8 col-xxs-12">
                    <input class="form-control" type="number" name="aksara_commerce[price]" value="{{ old('aksara_commerce[price]',get_post_meta($post->id,'price',0)) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">@lang('aksara-commerce::global.stock')</label>
                <div class="col-sm-10 col-xs-8 col-xxs-12">
                  <input class="form-control" type="number" name="aksara_commerce[stock]" value="{{ old('aksara_commerce[stock]',get_post_meta($post->id,'stock',0)) }}">
                </div>
            </div>
        </div>
    </div>
</div>
