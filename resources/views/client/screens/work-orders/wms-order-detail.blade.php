
@extends('client.layouts.master')
@section('title') WMS Order Detail  @endsection
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">WMS Order Detail</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('user.appointment.show-wms-orders')}}">WMS Orders List</a></li>
                        <li class="breadcrumb-item active">WMS Order Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-12">
            <input type="number" class="d-none" value="{{$data['orderDetail']['data']['id'] ?? "-"}}" name="hidden_order_id" placeholder="hidden order id">
            @include('admin.outbounds.work-orders.wms-order-detail-container')
        </div>
    </div>
    @include('admin.components.comon-modals.common-modal')
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderList.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderDetail.js') }}"></script>
@endsection

