{{-- preloaded fonts --}}
<link rel="preload" href="{{ asset('themes/succinct/assets/fonts/font-rango/rango.ttf') . '?o0evyv' }}" as="font" crossorigin="anonymous" />

{{-- bootstrap --}}
<link rel="stylesheet" href="{{ asset('themes/succinct/assets/css/bootstrap.min.css') }}" />

{{-- bootstrap flipped for rtl --}}
@if (
    core()->getCurrentLocale()
    && core()->getCurrentLocale()->direction === 'rtl'
)
    <link href="{{ asset('themes/succinct/assets/css/bootstrap-flipped.css') }}" rel="stylesheet">
@endif

{{-- mix versioned compiled file --}}
<link rel="stylesheet" href="{{ asset(mix('/css/succinct.css', 'themes/succinct/assets')) }}" />

{{-- extra css --}}
@stack('css')

{{-- custom css --}}
<style>
    {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
</style>
