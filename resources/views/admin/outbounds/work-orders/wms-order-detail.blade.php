
@extends('layouts.master')
@section('title') WMS Order Detail  @endsection
@section('css')
@endsection
@section('content')
    <input type="number" class="d-none" value="{{$data['orderDetail']['data']['id'] ?? "-"}}" name="hidden_order_id" placeholder="hidden order id">
    @include('admin.outbounds.work-orders.wms-order-detail-container')
    @include('admin.components.comon-modals.common-modal')
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderList.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderDetail.js') }}"></script>
@endsection

