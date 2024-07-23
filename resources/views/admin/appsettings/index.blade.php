@extends('layouts.master')
@section('title')
    @lang('translation.app_settings')
@endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl')
            {{url('/')}}
        @endslot
        @slot('li_1')
            @lang('translation.settings')
        @endslot
        @slot('title')
            @lang('translation.app_settings')
        @endslot
    @endcomponent

    @php
        $res= $data['appSetting']->where('key','app_title')->first()

    @endphp
    @include('components.common-error')
    <div class="row">
        <div class="col-xxl-12 mt-5">
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.app-settings.update')}}"
                  enctype="multipart/form-data" autocomplete="off" id="AppSettingform">
                @csrf
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#app_settings" role="tab"
                                   aria-selected="true">
                                    <i class="fas fa-home"></i> @lang('translation.app_settings')
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content">
                            @isset($data['appSetting'])

                                <div class="tab-pane active show" id="app_settings" role="tabpanel">


                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label for="app_title"
                                                   class="form-label">@lang('translation.app_title')</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control"
                                                   value="{{($data['appSetting']->count() > 0)? $data['appSetting']->where('key','app_title')->pluck('value')->first():""}}"
                                                   id="app_title" name="app_title"
                                                   placeholder="@lang('translation.app_title')">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label for="nameInput"
                                                   class="form-label mt-5">@lang('translation.app_logo')</label>
                                        </div>
                                        <div class="col-lg-9">

                                            <div class="profile-user position-relative d-inline-block mx-auto  mb-2">
                                                @if($data['appSetting']->count() > 0)
                                                    <img
                                                        src="{{ asset('storage/appsettings/' .$data['appSetting']->where('key','app_logo')->pluck('value')->first()) }}"
                                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                                        alt="user-profile-image">
                                                @endif
                                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                    <input id="profile-img-file-input" name="app_logo" type="file"
                                                           class="profile-img-file-input">
                                                    <label for="profile-img-file-input"
                                                           class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="nameInput"
                                                       class="form-label mt-5">@lang('translation.student_background_image')</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <div
                                                    class="profile-user position-relative d-inline-block mx-auto  mb-2">
                                                    @if($data['appSetting']->count() > 0)
                                                        <img
                                                            src="{{ asset('storage/appsettings/' . $data['appSetting']->where('key','student_bg')->pluck('value')->first()) }}"
                                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image-3"
                                                            alt="user-profile-image-3">
                                                    @endif
                                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                        <input id="profile-img-file-input-3" name="student_bg"
                                                               type="file"
                                                               class="profile-img-file-input profile-img-file-input-3">
                                                        <label for="profile-img-file-input-3"
                                                               class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <!--end row-->
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-lg-3 align-self-center">
                                            <label for="nameInput"
                                                   class="form-label m-0">@lang('translation.admin_background_image')</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="profile-user position-relative d-inline-block mx-auto  mb-2">
                                                @if($data['appSetting']->count() > 0)
                                                    <img
                                                        src="{{ asset('storage/appsettings/' . $data['appSetting']->where('key','admin_bg')->pluck('value')->first()) }}"
                                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image user-profile-image-2"
                                                        alt="user-profile-image">
                                                @endif
                                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                    <input id="profile-img-file-input-2" name="admin_bg" type="file"
                                                           class="profile-img-file-input profile-img-file-input-2">
                                                    <label for="profile-img-file-input-2"
                                                           class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            @endisset
                        </div>
                    </div>

                </div>
                <div class="text-end">
                    {{--            @canany('admin-settings-edit')--}}
                    <button type="submit" class="btn btn-primary btn-submit">Save Changes</button>
                    {{--            @endcanany--}}
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')

    <script src="{{ URL::asset('build/js/custom-js/appsettings/appsettings.js') }}"></script>



@endsection

