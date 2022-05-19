<div class="form-group mb-3">

    <label class="control-label">{{ trans('plugins/simple-slider::simple-slider.select_slider') }}</label>
   {!! Form::customSelect('key', $sliders, Arr::get($attributes, 'key'),array_merge(['class' => 'form-control'], $attributes)) !!}
</div>

<div class="form-group mb-3">
        <label class="control-label">{{ trans('plugins/simple-slider::simple-slider.mobile_hidden') }}</label>
        {!! Form::checkbox('mobile_hidden', 1, ((Arr::get($attributes, 'mobile_hidden')==1)?true:null)) !!}
    </div>
    <div class="form-group mb-3">
        <label class="control-label">{{ trans('plugins/simple-slider::simple-slider.desktop_hidden') }}</label>
        {!! Form::checkbox('desktop_hidden', 1, ((Arr::get($attributes, 'desktop_hidden')==1)?true:null)) !!}
    </div>
<div class="form-group mb-3">
        <label class="control-label">{{ trans('plugins/simple-slider::simple-slider.extra_class') }}</label>
        {!! Form::text('extra_class', Arr::get($attributes, 'extra_class'),array_merge(['class' => 'form-control'], $attributes)) !!}
    </div>
