


<div class="dropdown ms-1 topbar-head-dropdown header-item"  style="position:fixed;top:0%;right:2%;z-index: 999;">
    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

        <img src="{{ URL::asset('build/images/flags/'.\Illuminate\Support\Facades\App::currentLocale().'.svg') }}" class="rounded" alt="Header Language" height="20">
    </button>


        <div class="dropdown-menu dropdown-menu-end">

            @if(count($langData) > 0 )
                @isset($langData)
                    @foreach($langData as $lang)

                        <a href="{{ route('student.direction',['locale'=>$lang->short_code, 'langSlug'=>$lang->short_code])}}" class="dropdown-item notify-item language py-2" data-lang="en" title="{{$lang->title}}">
                            <img src="{{ URL::asset('build/images/flags/'.$lang->short_code.'.svg') }}" alt="flag" class="me-2 rounded" height="20">
                            <span class="align-middle">{{$lang->title}}</span>
                        </a>
                    @endforeach
                @endisset
            @else
                <a href="{{ url('index/en') }}" class="dropdown-item notify-item language" data-lang="en" title="English">
                    <img src="{{URL::asset('build/images/flags/us.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                    <span class="align-middle">English</span>
                </a>
            @endif

        </div>

</div>
