@extends('layouts.master')
@section('title') Reports @endsection
@section('css')
    @include('layouts.export-table-css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Reports @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Inbound Report @endslot
    @endcomponent
    @include('components.common-error')
    <div class="row">


        <div class="col-xl-12">

            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Inbound Report</h4>
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

{{--                                        @isset($data['status'])--}}
{{--                                            @foreach($data['status'] as $status)--}}
{{--                                                <option value="{{$status->id}}">{{$status->status_title}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        @endisset--}}
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
                <div class="card-body pt-2">
                    <table class="table" id="roleTable">
                        <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th class="sort" data-sort="id">Sr No.</th>
                            <th class="sort" data-sort="id">Order#</th>
                            <th class="sort" data-sort="id">Order Type</th>
                            <th class="sort" data-sort="customer_name">Customer</th>
                            <th class="sort" data-sort="customer_name">Contact</th>
                            <th class="sort" data-sort="id">Item Name</th>
                            <th class="sort" data-sort="id">Sku</th>
                            <th class="sort" data-sort="id">Pallet#</th>
                            <th class="sort" data-sort="id">Quantity</th>
                            <th class="sort" data-sort="id">Location</th>
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
    @include('layouts.export-table-scripts')
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
                ordering: true,
                bLengthChange: true,
                order: [[ 0, "desc" ]],
                lengthMenu:[[10,50,100,-1],[10,50,100,"All"]],
                ajax: {
                    url: "inbound-report-list",
                    data: function (d) {
                        d.s_name = $('input[name=s_name]').val(),
                            d.status = $('select[name=s_status]').val()
                    }
                },
                columns: [
                    { data: null },
                    { data: 'order.order_id' },
                    { data: 'order.order_type' },
                    { data: 'order.company.title' },
                    { data: 'order.customer.name' },
                    { data: 'inventory.item_name' },
                    { data: 'inventory.sku' },
                    { data: 'pallet_number' },
                    { data: 'qty' },
                    { data: 'location.loc_title' },
                ],
                columnDefs: [
                    {
                        targets: 0, // Serial number column
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Row index + 1
                        },
                        orderable: false, // Disable ordering for serial number
                    },
                    {
                        targets: 2,
                        render: function(data, type, row, meta) {
                            if (data === '1') {
                                return '<span class="badge bg-success">Inbound</span>';
                            } else  {
                                return '<span class="badge bg-danger">Outbound</span>';
                            }
                        }
                    },

                ],
                dom: 'Bfrtip', // Add this to enable the Buttons extension
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        titleAttr: 'Export as Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'Export to CSV',
                        titleAttr: 'Export as CSV',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export to PDF',
                        titleAttr: 'Export as PDF',
                        className: 'btn btn-danger',
                        orientation: 'landscape', // Set orientation if necessary
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: 'Print Table',
                        titleAttr: 'Print Table',
                        className: 'btn btn-info'
                    }
                ]
            });

        });
    </script>

@endsection

