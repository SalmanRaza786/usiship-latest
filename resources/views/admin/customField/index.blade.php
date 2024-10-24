@extends('layouts.master')
@section('title') Load Type @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Custom Fields @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Custom Fields</h4>

                    </div>
                    @canany('admin-user-create')
                    <div class="col-auto justify-content-sm-end">
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Custom Fields</button>
                    </div>
                    @endcanany

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
                                <th class="sort" data-sort="id">Label</th>
                                <th class="sort" data-sort="customer_name">Input Type</th>
                                <th class="sort" data-sort="customer_name">Place Holder</th>
                                <th class="sort" data-sort="product_name">Description</th>
                                <th class="sort" data-sort="product_name">Require Type</th>
                                <th class="sort" data-sort="product_name">Order By</th>
{{--                                <th class="sort" data-sort="product_name">@lang('translation.status')</th>--}}
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

    @include('admin.customField.customField-modals')
    @include('admin.components.comon-modals.common-modal')


@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/customField/customField.js') }}"></script>
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
                    url: "custom-field-list",
                    data: function (d) {
                        d.s_name = $('input[name=s_name]').val(),
                            d.status = $('select[name=s_status]').val()

                    },

                },

                columns: [
                    { data: 'label' },
                    { data: 'input_type' },
                    { data: 'place_holder'},
                    { data: 'description' },
                    { data: 'require_type' },
                    { data: 'order_by' },
                    { data: null, orderable: false },
                ],
                columnDefs: [
                    {
                        targets: 6,
                        render: function(data, type, row, meta) {
                            const rowId = data.id;

                            return `@canany('admin-custom_fields-edit')<a href="{{ route('admin.customField.edit', '') }}/${rowId}" class="btn-edit" data="${rowId}" data-bs-toggle="modal" data-bs-target="#showModal"><i class="ri-pencil-fill text-primary fs-4"></i></a>@endcanany
                                    @canany('admin-custom_fields-delete')<a href="{{ route('admin.customField.delete','') }}" class="btn-delete"  data="${rowId}"  data-bs-toggle="modal" data-bs-target="#deleteRecordModal"><i class="ri-delete-bin-fill text-danger fs-4"></i></a>@endcanany`;


                        }
                    }
                ]
            });

        });
    </script>

@endsection
