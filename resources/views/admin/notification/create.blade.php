@extends('layouts.master')
@section('title') Create Template @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Create Template @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Create Template @endslot
    @endcomponent
    @include('components.common-error')

    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">CREATE TEMPLATE</h4>
                </div>
                <div class="card-body">

                        <form id="my-form" method="POST" action="{{route('admin.notification.store')}}">
                            @csrf

                           <div class="form-group mb-2">
                                    <label for="">Template Title</label>
                                    <input type="text" class="form-control" readonly   value="{{isset($data['statusTitle'])?$data['statusTitle']:''}}">
                                    <input type="hidden" class="form-control" name="status_id"   value="{{isset($data['id'])?$data['id']:''}}">
                            </div>
                            <div class="form-group mb-2">
                                    <label for="">Email Template</label>
                                    <div id="snow-editor"  style="height: 300px">{!!isset($data['template'])?$data['template']->mail_content:''!!}</div>
                                    <input type="hidden" name="editorContent" id="editor-content">
                                </div>
                            <div class="form-group mb-2">
                            <label for="">SMS Template</label>
                            <textarea name="sms_content" id="" cols="10" rows="3" class="form-control">{{isset($data['template'])?$data['template']->sms_content:''}}</textarea>
                            </div>
                            <div class="form-group mb-2">
                                    <label for="">Notify Template</label>
                                    <textarea name="notify_content" id="" cols="10" rows="3" class="form-control">{{isset($data['template'])?$data['template']->notify_content:''}}</textarea>
                                </div>

                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{route('admin.notification.index')}}" class="btn btn-ghost-primary"> Back </a>
                                <button type="submit" class="btn btn-primary btn-submit btn-add" id="add-btn">Save Changes</button>

                            </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/custom-js/notification/notificationTemplate.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quill = new Quill('#snow-editor', {
            theme: 'snow'
        });

        var form = document.getElementById('my-form');
        form.onsubmit = function () {
            // Get the editor content
            var editorContent = quill.root.innerHTML;
            // Set the editor content to the hidden input
            document.getElementById('editor-content').value = editorContent;
        };
    });
</script>

@endsection

