@extends('layouts.master')
@section('title') Check-In List @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Check-In List @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Check-In List</h4>

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
                                        <option value="">Choose One</option>
                                        <option value="" selected>All</option>
                                        <option  value="9">Pending</option>
                                        <option value="12">Completed</option>
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
                            <th class="sort" data-sort="id">Driver</th>
                            <th class="sort" data-sort="id">Direction</th>
                            <th class="sort" data-sort="customer_name">Load Type</th>
                            <th class="sort" data-sort="product_name">Order Ref</th>
                            <th class="sort" data-sort="product_name">Arrival Time</th>
                            <th class="sort" data-sort="product_name">Verify Status</th>
                            <th class="sort" data-sort="product_name">@lang('translation.status')</th>
                            <th class="sort" data-sort="date">@lang('translation.action')</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    @include('admin.checkin.checkin-modals')



    @endsection
    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/checkin/checkin.js') }}"></script>
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
                    url: "order-contact-list",
                    data: function (d) {
                        d.s_name = $('input[name=s_name]').val(),
                            d.s_status = $('select[name=s_status]').val()
                    }
                },
                columns: [
                    { data: 'carrier.carrier_company_name' },
                    { data: 'order.order_type' },
                    { data: 'order.dock.load_type.eq_type.value' },
                    { data: 'order.order_id'},
                    { data: 'arrival_time' },
                    { data: 'is_verify' },
                    { data: 'status' },
                    { data: null, orderable: false },
                ],
                columnDefs: [
                    {
                        targets: 1,
                        render: function(data, type, row, meta) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Inbound</span>';
                            } else  {
                                return '<span class="badge bg-danger">Outbound</span>';
                            }
                        }
                    },
                    {
                        targets: 5,
                        render: function(data, type, row, meta) {
                            if (data == 'Verified') {
                                return '<span class="badge bg-success">'+data+'</span>';
                            } else  {
                                return '<span class="badge bg-danger">'+data+'</span>';
                            }
                        }
                    },
                    {
                        targets: 6,
                        render: function(data, type, row, meta) {
                                return '<span class="badge bg-primary'+data.class_name+' '+data.text_class + ' text-uppercase">'+data.status_title+'</span>';
                        }
                    },
                    {
                        targets: 7,
                        render: function(data, type, row, meta) {
                            const rowId = data.id;
                            const status = data.status;
                            const whId = data.order.wh_id ;
                            const orderId = data.order_id ;
                            var url = "{{ route('admin.carrier.verify', ':id') }}";
                            var checkInurl = "{{ route('admin.checkin.view', ':id') }}";
                            if(data.is_verify=='Verified')
                            {

                                if(status.id == 12){
                                    return '@canany('admin-checkin-create')<a href="'+url.replace(':id', rowId)+'" type="button" class="btn btn-primary me-2">View Carrier Documents</a>'+
                                    '<a href="'+checkInurl.replace(':id', rowId)+'" type="button" class="btn btn-primary">View CheckIn</a>@endcanany'
                                }else{
                                    return '@canany('admin-checkin-create')<a href="#" type="button" class="btn btn-primary btn-check-in me-2" data="'+rowId+'" whId="'+whId+'" orderId="'+orderId+'" data-bs-toggle="modal" data-bs-target="#checkInModal">Check In Now</a>'+
                                    '<a href="'+url.replace(':id', rowId)+'" type="button" class="btn btn-primary">View Carrier Document</a>@endcanany';
                                }
                            }
                            else{
                                return '<a href="'+url.replace(':id', rowId)+'" type="button" class="btn btn-primary">Verify Carrier Documents</a>';
                            }
                        }
                    }
                ]
            });
        });
    </script>
    @endsection
