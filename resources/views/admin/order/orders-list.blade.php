
@extends('layouts.master')
@section('title') Orders List @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Orders List @endslot
    @endcomponent

   <div class="row">
       <input type="number" class="d-none" name="hidden_order_id" >
                    <div class="col-12">
                        <div class="row">
                            <div class="col-xl-3 d-none1">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <button class="btn btn-primary w-100" id="btn-new-event"><i class="mdi mdi-plus"></i> Create New Order</button>
{{--                                          <a href="{{route('admin.order.create')}}" class="btn btn-primary w-100"><i class="mdi mdi-plus"></i> Create New Order</a>--}}

                                        <div id="external-events">
                                            <br>
{{--                                            <p class="text-muted">Drag and drop your event or click in the calendar</p>--}}

                                            @isset($data['status'])
                                            @foreach($data['status'] as $status)
                                            <div class="external-event fc-event {{$status->class_name}} {{$status->text_class}}"  data-class="{{$status->class_name}}">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>{{$status->status_title}}
                                            </div>
                                            @endforeach
                                            @endisset

                                        </div>

                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-1">Upcoming Orders</h5>
                                    <p class="text-muted">Don't miss scheduled orders</p>
                                    <div class="pe-2 me-n1 mb-3" data-simplebar style="height: 400px">
                                        <div id="upcoming-event-list"></div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body bg-soft-info">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i data-feather="calendar" class="text-info icon-dual-info"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15">Welcome to your Calendar!</h6>
                                                <p class="text-muted mb-0">Event that applications book will appear here. Click on an event to see the details and manage applicants event.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->
                            </div>

                            <div class="col-xl-9">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


@include('admin.order.order-modal')
@include('client.screens.appointment.appointment-modals')


                    </div>
                </div>


@endsection


@section('script')
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderList.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom-js/orders/order.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom-js/appointment/calendar.init.js')}}"></script>

@endsection



