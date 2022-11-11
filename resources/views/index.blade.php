@extends('layouts.index')

@section('Title', 'UPST-DLH')
@section('MainMenu', 'Dashboard')
@section('PageTitle', 'Timbangan')

@push('styles')@endpush

@section('content')
    <livewire:admin.index>
@endsection

@push('scripts')
<script>
    jQuery(document).ready(function(){
        setTimeout(function() {
            dezSettingsOptions.layout = 'horizontal';
            dezSettingsOptions.headerPosition = 'static';
            dezSettingsOptions.primary = 'color_14';
            dezSettingsOptions.sidebarBg = 'color_14';
            new dezSettings(dezSettingsOptions);
        },500)
    });
</script>

@endpush