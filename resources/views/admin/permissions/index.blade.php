@extends('layouts.master')
@section('title') @lang('translation.permissions') @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') {{__('translation.settings')}} @endslot
        @slot('title') {{__('Role Permissions')}} @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0"><b>{{!empty($data['role'])?$data['role']->name:''}}</b> {{__('Permissions')}}</h4>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.permissions.assign')}}" method="post" id="PermForm">
                        @csrf
                        <div class="row g-3 mt-1 mb-3">
                            <div class="col-xxl-2">
                            </div>

                            <div class="col-xxl-2">
                                <div class="ms-1" dir="ltr">
                                    <label class="form-check-label" for="customSwitchsizemd">View</label>
                                </div>
                            </div>
                            <div class="col-xxl-2">
                                <div class="ms-1" dir="ltr">
                                    <label class="form-check-label" for="customSwitchsizemd">Add</label>
                                </div>
                            </div>
                            <div class="col-xxl-2">
                                <div class="ms-1" dir="ltr">
                                    <label class="form-check-label" for="customSwitchsizemd">Edit</label>
                                </div>
                            </div>
                            <div class="col-xxl-2">
                                <div class="ms-1" dir="ltr">
                                    <label class="form-check-label" for="customSwitchsizemd">Delete</label>
                                </div>
                            </div>
{{--                            <div class="col-xxl-2">--}}
{{--                                <div class="ms-1" dir="ltr">--}}
{{--                                    <label class="form-check-label" for="customSwitchsizemd">Translate</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                        </div>
                        <input type="hidden" name="role_id" value="{{($data['role'])?$data['role']->id:''}}">


                        @isset($data['permissions'])

                     @php  $lastElement = array_key_last($data['permissions']->toArray()); @endphp

                      @foreach ($data['permissions'] as $key => $module)

                       <div class="row g-3" >
                           @if ($module->title === 'Miscellaneous') <hr>   @endif


                          <div class="col-xxl-2" >
                               <div >
                                 <label for="firstName" class="form-label" >{{$module->title}}</label >
                               </div >
                           </div >
                           @foreach ($module['permissions'] as $permissions)


                          @if ($module->id == $permissions->module_id)
                            <div class="col-xxl-2" >
                               <div class="form-check form-switch form-switch-md mb-3" dir = "ltr" >
                                   @if ($module->title === 'Miscellaneous')
                               <label class="form-check-label" >
                                   @switch($permissions->name)
                                       @case('admin-settings-edit')
                                           {{__('Settings')}}
                                           @break

                                       @case('admin-email-sms-edit')
                                           {{__('Email/SMS')}}
                                           @break


                                       @case('admin-dashboard-view')
                                           {{__('Admin/Dashboard')}}
                                           @break
                                       @case('practice-config')
                                           {{__('Practice Config')}}
                                           @break

                                       @case('admin-otp')
                                           {{__('OTP')}}
                                           @break

                                       @case('admin-change-password')
                                           {{__('Change Password')}}
                                           @break

                                       @case('admin-change-theory-practice-language')
                                           {{__('Change Practice Language')}}
                                           @break

                                       @case('admin-slides-element')
                                           {{__('Slides/Element')}}
                                           @break
                                       @case('admin-sync-lectures')
                                           {{__('Sync lectures')}}
                                           @break

                                       @default
                                           {{$permissions->name}}
                                   @endswitch
                               </label>

                                   @endif
                                  <input type = "checkbox" class="form-check-input"  name = "permissions[]" value = "{{$permissions->id}}"  @if(count($data['roles']->where('id', $permissions->id)))
                                      checked
                                      @endif>

                               </div></div >


                           @endif
                           @endforeach
                       </div >

                        @endforeach
                        @endisset


                        <div class="row g-3 mt-3">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{route('admin.roles.index')}}" class="btn btn-light">Close</a>
                                <button type="submit" class="btn btn-primary btn-submit" fdprocessedid="ocjl3f">{{__('Save Changes')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/permissions/permissions.js') }}"></script>
@endsection
