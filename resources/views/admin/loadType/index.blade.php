@extends('layouts.master')
@section('title') Load Type @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Load Type @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Load Type</h4>

                    </div>
                    @canany('admin-user-create')
                    <div class="col-auto justify-content-sm-end">
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal"><i class="ri-add-line align-bottom me-1"></i> Add Load Type</button>
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
                                <th class="sort" data-sort="id">WareHouse</th>
                                <th class="sort" data-sort="id">Direction</th>
                                <th class="sort" data-sort="customer_name">Operation</th>
                                <th class="sort" data-sort="customer_name">Equipment Type</th>
                                <th class="sort" data-sort="product_name">Transportation Mode</th>
                                <th class="sort" data-sort="product_name">Duration</th>
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

    @include('admin.loadType.load-modals')
    @include('admin.components.comon-modals.common-modal')


@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/loadType/loadType.js') }}"></script>
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
                    url: "admin-load-type-list",
                    data: function (d) {
                        d.s_name = $('input[name=s_name]').val(),
                            d.s_status = $('select[name=s_status]').val()
                    }
                },

                columns: [
                    { data: 'wh' },
                    { data: 'direction' },
                    { data: 'operation' },
                    { data: 'eqType'},
                    { data: 'transMode' },
                    { data: 'duration' },
                    { data: 'status' },
                    { data: null, orderable: false },
                ],
                columnDefs: [

                    {
                        targets: 6,
                        render: function(data, type, row, meta) {

                            if (data == 1) {
                                return '<span class="badge bg-success">Active</span>';
                            } else  {
                                return '<span class="badge bg-danger">InActive</span>';
                            }
                        }
                    },
                    {
                        targets: 7,
                        render: function(data, type, row, meta) {
                            const rowId = data.id;

                            return `@canany('admin-user-edit')<a href="{{ route('admin.load.edit', '') }}/${rowId}" class="btn-edit" data="${rowId}" data-bs-toggle="modal" data-bs-target="#loadTypeModal"><i class="ri-pencil-fill text-primary fs-4"></i></a>@endcanany
                                    @canany('admin-user-delete')<a href="#" class="btn-delete"  data="${rowId}"  data-bs-toggle="modal" data-bs-target="#deleteRecordModal"><i class="ri-delete-bin-fill text-danger fs-4"></i></a>@endcanany`;


                        }
                    }
                ]
            });

        });
    </script>

@endsection
