
@extends('layouts.master')
@section('title') WMS Order Detail  @endsection
@section('css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_2') Work Orders List @endslot
        @slot('routeUrl2') {{route('admin.work.orders.index')}} @endslot
        @slot('title') Work Order Detail @endslot
    @endcomponent
    <input type="number" class="d-none" value="{{$data['orderDetail']['data']['id'] ?? "-"}}" name="hidden_order_id" placeholder="hidden order id">
    @include('admin.outbounds.work-orders.wms-order-detail-container')
    @include('admin.components.comon-modals.common-modal')
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderList.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderDetail.js') }}"></script>
@endsection

