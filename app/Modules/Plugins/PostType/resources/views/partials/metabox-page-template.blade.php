<div class="card-box post-box">
    <div class="card-box__header">
        <h2>Page Template</h2>
    </div>
    <div class="card-box__body category-wrap">
        {!! Form::select('page_template', $pageTemplates, $pageTemplate, array('class' => 'form-control')); !!}
    </div>
</div>
