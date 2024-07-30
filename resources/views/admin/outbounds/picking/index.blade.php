@extends('layouts.master')
@section('title') Picking List @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Picking List @endslot
    @endcomponent
    @include('components.common-error')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0"> Picking List </h4>
                    </div>
                    @canany('admin-role-create')
                    <div class="col-auto justify-content-sm-end">

                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal"><i class="ri-add-line align-bottom me-1"></i> Import WMS Orders</button>
                    </div>
                        @endcanany
                </div><!-- end card header -->
                <div class="card-body border border-dashed border-end-0 border-start-0">

                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-7 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder=" {{__('translation.search')}}" name="s_title">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <select class="form-control"  name="s_status">
                                        <option value="">Status</option>
                                        <option value="" selected>{{__('translation.all')}}</option>
                                        <option value="1">Active</option>
                                        <option value="2">In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" id="filter"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        {{__('translation.filter')}}
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>

                <div class="card-body pt-0">
                        <table class="table table-nowrap align-middle" id="roleTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th class="sort">Customer Name</th>
                                <th class="sort">Direction</th>
                                <th class="sort">Load Type</th>
                                <th class="sort">Order Ref</th>
                                <th class="sort">Carrier</th>
                                <th class="sort">Status</th>
                                <th class="sort">Action</th>
                            </tr>
                            </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @include('admin.outbounds.work-orders.work-order-modals')


@endsection

@section('script')


    <script src="{{ URL::asset('build/js/custom-js/workOrders/workOrders.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#roleTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            info: true,
            bFilter: false,
            ordering: false,
            bLengthChange: false,
            order: [[ 0, "desc" ]],
            ajax: {
                url: "picker-list",

                data: function (d) {
                    d.s_title = $('input[name=s_title]').val(),
                        d.s_status = $('select[name=s_status]').val()

                },

                // dataSrc: function(response) {
                //     console.log('response',response.data[0].work_order.load_type);
                // }

            },

            columns: [
                { data: 'work_order.client.name' },
                { data: 'work_order.load_type.direction.value' },
                { data: 'work_order.load_type.eq_type.value' },
                { data: 'work_order.order_reference' },
                { data: 'work_order.carrier.carrier_company_name' },
                { data: 'status.status_title' },
                { data: null, orderable: false },
            ],

            columnDefs: [

                {
                    targets: 6,
                    render: function(data, type, row, meta) {

                        var StartPicking = ' @canany('admin-permission-view')<a href="{{url('admin/start-picking')}}"  class="btn btn-primary btn-assign" >Start Picking </a>@endcanany';
                        var btnGroup=StartPicking;

                        return btnGroup;
                    }
                }
            ]
        });

    });
</script>
@endsection


