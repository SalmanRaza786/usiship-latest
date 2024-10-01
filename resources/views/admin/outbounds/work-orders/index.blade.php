@extends('layouts.master')
@section('title') Work Orders @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') {{__('translation.settings')}} @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Work Orders @endslot
    @endcomponent
    @include('components.common-error')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Work Order List</h4>
                    </div>
                    @canany('admin-role-create')
                    <div class="col-auto justify-content-sm-end">

                        <button type="button" class="btn btn-success btn-import"><i class="ri-add-line align-bottom me-1"></i> Import WMS Orders</button>
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
                                        <option value="201">Open</option>
                                        <option value="202">Assign</option>
                                        <option value="204">Processed</option>
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
                                <th class="sort">Transaction No.</th>
                                <th class="sort">Order Reference</th>
                                <th class="sort">Customer Name</th>
                                <th class="sort">Carrier</th>
                                <th class="sort">Order Date</th>
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
                url: "work-orders-list",

                data: function (d) {
                    d.s_title = $('input[name=s_title]').val(),
                        d.s_status = $('select[name=s_status]').val()

                },

            },

            columns: [
                { data: 'wms_transaction_id' },
                { data: 'order_reference' },
                { data: 'client.title' },
                { data: null },
                { data: 'order_date' },
                { data: null },
                { data: null, orderable: false },
            ],

            columnDefs: [
                {
                    targets: 3,
                    render: function(data, type, row, meta) {
                        return (data.carrier ? data.carrier?.carrier_company_name : "-");

                    }
                },
                {
                    targets: 5,
                    render: function(data, type, row, meta) {
                        if (data.status_code == 204) {
                            return '<span class="badge badge-soft-success text-uppercase">'+data.status.status_title+'</span>';
                        } else  {
                            return '<span class="badge badge-soft-danger text-uppercase">'+data.status.status_title+'</span>';
                        }
                    }
                },

                {
                    targets: 6,
                    render: function(data, type, row, meta) {

                        var btnAssign = ' @canany('admin-permission-view')<a href="#" type="button" class="btn btn-primary btn-assign" data='+data.id+' data-bs-toggle="modal" data-bs-target="#checkInModal">Assign Now</a>@endcanany';
                        var btnUploadDoc = ' @canany('admin-role-edit')<a href="#" type="button" class="btn btn-primary btn-upload-bol" data='+data.id+'  data-bs-toggle="modal" data-bs-target="#UploadBOLDoc">Upload Bol Document</a>@endcanany';
                        var btnScheduleNow = ' @canany('admin-role-delete')<a href="#" type="button" class="btn btn-primary btn-schedule" data='+data.load_type_id+'  data-bs-toggle="modal" data-bs-target="#showModalSchedule">Schedule Now</a>@endcanany';
                        var btnGroup='';
                        if(row.status.order_by==201){
                             btnGroup=  btnAssign;
                        }
                        if(row.status.order_by==204){
                             btnGroup=  btnUploadDoc+ ' ' + btnScheduleNow;
                        }
                        return btnGroup;
                    }
                }
            ]
        });

    });
</script>
@endsection


