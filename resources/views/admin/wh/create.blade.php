@extends('layouts.master')
@section('title') WareHouses @endsection
@section('css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') WareHouses @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body checkout-tab">
                    <div id="loadTypeSelectBox"></div>

                    <form  method="post" id="whInfoForm" action="{{route('admin.wh.store')}}">
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                            <input type="number" value="{{(isset($data['wh']))? $data['wh']->id:0}}" class="d-none" name="id">

                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-info" type="button" role="tab" aria-controls="pills-bill-info" aria-selected="true" data-position="0">
                                        <i class="ri-building-2-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Warehouse Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-hours-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-hours" type="button" role="tab" aria-controls="pills-bill-hours" aria-selected="false" data-position="1" tabindex="-1">
                                        <i class="ri-time-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Working Hours</button>
                                </li><li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-address-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-address" type="button" role="tab" aria-controls="pills-bill-address" aria-selected="false" data-position="1" tabindex="-1">
                                        <i class="ri-truck-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Load Type</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-payment-tab" data-bs-toggle="pill" data-bs-target="#pills-payment" type="button" role="tab" aria-controls="pills-payment" aria-selected="false" data-position="2" tabindex="-1">
                                        <i class="ri-map-pin-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Dock Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill" data-bs-target="#pills-finish" type="button" role="tab" aria-controls="pills-finish" aria-selected="false" data-position="3" tabindex="-1">
                                        <i class="ri-checkbox-circle-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Appointment Fields
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="pills-bill-info" role="tabpanel" aria-labelledby="pills-bill-info-tab">
                                @include('admin.wh.components.wh-info')
                            </div>
                                <div class="tab-pane fade" id="pills-bill-hours" role="tabpanel" aria-labelledby="pills-bill-hours-tab">
                                @include('admin.wh.components.working-hours')
                            </div>
                            <div class="tab-pane fade" id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">
                                @include('admin.wh.components.load-type')
                            </div>
                            <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">

                                @include('admin.wh.components.dock-info')
                            </div>

                            <div class="tab-pane fade" id="pills-finish" role="tabpanel" aria-labelledby="pills-finish-tab">
                                @include('admin.wh.components.appointment-fields')
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @include('admin.wh.wh-modals')


@endsection

@section('script')
    <script src="{{ URL::asset('build/js/custom-js/wh/wh.js') }}"></script>

@endsection

