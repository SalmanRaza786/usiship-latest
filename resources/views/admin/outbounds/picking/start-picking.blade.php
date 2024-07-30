@extends('layouts.master')
@section('title') Item Picking Detail @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Item Picking - ORD#948923 @endslot
    @endcomponent
    @include('components.common-error')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="col">
                            <h4 class="card-title mb-0">Item Picking Detail</h4>

                        </div>
                        <div class="col-auto justify-content-sm-end">

                            <button type="button" class="btn btn-warning add-btn me-2" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal" style="
"><i class="ri-eye-line align-bottom me-1"></i> Report Missing</button><button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal" style="
"><i class="ri-add-line align-bottom me-1"></i> Start Picking Now</button>
                        </div>

                    </div>

                    <div class="card-body">


                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Container #</label>
                                        <input type="text" class="form-control" id="basiInput" value="2311212" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="labelInput" value="Ali" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Picking Start Date/Time</label>
                                        <input type="text" class="form-control" id="placeholderInput" value="23-04-2024 11:30 PM" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="valueInput" class="form-label">Load Type</label>
                                        <input type="text" class="form-control" id="valueInput" value="LTL" disabled="">
                                    </div>
                                </div>
                                <!--end col-->






























                            </div>
                            <!--end row-->
                        </div>


                    </div>


                </div>
            </div>
            <!--end col-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="live-preview">
                       <table class="invoice-table table table-borderless table-nowrap mb-0">
                                    <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">
                                            Product SKU
                                        </th>
                                        <th scope="col" style="">
                                            <div class="d-flex currency-select input-light align-items-center">Quantity
                                            </div>
                                        </th>
                                        <th scope="col" style="">Pallet Number</th>
                                        <th scope="col" style="">Pick From</th>
                                        <th scope="col" style="">Missing Qty
                                        </th>
                                        <th scope="col" class="text-end" style="width: 150px;">Picked Location</th>
                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr id="2" class="product">
                                        <td class="d-none" colspan="5">
                                            <p>Add New Form</p>
                                        </td>
                                        <th scope="row" class="product-id align-middle">1</th>
                                        <th scope="row" class="product-id align-middle">23231</th>
                                        <th scope="row" class="product-id align-middle">20</th>
                                        <th scope="row" class="product-id align-middle">6345466423</th>
                                        <th scope="row" class="product-id align-middle">AA-111-AA</th>
                                        <td><input class="form-control bg-light border-0 product-price" type="number" id="productRate-3" step="0.01" placeholder="Qty"></td>
                                        <td class="text-end">
                                            <select name="" id="" class="form-select">
                                                <option value="">Choose One</option>
                                            </select>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                    </tr>

                                    </tbody>

                                </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
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
                { data: 'client.name' },
                { data: 'order_date' },
                { data: 'ship_method' },
                { data: 'order_reference' },
                { data: 'ship_date' },
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


