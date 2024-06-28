@extends('layouts.master')
@section('title') Off Loading List @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Off Loading List @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Off Loading List</h4>
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
                                        <option selected value="12">Pending</option>
                                        <option value="3">In-Process</option>
                                        <option value="10">Completed</option>
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
                            <th class="sort" data-sort="id">Container</th>
                            <th class="sort" data-sort="id">Direction</th>
                            <th class="sort" data-sort="customer_name">Load Type</th>
                            <th class="sort" data-sort="product_name">Order Ref</th>
                            <th class="sort" data-sort="product_name">Arrival Time</th>
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
{{--    @include('admin.components.comon-modals.common-modal')--}}


@endsection
@section('script')
{{--    <script src="{{ URL::asset('build/js/custom-js/offloading/offloading.js') }}"></script>--}}
    <script>
        $(document).ready(function(){
            $('#filter').on('click', function() {
                $('#roleTable').DataTable().ajax.reload();
            });
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
                    url: "check-in-list",
                    data: function (d) {
                        d.s_name = $('input[name=s_name]').val(),
                            d.s_status = $('select[name=s_status]').val()
                    }
                },
                columns: [
                    { data: 'container_no' },
                    { data: 'order.order_type' },
                    { data: 'order.dock.load_type.eq_type.value' },
                    { data: 'order.order_id'},
                    { data: 'order_contact.arrival_time' },
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
                                return '<span class="badge '+data.class_name+' '+data.text_class+' text-uppercase">'+data.status_title+'</span>';
                        }
                    },
                    {
                        targets: 6,
                        render: function(data, type, row, meta) {
                            const rowId = data.id;
                            const whId = data.order.wh_id ;
                            const status = data.status ;
                            const orderId = data.order_id ;
                            if(status.id == 3)
                            {
                                return `@canany('admin-offloading-create')<a href="{{ route('admin.off-loading.detail', '') }}/${rowId}" type="button" class="btn btn-primary "  >Off Loading In-Progress</a>@endcanany`;
                            }else if(status.id == 10)
                            {
                                return `@canany('admin-offloading-create')<a href="#" type="button" class="btn btn-primary"  >Off Loading Completed</a>@endcanany`;
                            }else {
                                return `@canany('admin-offloading-create')<a href="{{ route('admin.off-loading.detail', '') }}/${rowId}" type="button" class="btn btn-primary btn-check-in"  >Start Off Loading Now</a>@endcanany`;
                            }

                        }
                    }
                ]
            });

        });
    </script>

@endsection
