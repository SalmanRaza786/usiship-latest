@extends('layouts.master')
@section('title') @lang('translation.roles') @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') {{__('translation.settings')}} @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') @lang('translation.user-role-list') @endslot
    @endcomponent
    @include('components.common-error')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">{{__('translation.user-role-list')}}</h4>
                    </div>
                    @canany('admin-role-create')
                    <div class="col-auto justify-content-sm-end">
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> @lang('translation.btn_add_role')</button>
                    </div>
                        @endcanany
                </div><!-- end card header -->
                <div class="card-body border border-dashed border-end-0 border-start-0">

                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-7 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder=" {{__('translation.search')}}" name="s_title">
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
                                <th class="sort" data-sort="id">@lang('translation.title')</th>
                                <th class="sort" data-sort="customer_name">@lang('translation.assign_to')</th>
                                <th class="sort" data-sort="product_name">@lang('translation.status')</th>
                                <th class="sort" data-sort="date">@lang('translation.action')</th>
                            </tr>
                            </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @include('admin.roles.roles-modals')
    @include('admin.components.comon-modals.common-modal')

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
                    url: "get-roles",

                    data: function (d) {
                            d.s_title = $('input[name=s_title]').val(),
                            d.s_status = $('select[name=s_status]').val()

                    },
                    // dataSrc: function(response) {
                    //     console.log(response.data[0].users);
                    // }
                },

                columns: [
                    { data: 'name' },
                    { data: null},
                    { data: 'status' },
                    { data: null, orderable: false },
                ],

                columnDefs: [
                    {
                        "targets": 1,
                        "render": function(data, type, row, meta) {
                            var users = row.users;
                            var imageHtml = '';
                            imageHtml += '<div class="avatar-group flex-nowrap">';
                            users.forEach(function(user) {
                                imageHtml += '<a href="javascript: void(0);" class="avatar-group-item" data-img="assets/images/users/avatar-2.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="'+user.name+'"> ' +
                                    '<img src="{{asset('build/images/users/user-dummy-img.jpg')}}" class="rounded-circle avatar-xxs" alt=""> ';
                            });
                            imageHtml += '</a></div>';
                            return imageHtml;
                        }
                    },

                    {
                        targets: 2,
                        render: function(data, type, row, meta) {

                            if (data == 1) {
                                return '<span class="badge badge-soft-success text-uppercase">Active</span>';
                            } else  {
                                return '<span class="badge badge-soft-danger text-uppercase">InActive</span>';
                            }
                        }
                    },
                    {
                        targets: 3,
                        render: function(data, type, row, meta) {
                            const rowId = data.id;
                            var url = "{{ route('admin.roles.permissions', ':role_id') }}";

                            var btnPerm = ' @canany('admin-permission-view')<a  href="'+url.replace(':role_id', data.id)+'" ><i class="ri-user-settings-line fs-4"></i></a>@endcanany';
                            var btnEdit = ' @canany('admin-role-edit')<a href="#" class="btn-edit" data="'+rowId+'" data-bs-toggle="modal" data-bs-target="#showModal"><i class="ri-pencil-fill text-primary fs-4"></i></a>@endcanany';
                            var btnDelete = ' @canany('admin-role-delete')<a href="" class="btn-delete"  data="'+rowId+'"  data-bs-toggle="modal" data-bs-target="#deleteRecordModal"><i class="ri-delete-bin-fill text-danger fs-4"></i></a>@endcanany';
                            return  btnPerm+ ' ' + btnDelete + ' '+  btnEdit;
                        }
                    }
                ]
            });

        });
    </script>
 <script src="{{ URL::asset('build/js/custom-js/roles/roles.js') }}"></script>
@endsection
