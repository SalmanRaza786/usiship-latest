
@extends('client.layouts.master')
@section('title') WMS Orders List @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">WMS Orders List</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">WMS Orders List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-12">

            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">WMS Orders List</h4>
                    </div>

                        <div class="col-auto justify-content-sm-end">
                            <div class="dropdown">
                                <a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action With Selected
                                </a>
                                <div class="dropdown-menu" style="">
                                    <form id="arrayForm" action="{{ route('schedule.work.order.client') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="array_data" id="workOrdersArray">
                                        <button id="btn-schedule" type="submit" class="dropdown-item cursor-pointer " >Schedule Orders</button>
                                    </form>
                                </div>
                            </div>
{{--                            <a href="{{route('user.appointment.index')}}" class="btn btn-success "id="create-btn" ><i class="ri-add-line align-bottom me-1"></i> Book New Appointment</a>--}}
                        </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-7 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder=" {{__('translation.search')}}" name="s_name">
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
                                        <option value="206">Scheduled</option>
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
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle" id="roleTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th scope="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="master">
                                        <label class="form-check-label" for="cardtableCheck"></label>
                                    </div>
                                </th>
                                <th class="sort">Transaction No.</th>
                                <th class="sort">Order Reference</th>
                                <th class="sort">Customer Name</th>
                                <th class="sort">Carrier</th>
                                <th class="sort">Order Date</th>
                                <th class="sort">Status</th>
{{--                                <th class="sort">Picker Name</th>--}}
{{--                                <th class="sort">Action</th>--}}
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <!-- end col -->
    </div>
    @include('admin.outbounds.work-orders.work-order-modals')
@endsection
@section('script')


    <script src="{{ URL::asset('build/js/custom-js/workOrders/workOrders.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#roleTable').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                info: true,
                bFilter: false,
                ordering: true,
                bLengthChange: true,
                order: [[ 0, "desc" ]],
                lengthMenu:[[10,50,100,-1],[10,50,100,"All"]],
                ajax: {
                    url: "work-orders-list-client",
                    data: function (d) {
                        d.s_title = $('input[name=s_title]').val(),
                            d.s_status = $('select[name=s_status]').val()
                    },
                },
                columns: [
                    { data: 'id'},
                    { data: 'wms_transaction_id',orderable: true },
                    { data: 'order_reference',orderable: true },
                    { data: 'client.title',orderable: true },
                    { data: null },
                    { data: 'order_date',orderable: true },
                    { data: null },
                    // { data: 'picker.name',orderable: true },
                    // { data: null, orderable: false },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        render: function(data, type, row, meta) {
                            return  '<div class="form-check">'+
                                '<input class="form-check-input sub_chk" type="checkbox" value="'+ data +'" id="cardtableCheck01">'+
                                '<label class="form-check-label" for="cardtableCheck01"></label>'+
                                '</div>';

                        }
                    },
                    {
                        targets: 4,
                        orderable: true,
                        render: function(data, type, row, meta) {
                            return (data.carrier ? data.carrier?.carrier_company_name : "-");

                        }
                    },
                    {
                        targets: 6,
                        orderable: true,
                        render: function(data, type, row, meta) {
                            if (data.status_code == 204) {
                                return '<span class="badge badge-soft-success text-uppercase">'+data.status.status_title+'</span>';
                            } else if(data.status_code == 206) {
                                return '<span class="badge badge-soft-primary text-uppercase">'+data.status.status_title+'</span>';
                            } else  {
                                return '<span class="badge badge-soft-danger text-uppercase">'+data.status.status_title+'</span>';
                            }
                        }
                    },
                    // {
                    //     targets: 7,
                    //     render: function(data, type, row, meta) {
                    //         return (data ? data : "-");
                    //
                    //     }
                    // },

                    {{--{--}}
                    {{--    targets: 8,--}}
                    {{--    render: function(data, type, row, meta) {--}}

                    {{--        var btnAssign = ' @canany('admin-w-order-create')<a href="#" type="button" class="btn btn-primary btn-assign" data='+data.id+' data-bs-toggle="modal" data-bs-target="#checkInModal">Assign Now</a>@endcanany';--}}
                    {{--        var btnUploadDoc = ' @canany('admin-w-order-edit')<a href="#" type="button" class="btn btn-primary btn-upload-bol" data='+data.id+'  data-bs-toggle="modal" data-bs-target="#UploadBOLDoc">Upload Bol Document</a>@endcanany';--}}
                    {{--        var btnScheduleNow = ' @canany('admin-w-order-edit')<a href="#" type="button" class="btn btn-primary btn-schedule" data='+data.id+'  data-bs-toggle="modal" data-bs-target="#showModalSchedule">Schedule Now</a>@endcanany';--}}
                    {{--        var btnGroup='';--}}
                    {{--        if(row.status.order_by==201){--}}
                    {{--            btnGroup=  "-";--}}
                    {{--        }--}}
                    {{--        if(row.status.order_by==204){--}}
                    {{--            // btnGroup=  btnUploadDoc+ ' ' + btnScheduleNow;--}}
                    {{--            btnGroup=   btnScheduleNow;--}}
                    {{--        }--}}
                    {{--        return btnGroup;--}}
                    {{--    }--}}
                    {{--}--}}
                ]
            });

        });
    </script>
@endsection
