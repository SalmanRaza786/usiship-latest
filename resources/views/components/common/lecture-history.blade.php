
<div class="row">

    <div class="col-xxl-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0  me-2"> {{__('translation.Lecture_History')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="collapse show" id="needsIdentified">
                            @if($data['lectures']->count() > 0)
                                @foreach($data['lectures'] as $key=>$lect)
                                    @php
                                        $lectStatus='Pending';
                                        $lectStatusClass='warning';
                                        $lectStatusDate='';

                                        if(count($lect->lectureAttempt) > 0 ){
                                            if($lect->latestAttempt->status==1){
                                                $lectStatus='Cleared';
                                                $lectStatusClass='success';
                                                $lectStatusDate=date('d M,Y',strtotime($lect->latestAttempt->updated_at));
                                            }
                                             if($lect->latestAttempt->status==0){
                                                $lectStatus='InProgress';
                                                 $lectStatusClass='info';
                                                  $lectStatusDate=date('d M,Y',strtotime($lect->latestAttempt->created_at));
                                            }
                                        }
                                    @endphp
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <a class="d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#lecture_{{$lect->id}}" role="button" aria-expanded="false" aria-controls="needsIdentified1">
                                                <div class="flex-shrink-0 avatar-sm">
                                                    <div class="avatar-title  fs-1 rounded-circle">
                                                        <i class=" ri-emotion-happy-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-1">{{$lect->lecture->translations->where('lang',\Illuminate\Support\Facades\App::currentLocale())->pluck('title')->first()}}</h6>
                                                    <p class="text-muted mb-0"> <span class="badge rounded-pill bg-{{$lectStatusClass}}">{{$lectStatus}}</span> - {{$lectStatusDate}}</p>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-1"> {{__('translation.Slides')}}</h6>

                                                    <p class="text-muted mb-0">   {{(isset($lect->lectureAttempt) AND count($lect->lectureAttempt) > 0 )? count($lect->latestAttempt->attemptSlide->where('is_solved',1)):0}} / {{$lect->slides->count()}}</p>
                                                </div><div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-1">{{__('translation.Attempts')}}</h6>
                                                    <p class="text-muted mb-0"> {{ count($lect->lectureAttempt) > 0 ? 'In' . ' ' .count($lect->lectureAttempt) . ' ' .'Attempts' :'-'}} </p>
                                                </div>
                                                @if(Auth::getDefaultDriver()=='web')
                                                <div class="flex-grow-1 ms-3">
                                                        <h6 class="fs-14 mb-1"> {{__('translation.Syncronized')}}</h6>
                                                        <p class="text-muted mb-0"><span class="badge rounded-pill bg-danger"> {{(count($lect->lectureAttempt) AND   $lect->lectureAttempt[0]->is_sync==1)? 'Yes' : 'No'}} </span></p>
                                                    </div>
                                                @endif

                                                <div class="flex-shrink-0 ms-3">
                                                    <h6 class="fs-14 mb-1"> {{__('translation.Pass')}}</h6>
                                                    <p class="text-muted text-end mb-0">{{(count($lect->lectureAttempt)  AND $lect->latestAttempt->res_percentage!=null)?$lect->latestAttempt->res_percentage.'%':'-'}}</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="border-top border-top-dashed collapse" id="lecture_{{$lect->id}}">
                                            <div class="card-body bg-body">


                                                <div class="row mt-4">
                                                    <div class="col-lg-12">
                                                        <div>

                                                            @if(count($lect->lectureAttempt) > 0)
                                                                @foreach($lect->lectureAttempt as $key=>$lectAttempt)
                                                                    <h5 class="mb-4">  {{__('translation.Attempts')}} {{$key+1}}</h5>
                                                                    <div class="timeline-2">
                                                                    <div class="timeline-year">
                                                                        <p>{{date('d M y',strtotime($lectAttempt->created_at))}}</p>
                                                                    </div>
                                                                    </div>
                                                                    @if($lectAttempt->status==3)
                                                                        <div class="timeline-2">
                                                                            <div class="timeline-launch">
                                                                                <div class="timeline-box">
                                                                                    <div class="timeline-text">
                                                                                        <h5>{{__('translation.Language_Switched')}}</h5>

                                                                                        <p class="text-muted text-capitalize mb-0">Student has changed language from {{\App\Http\Helpers\Helper::getLangTitle($lectAttempt->lang)}}  to {{\App\Http\Helpers\Helper::getLangTitle($lect->lectureAttempt[$key+1]->lang)}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="timeline-2">

                                                                            <div class="timeline-continue">
                                                                                @if(count($lectAttempt->attemptSlide->where('is_solved',1)) > 0)
                                                                                    @foreach($lectAttempt->attemptSlide->where('is_solved',1) as $slide)
                                                                                        <div class="row timeline-right">
                                                                                            <div class="col-12">
                                                                                                <p class="timeline-date mb-4">{{$slide->slide->slideTitle->content}} :  {{date('H:i:a',strtotime($slide->slide->updated_at))}} ({{$slide->slideCounter}})

                                                                                                </p>
                                                                                            </div>

                                                                                        </div>
                                                                                    @endforeach
                                                                                @endif

                                                                            </div>


                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <div class="alert alert-danger"> {{__('translation.Lecture_not_attempt')}}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-danger"> {{__('translation.Lectures_not_configured')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
