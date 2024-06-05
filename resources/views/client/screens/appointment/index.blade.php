
@extends('client.layouts.master')
@section('title') @lang('translation.new-appointment') @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">New Appointment</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Appointment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('combine')
@include('client.screens.appointment.order-container')
    @include('admin.components.comon-modals.common-modal')
@endsection

@section('script')
        <script src="{{ URL::asset('build/js/custom-js/appointment/createOrder.js') }}"></script>
    @endsection

