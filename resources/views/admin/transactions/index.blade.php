@extends('layouts.master')
@section('title') Transactions @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') {{__('translation.settings')}} @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Transactions @endslot
    @endcomponent
    @include('components.common-error')
    <div class="row">


        <div class="col-xl-12">

            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Transactions List</h4>
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

                                        @isset($data['statuses']['data'])
                                            @foreach($data['statuses']['data'] as $status)
                                                <option value="{{$status->id}}">{{$status->status_title}}</option>
                                            @endforeach
                                        @endisset
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
                    <table class="table" id="roleTable">
                        <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th class="sort" data-sort="id">Order#</th>
                            <th class="sort" data-sort="customer_name">Customer</th>
                            <th class="sort" data-sort="id">Warehouse</th>
                            <th class="sort" data-sort="customer_name">Dock</th>
                            <th class="sort" data-sort="customer_name">Order Date</th>
                            <th class="sort" data-sort="customer_name">Time Slot</th>
                            <th class="sort" data-sort="product_name">Status</th>
                            <th class="sort" data-sort="date">@lang('translation.action')</th>

                        </tr>
                        </thead>

                    </table>
                </div>
                <!-- end card body -->
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderList.js') }}"></script>
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
                    url: "transactions-list",
                    data: function (d) {
                        d.name = $('input[name=s_name]').val(),
                            d.status = $('select[name=s_status]').val()
                    }
                },
                columns: [
                    { data: 'order_id' },
                    { data: 'customer.name' },
                    { data: 'warehouse.title' },
                    { data: 'dock.dock.title' },
                    { data: 'order_date' },
                    { data: 'operational_hour.working_hour' },
                    { data: 'status.status_title' },
                    { data: null, orderable: false },
                ],
                columnDefs: [
              
                    {
                        targets: 7,
                        render: function(data, type, row, meta) {
                            const rowId = data.id;
                            var viewUrl = "{{ route('user.orders.detail', ':id') }}";

                                return      '<div class="dropdown">'+
                                    '<button class="btn btn-soft-secondary btn-sm dropdown " type="button" data-bs-toggle="dropdown" aria-expanded="true"> <i class="ri-more-fill align-middle"></i></button>'+
                                    '<ul class="dropdown-menu dropdown-menu-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-24px, 29px);" data-popper-placement="bottom-end">'+
                                    '<li><a class="dropdown-item" href="'+viewUrl.replace(':id', rowId)+'"  data-id=""><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>'+

                                    '</ul>'+
                                    '</div>';

                        }
                    }
                ]
            });

        });
    </script>

@endsection

