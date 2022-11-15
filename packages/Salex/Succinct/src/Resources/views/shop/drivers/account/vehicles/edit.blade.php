@extends('succinct::drivers.account.index')

@section('page_title')
{{ __('driver::app.vehicles.edit-title') }}
@endsection

@section('page-detail-wrapper')
<div class="account-head mb-15">
    <span class="account-heading">{{ __('driver::app.vehicles.edit-title') }}</span>

    <span></span>
</div>


<form method="POST" @submit.prevent="onSubmit" action="{{ route('driver.vehicles.update',$vehicle->id) }}" enctype="multipart/form-data">

    <div class="account-table-content">

        @method('PUT')

        @csrf


        <div :class="`row ${errors.has('type') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('driver::app.vehicles.type') }}
            </label>

            <div class="col-12">
                <input value="{{  old('type')?: $vehicle->type }}" name="type" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('driver::app.vehicles.type') }}&quot;" />
                <span class="control-error" v-if="errors.has('type')" v-text="errors.first('type')"></span>
            </div>
        </div>


        <div :class="`row ${errors.has('model') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('driver::app.vehicles.model') }}
            </label>

            <div class="col-12">
                <input value="{{  old('model')?: $vehicle->model }}" name="model" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('driver::app.vehicles.model') }}&quot;" />
                <span class="control-error" v-if="errors.has('model')" v-text="errors.first('model')"></span>
            </div>
        </div>

        <div :class="`row ${errors.has('color') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('driver::app.vehicles.color') }}
            </label>

            <div class="col-12">
                <input value="{{  old('color')?: $vehicle->color }}" name="color" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('driver::app.vehicles.color') }}&quot;" />
                <span class="control-error" v-if="errors.has('color')" v-text="errors.first('color')"></span>
            </div>
        </div>

        <div :class="`row ${errors.has('year') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('driver::app.vehicles.year') }}
            </label>

            <div class="col-12">
                <input value="{{  old('year')?: $vehicle->year }}" name="year" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('driver::app.vehicles.year') }}&quot;" />
                <span class="control-error" v-if="errors.has('year')" v-text="errors.first('year')"></span>
            </div>
        </div>


        <div :class="`row ${errors.has('plate_no') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('driver::app.vehicles.plate-no') }}
            </label>

            <div class="col-12">
                <input value="{{  old('plate_no')?: $vehicle->plate_no }}" name="plate_no" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('driver::app.vehicles.plate-no') }}&quot;" />
                <span class="control-error" v-if="errors.has('plate_no')" v-text="errors.first('plate_no')"></span>
            </div>
        </div>


        <div :class="`row ${errors.has('vin_no') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('driver::app.vehicles.vin-no') }}
            </label>

            <div class="col-12">
                <input value="{{  old('vin_no')?: $vehicle->vin_no }}" name="vin_no" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('driver::app.vehicles.vin-no') }}&quot;" />
                <span class="control-error" v-if="errors.has('vin_no')" v-text="errors.first('vin_no')"></span>
            </div>
        </div>


        <div class="row image-container {!! $errors->has('image.*') ? 'has-error' : '' !!}">
            <label class="col-12">
                {{ __('admin::app.catalog.categories.image') }}
            </label>

            <div class="col-12">
                <image-wrapper :button-label="'{{ __('admin::app.catalog.products.add-image-btn-title') }}'" input-name="image" :multiple="false" :images='"{{ $vehicle->image_url }}"'></image-wrapper>

                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                    @foreach ($errors->get('image.*') as $key => $message)
                    @php echo str_replace($key, 'Image', $message[0]); @endphp
                    @endforeach
                </span>
            </div>
        </div>



        <button type="submit" class="theme-btn mb20">
            {{ __('driver::app.vehicles.save-btn-title') }}
        </button>
    </div>
</form>

@endsection