@extends('layouts.master')
@section('title') Item Put away List @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Item Put away List @endslot
    @endcomponent


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Item Put away List</h4>

                    </div>
                    <div class="col-auto justify-content-sm-end">
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal" style="
    visibility: hidden;
"><i class="ri-add-line align-bottom me-1"></i> Add Load Type</button>
                    </div>

                </div>

                <div class="card-body border border-dashed border-end-0 border-start-0">

                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-7 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder=" Search" name="s_name">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <select class="form-control" name="s_status">
                                        <option value="">Status</option>
                                        <option value="" selected="">All</option>
                                        <option value="1">Active</option>
                                        <option value="2">In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" id="filter"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filter
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
                            <th class="sort" data-sort="id">Container Number</th>
                            <th class="sort" data-sort="id">Staged Location </th>
                            <th class="sort" data-sort="id">Order Ref </th>
                            <th class="sort" data-sort="id">Status</th>
                            <th class="sort" data-sort="id">Action</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>

@endsection



@section('script')
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
                    url: "put-away-list",

                    data: function (d) {
                        d.s_title = $('input[name=s_title]').val(),
                            d.s_status = $('select[name=s_status]').val()

                    },

                },

                columns: [
                    { data:'order_check_in.container_no'},
                    { data: 'p_staged_location'},
                    { data: 'order.order_id' },
                    { data: null },
                    { data: null, orderable: false },
                ],
                columnDefs: [
                    {
                        targets: 3,
                        render: function(data, type, row, meta) {
                         return '<span class="badge '+row.status.class_name +' '+data.status.text_class + ' text-uppercase">'+row.status.status_title+'</span>';
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, row, meta) {
                            var url = "{{ route('admin.put-away.create', ':id') }}";
                            return '@canany('admin-putaway-view')<a href="'+url.replace(':id', data.id)+'"><button type="button" class="btn btn-secondary waves-effect waves-light">Start Put Away Now</button></a>@endcanany';
                        }
                    },
                ]
            });

        });
    </script>
    <script src="{{ URL::asset('build/js/custom-js/roles/roles.js') }}"></script>

@endsection

