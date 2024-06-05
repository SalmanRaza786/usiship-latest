@if($appInfo->count() > 0)
    <style>
        .background-image {
            background-image: url('{{ asset('storage/appsettings/' .$appInfo->where('key','student_bg')->pluck('value')->first() ) }}');
        }
    </style>
@else
    <style>
        .background-image {
            background-image: url('{{URL::asset('build/images/std_auth.jpg')}}');
        }
    </style>
@endif
