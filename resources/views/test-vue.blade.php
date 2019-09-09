@extends('layouts.app')

@section('title') Test Vue @endsection

@section('content')
    <div id="app"></div>
@endsection

@push('custom_scripts')
    <script src="{{ asset('js/test-vue.js') }}" defer></script>
@endpush
