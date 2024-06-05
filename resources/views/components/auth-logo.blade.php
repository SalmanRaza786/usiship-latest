



    @if($appInfo->count() > 0)
        <img src="{{ URL::asset('storage/appsettings/'.$appInfo->where('key','app_logo')->pluck('value')->first())}}" alt="" height="50">
    @else
        <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="75">
    @endif


