@extends('layouts.master')
@section('title') Order Status List @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Order Status List @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Order Status List @endslot
    @endcomponent

    @include('components.common-error')



    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Order Status List</h4>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table" id="roleTable">
                        <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th class="sort" data-sort="id">SR#</th>
                            <th class="sort" data-sort="id">Title</th>
                            <th class="sort" data-sort="date">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                      @isset($data['status'])
                          @foreach($data['status'] as $key=>$row)
                              <tr>
                                  <td>{{$key + 1}}</td>
                                  <td>{{$row->status_title}}</td>
                                  <td>
                                      @canany('admin-notification-template-create')
                                          <a href="{{route('admin.notification.create',['id'=>encrypt($row->id)])}}"> <button class="btn btn-primary">Add Template</button></a>
                                      @endcan
                                  </td>
                              </tr>
                          @endforeach
                      @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
