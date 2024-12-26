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
{{--                            <div class="col-xxl-3 col-sm-4">--}}
{{--                                <div>--}}
{{--                                    <select class="form-control"  name="s_status">--}}
{{--                                        <option value="">Status</option>--}}
{{--                                        <option value="" selected>{{__('translation.all')}}</option>--}}
{{--                                        @isset($data['status'])--}}
{{--                                            @foreach($data['status'] as $status)--}}
{{--                                                <option value="{{$status->id}}">{{$status->status_title}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        @endisset--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <select class="form-select" data-choices id="customersDropdown" required data-trigger  name="s_customers">
                                        <option value="">Customers</option>
                                        <option value="" selected>{{__('translation.all')}}</option>
                                        @isset($data['customers'])
                                            @foreach($data['customers']['data'] as $customer)
                                                <option value="{{$customer->id}}">{{$customer->title}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>    <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <select class="form-select" data-choices id="skuDropdown" required data-trigger  name="s_sku">
                                        <option value="">Sku</option>
                                        <option value="" selected>{{__('translation.all')}}</option>
                                        @isset($data['inventory'])
                                            @foreach($data['inventory'] as $inventory)
                                                <option value="{{$inventory->id}}">{{$inventory->sku}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <select class="location-select form-control loc-id" name="s_location" required></select>
{{--                                    <select class="form-select" data-choices id="wmsLocationsDropdown" required data-trigger  name="s_location">--}}
{{--                                        <option value="">Locations</option>--}}
{{--                                        <option value="" selected>{{__('translation.all')}}</option>--}}
{{--                                        @isset($data['locations'])--}}
{{--                                            @foreach($data['locations'] as $location)--}}
{{--                                                <option value="{{$location->id}}">{{$location->loc_title}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        @endisset--}}
{{--                                    </select>--}}
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
                            <th class="sort" data-sort="id">Images</th>
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
            initializeSelect2($('.location-select'));
            initLoadTypeDropdown();
            function initLoadTypeDropdown() {
                // const element = document.querySelector('#wmsLocationsDropdown');
                const element2 = document.querySelector('#skuDropdown');
                const element3 = document.querySelector('#customersDropdown');
                // if (element && element.choicesInstance) {
                //     element.choicesInstance.destroy();
                // }
                if (element2 && element2.choicesInstance) {
                    element2.choicesInstance.destroy();
                }
                if (element3 && element3.choicesInstance) {
                    element3.choicesInstance.destroy();
                }
                // new Choices('#wmsLocationsDropdown', {
                //     removeItemButton: true,
                // });
                new Choices('#skuDropdown', {
                    removeItemButton: true,
                }) ;
                new Choices('#customersDropdown', {
                    removeItemButton: true,
                });
            }


            function initializeSelect2($element) {
                $element.each(function () {
                    var $select = $(this); // Current select element

                    // Initialize Select2 with AJAX search
                    $select.select2({
                        placeholder: 'Select a location',
                        allowClear: true,
                        ajax: {
                            url: route('admin.locations.search'), // Adjust the route as needed
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: params.term // Search term sent to the server
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: $.map(data.data, function (item) {
                                        return {
                                            id: item.id,
                                            text: item.loc_title
                                        }
                                    })
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 2
                    });
                });
            }

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
                            d.s_status = $('select[name=s_status]').val(),
                            d.s_sku = $('select[name=s_sku]').val(),
                            d.s_customers = $('select[name=s_customers]').val(),
                            d.s_location = $('select[name=s_location]').val()
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
                    { data: null },
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
                    {
                        targets: 10,
                        render: function(data, type, row, meta) {
                            if (row.put_away_media && Array.isArray(row.put_away_media)) {
                                const container = $('<div>').addClass();

                                row.put_away_media.forEach(image => {
                                    if (image.field_name === 'putawayImages') {
                                        const a = $('<a>')
                                            .addClass('image-popup')
                                            .attr('href', '/storage/uploads/' + image.file_name)
                                            .attr('data-bs-toggle', 'tooltip')
                                            .attr('data-bs-placement', 'top')
                                            .attr('aria-label', 'Damages')
                                            .attr('data-bs-original-title', 'Damages');

                                        const img = $('<img>')
                                            .attr('src', '/storage/uploads/' + image.file_thumbnail)
                                            .attr('alt', '')
                                            .addClass('gallery-img img-fluid mx-auto rounded avatar-md');

                                        a.append(img);
                                        container.append(a);
                                    }
                                });

                                return container.prop('outerHTML'); // Return the constructed HTML as a string
                            } else {
                                return '-';
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

