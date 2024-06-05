
@extends('layouts.master')
@section('title') @lang('translation.users') @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Create Order @endslot
    @endcomponent
    @include('combine')

@include('client.screens.appointment.order-container')


@endsection


    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/appointment/createOrder.js') }}"></script>
@endsection



