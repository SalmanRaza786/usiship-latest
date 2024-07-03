<div class="d-flex align-items-start gap-3 mt-4">
    <div>
        <h5 class="mb-1">Setup Warehouse Working Hours</h5>
        <p class="text-muted mb-4">Please fill all information below</p>
    </div>

</div>
<div class="row g-4">

    <div class="row">
    <div class="col-md-6">
        @isset($data['wh'])
        @php
       $splitQryResult=\App\Http\Helpers\Helper::getQuerySplit($data,'monday');

         $mondayQuery=$splitQryResult['dayFirstRecord'];
         $mondayRecordAfterFirst =$splitQryResult['daySliceRecord'];
        @endphp
        @endisset


        <div class="input-group">
            <input type="hidden" name="mon_hidden_id" value="0">
            <label for="experience-Input" class="form-label fs-5">Monday <span class="text-danger"></span></label>
            <div class="input-group">
                <div class="col-4 input-group-text bg-gray">


                    <input class="form-check-input mt-0" type="radio" value="1" aria-label="Checkbox for following text input" name="mon_wh_setup" {{(isset($data['wh']) AND $mondayQuery->pluck('open_type')->first()==1)? "checked":''}}>
                    <span class="ms-2"> Setup Working Hours</span>
                </div>

                <div class="col-4 input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="2" aria-label="Checkbox for following text input" name="mon_wh_setup" {{(isset($data['wh']) AND $mondayQuery->pluck('open_type')->first()==2)? "checked":''}}>
                    <span class="ms-2">Open 24 Hours  </span>
                </div><div class="col-4 input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="3" aria-label="Checkbox for following text input" name="mon_wh_setup" {{(isset($data['wh']) AND $mondayQuery->pluck('open_type')->first() !=1 AND $mondayQuery->pluck('open_type')->first() !=2)? "checked":''}}>
                    <span class="ms-2">Closed</span>
                </div>
            </div>
        </div>


            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Working Hours<span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">From</span>
                    <select name="mon_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $mondayQuery->pluck('from_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>

                    <span class="input-group-text">To</span>
                    <select name="mon_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $mondayQuery->pluck('to_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>


                    <button type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#mondayGroup" toData="#mondayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>

                <div class="input-group" id="mondayDivSection">

                    @if(isset($data['wh']) AND $mondayRecordAfterFirst->count() > 0)
                        @foreach($mondayRecordAfterFirst as $mon)
                  <div class="input-group mt-1">
                            <span class="input-group-text">From</span>

                            <select name="mon_from[]" class="form-select">
                                <option value="">Choose One</option>
                                @foreach($data['operationalHours'] as $row)
                                    <option value="{{ $row->id }}" {{(isset($data['wh']) AND $mon['from_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                @endforeach
                            </select>
                            <span class="input-group-text">To</span>
                            <select name="mon_to[]" class="form-select">
                                <option value="">Choose One</option>
                                @foreach($data['operationalHours'] as $row)

                                    <option value="{{ $row->id }}" {{(isset($data['wh']) AND $mon['to_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                @endforeach
                            </select>
                            <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                        </div>
                        @endforeach
                    @endif

                </div>




            </div>
            <div class="d-none">
                <div class="input-group mt-1" id="mondayGroup">
                    <span class="input-group-text">From</span>

                    <select name="mon_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>
                    <select name="mon_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

    </div>
     <div class="col-md-6">
         @isset($data['wh'])
             @php
                 $tueSplitQryResult=\App\Http\Helpers\Helper::getQuerySplit($data,'tuesday');

                   $tuesdayQuery=$tueSplitQryResult['dayFirstRecord'];
                   $tuesdayRecordAfterFirst =$tueSplitQryResult['daySliceRecord'];
             @endphp
         @endisset
            <div class="input-group">
                <label for="experience-Input" class="form-label fs-5">Tuesday <span class="text-danger"></span></label>
                <div class="input-group">
                    <input type="hidden" name="tue_hidden_id" value="0">
                    <div class="col-4 input-group-text bg-gray">
                        <input class="form-check-input mt-0" type="radio" value="1" aria-label="Checkbox for following text input" name="tue_wh_setup" {{(isset($data['wh']) AND $tuesdayQuery->pluck('open_type')->first()==1)? "checked":''}}>
                        <span class="ms-2"> Setup Working Hours</span>
                    </div>

                    <div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="2" aria-label="Checkbox for following text input" name="tue_wh_setup" {{(isset($data['wh']) AND $tuesdayQuery->pluck('open_type')->first()==2)? "checked":''}}>
                        <span class="ms-2">Open 24 Hours  </span>
                    </div><div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="3" aria-label="Checkbox for following text input" name="tue_wh_setup" {{(isset($data['wh']) AND $tuesdayQuery->pluck('open_type')->first() !=1 AND $tuesdayQuery->pluck('open_type')->first() !=2)? "checked":''}}>
                        <span class="ms-2">Closed</span>
                    </div>
                </div>
            </div>


            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Working Hours<span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">From</span>

                    <select name="tue_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $tuesdayQuery->pluck('from_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>
                    <select name="tue_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $tuesdayQuery->pluck('to_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button  type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#tuesdayGroup" toData="#tuesdayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>


                <div class="input-group" id="tuesdayDivSection">
                    @if(isset($data['wh']) AND $tuesdayRecordAfterFirst->count() > 0)
                        @foreach($tuesdayRecordAfterFirst as $tue)
                            <div class="input-group mt-1">
                                <span class="input-group-text">From</span>

                                <select name="mon_from[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)
                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $tue['from_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">To</span>
                                <select name="mon_to[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)

                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $tue['to_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                            </div>
                        @endforeach
                    @endif
                </div>


            </div>
            <div class="d-none">
                <div class="input-group mt-1" id="tuesdayGroup">
                    <span class="input-group-text">From</span>

                    <select name="tue_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>

                    <select name="tue_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button" id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

        </div>

    </div>
    <hr>

    <div class="row mt-3">

        <div class="col-md-6">
            @isset($data['wh'])
                @php
                    $wedSplitQryResult=\App\Http\Helpers\Helper::getQuerySplit($data,'wednesday');

                      $wedQuery=$wedSplitQryResult['dayFirstRecord'];
                      $wedRecordAfterFirst =$wedSplitQryResult['daySliceRecord'];
                @endphp
            @endisset
            <div class="input-group">

                <label for="experience-Input" class="form-label fs-5">Wednesday <span class="text-danger"></span></label>
                <div class="input-group">
                    <input type="hidden" name="wed_hidden_id" value="0">
                    <div class="col-4 input-group-text bg-gray">
                        <input class="form-check-input mt-0" type="radio" value="1" aria-label="Checkbox for following text input" name="wed_wh_setup" {{(isset($data['wh']) AND $wedQuery->pluck('open_type')->first()==1)? "checked":''}}>
                        <span class="ms-2"> Setup Working Hours</span>
                    </div>

                    <div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="2" aria-label="Checkbox for following text input" name="wed_wh_setup" {{(isset($data['wh']) AND $wedQuery->pluck('open_type')->first()==2)? "checked":''}}>
                        <span class="ms-2">Open 24 Hours  </span>
                    </div><div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="3" aria-label="Checkbox for following text input" name="wed_wh_setup" {{(isset($data['wh']) AND $wedQuery->pluck('open_type')->first() !=1 AND $wedQuery->pluck('open_type')->first() !=2)? "checked":''}}>
                        <span class="ms-2">Closed</span>
                    </div>
                </div>
            </div>


            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Working Hours<span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">From</span>

                    <select name="wed_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $wedQuery->pluck('from_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>

                    <select name="wed_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $wedQuery->pluck('to_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#wednesdayGroup" toData="#wednesdayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>

                <div class="input-group" id="wednesdayDivSection">
                    @if(isset($data['wh']) AND $wedRecordAfterFirst->count() > 0)
                        @foreach($wedRecordAfterFirst as $tue)
                            <div class="input-group mt-1">
                                <span class="input-group-text">From</span>

                                <select name="wed_from[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)
                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $tue['from_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">To</span>
                                <select name="wed_to[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)

                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $tue['to_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
            <div class="d-none">
                <div class="input-group mt-1" id="wednesdayGroup">
                    <span class="input-group-text">From</span>

                    <select name="wed_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>

                    <select name="wed_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button"  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

        </div>
        <div class="col-md-6">

            @isset($data['wh'])
                @php
                    $thurSplitQryResult=\App\Http\Helpers\Helper::getQuerySplit($data,'thursday');

                      $thurQuery=$thurSplitQryResult['dayFirstRecord'];
                      $thurRecordAfterFirst =$thurSplitQryResult['daySliceRecord'];
                @endphp
            @endisset
            <div class="input-group">
                <label for="experience-Input" class="form-label fs-5">Thursday <span class="text-danger"></span></label>
                <div class="input-group">
                    <input type="hidden" name="thur_hidden_id" value="0">
                    <div class="col-4 input-group-text bg-gray">
                        <input class="form-check-input mt-0" type="radio" value="1" aria-label="Checkbox for following text input" name="thur_wh_setup" {{(isset($data['wh']) AND $thurQuery->pluck('open_type')->first()==1)? "checked":''}}>
                        <span class="ms-2"> Setup Working Hours</span>
                    </div>

                    <div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="2" aria-label="Checkbox for following text input" name="thur_wh_setup" {{(isset($data['wh']) AND $thurQuery->pluck('open_type')->first()==2)? "checked":''}}>
                        <span class="ms-2">Open 24 Hours  </span>
                    </div><div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="3" aria-label="Checkbox for following text input" name="thur_wh_setup" {{(isset($data['wh']) AND $thurQuery->pluck('open_type')->first() !=1 AND $thurQuery->pluck('open_type')->first() !=2)? "checked":''}}>
                        <span class="ms-2">Closed</span>
                    </div>
                </div>
            </div>


            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Working Hours<span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">From</span>


                    <select name="thur_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $thurQuery->pluck('from_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>


                    <select name="thur_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $thurQuery->pluck('to_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#thursdayGroup" toData="#thursdayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>

                <div class="input-group" id="thursdayDivSection">
                    @if(isset($data['wh']) AND $thurRecordAfterFirst->count() > 0)
                        @foreach($thurRecordAfterFirst as $thur)
                            <div class="input-group mt-1">
                                <span class="input-group-text">From</span>

                                <select name="thur_from[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)
                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $thur['from_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">To</span>
                                <select name="thur_to[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)

                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $thur['to_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <div class="d-none">
                <div class="input-group mt-1" id="thursdayGroup">
                    <span class="input-group-text">From</span>
                    <select name="thur_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>

                    <span class="input-group-text">To</span>

                    <select name="thur_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button"  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

        </div>

    </div>
    <hr>

    <div class="row mt-3">

        <div class="col-md-6">
            @isset($data['wh'])
                @php
                    $friSplitQryResult=\App\Http\Helpers\Helper::getQuerySplit($data,'friday');

                      $friQuery=$friSplitQryResult['dayFirstRecord'];
                      $friRecordAfterFirst =$friSplitQryResult['daySliceRecord'];
                @endphp
            @endisset
            <div class="input-group">
                <label for="experience-Input" class="form-label fs-5">Friday <span class="text-danger"></span></label>
                <div class="input-group">
                    <input type="hidden" name="fri_hidden_id" value="0">
                    <div class="col-4 input-group-text bg-gray">
                        <input class="form-check-input mt-0" type="radio" value="1" aria-label="Checkbox for following text input" name="fri_wh_setup" {{(isset($data['wh']) AND $friQuery->pluck('open_type')->first()==1)? "checked":''}}>
                        <span class="ms-2"> Setup Working Hours</span>
                    </div>

                    <div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="2" aria-label="Checkbox for following text input" name="fri_wh_setup" {{(isset($data['wh']) AND $friQuery->pluck('open_type')->first()==2)? "checked":''}}>
                        <span class="ms-2">Open 24 Hours  </span>
                    </div><div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="3" aria-label="Checkbox for following text input" name="fri_wh_setup" {{(isset($data['wh']) AND $friQuery->pluck('open_type')->first() !=1 AND $friQuery->pluck('open_type')->first() !=2)? "checked":''}}>
                        <span class="ms-2">Closed</span>
                    </div>
                </div>
            </div>


            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Working Hours<span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">From</span>

                    <select name="fri_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $friQuery->pluck('from_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>

                    <span class="input-group-text">To</span>


                    <select name="fri_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $friQuery->pluck('to_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#fridayGroup" toData="#fridayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>

                <div class="input-group" id="fridayDivSection">
                    @if(isset($data['wh']) AND $friRecordAfterFirst->count() > 0)
                        @foreach($friRecordAfterFirst as $fri)
                            <div class="input-group mt-1">
                                <span class="input-group-text">From</span>

                                <select name="fri_from[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)
                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $fri['from_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">To</span>
                                <select name="fri_to[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)

                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $fri['to_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
            <div class="d-none">

                <div class="input-group mt-1" id="fridayGroup">
                    <span class="input-group-text">From</span>
                    <select name="fri_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>

                    <span class="input-group-text">To</span>

                    <select name="fri_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button"  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

        </div>
        <div class="col-md-6">
            @isset($data['wh'])
                @php
                    $satSplitQryResult=\App\Http\Helpers\Helper::getQuerySplit($data,'saturday');
                      $satQuery=$satSplitQryResult['dayFirstRecord'];
                      $satRecordAfterFirst =$satSplitQryResult['daySliceRecord'];

                @endphp
            @endisset

            <div class="input-group">
                <label for="experience-Input" class="form-label fs-5">Saturday <span class="text-danger"></span></label>
                <div class="input-group">
                    <input type="hidden" name="sat_hidden_id" value="0">
                    <div class="col-4 input-group-text bg-gray">
                        <input class="form-check-input mt-0" type="radio" value="1" aria-label="Checkbox for following text input" name="sat_wh_setup" {{(isset($data['wh']) AND $satQuery->pluck('open_type')->first()==1)? "checked":''}}>
                        <span class="ms-2"> Setup Working Hours</span>
                    </div>

                    <div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="2" aria-label="Checkbox for following text input" name="sat_wh_setup" {{(isset($data['wh']) AND $satQuery->pluck('open_type')->first()==2)? "checked":''}}>
                        <span class="ms-2">Open 24 Hours  </span>
                    </div><div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="3" aria-label="Checkbox for following text input" name="sat_wh_setup" {{(isset($data['wh']) AND $satQuery->pluck('open_type')->first() !=1 AND $satQuery->pluck('open_type')->first() !=2)? "checked":''}}>
                        <span class="ms-2">Closed</span>
                    </div>
                </div>
            </div>


            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Working Hours<span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">From</span>


                    <select name="sat_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $satQuery->pluck('from_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>

                    <select name="sat_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $satQuery->pluck('to_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#saturdayGroup" toData="#saturdayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>

                <div class="input-group" id="saturdayDivSection">
                    @if(isset($data['wh']) AND $satRecordAfterFirst->count() > 0)
                        @foreach($satRecordAfterFirst as $sat)


                            <div class="input-group mt-1">
                                <span class="input-group-text">From</span>

                                <select name="fri_from[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)
                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $sat['from_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">To</span>
                                <select name="fri_to[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)

                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $sat['to_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <div class="d-none">
                <div class="input-group mt-1" id="saturdayGroup">
                    <span class="input-group-text">From</span>

                    <select name="sat_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>

                    <select name="sat_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button  type="button" id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

        </div>

    </div>
    <hr>
    <div class="row mt-3">

        <div class="col-md-6">
            @isset($data['wh'])
                @php
                    $sunSplitQryResult=\App\Http\Helpers\Helper::getQuerySplit($data,'sunday');

                      $sunQuery=$sunSplitQryResult['dayFirstRecord'];
                      $sunRecordAfterFirst =$sunSplitQryResult['daySliceRecord'];
                @endphp
            @endisset
            <div class="input-group">
                <label for="experience-Input" class="form-label fs-5">Sunday <span class="text-danger"></span></label>
                <div class="input-group">
                    <input type="hidden" name="sun_hidden_id" value="0">
                    <div class="col-4 input-group-text bg-gray">
                        <input class="form-check-input mt-0" type="radio" value="1" aria-label="Checkbox for following text input" name="sun_wh_setup" {{(isset($data['wh']) AND $sunQuery->pluck('open_type')->first()==1)? "checked":''}}>
                        <span class="ms-2"> Setup Working Hours</span>
                    </div>

                    <div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="2" aria-label="Checkbox for following text input" name="sun_wh_setup" {{(isset($data['wh']) AND $sunQuery->pluck('open_type')->first()==2)? "checked":''}}>
                        <span class="ms-2">Open 24 Hours  </span>
                    </div><div class="col-4 input-group-text">
                        <input class="form-check-input mt-0" type="radio" value="3" aria-label="Checkbox for following text input" name="sun_wh_setup" {{(isset($data['wh']) AND $sunQuery->pluck('open_type')->first() !=1 AND $sunQuery->pluck('open_type')->first() !=2)? "checked":''}}>
                        <span class="ms-2">Closed</span>
                    </div>
                </div>
            </div>


            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Working Hours<span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">From</span>

                    <select name="sun_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $sunQuery->pluck('from_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>

                    <select name="sun_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}" {{(isset($data['wh']) AND $sunQuery->pluck('to_wh_id')->first()==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button  type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#sundayGroup" toData="#sundayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>

                <div class="input-group" id="sundayDivSection">
                    @if(isset($data['wh']) AND $sunRecordAfterFirst->count() > 0)
                        @foreach($sunRecordAfterFirst as $sun)
                            <div class="input-group mt-1">
                                <span class="input-group-text">From</span>

                                <select name="fri_from[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)
                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $sun['from_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">To</span>
                                <select name="fri_to[]" class="form-select">
                                    <option value="">Choose One</option>
                                    @foreach($data['operationalHours'] as $row)

                                        <option value="{{ $row->id }}" {{(isset($data['wh']) AND $sun['to_wh_id']==$row->id)? "selected":''}}>{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <button  id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <div class="d-none">
                <div class="input-group mt-1" id="sundayGroup">
                    <span class="input-group-text">From</span>

                    <select name="sun_from[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">To</span>

                    <select name="sun_to[]" class="form-select">
                        <option value="">Choose One</option>
                        @foreach($data['operationalHours'] as $row)
                            <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                        @endforeach
                    </select>
                    <button type="button" id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

        </div>

    </div>

    <hr>
    <div class="row mt-3">

        <div class="col-md-6">
            <div class="input-group">
                <label for="experience-Input" class="form-label fs-5">Off Days <span class="text-danger"></span></label>

            </div>

            @isset($data['wh'])
                @php
                    $data['offDayFirstRecord']=$data['wh']->offDays->first();
                    $data['offDaySliceRecord'] = $data['wh']->offDays->values()->slice(1);

                @endphp
            @endisset

            <div class="input-group mt-3">
                <label for="experience-Input" class="form-label">Configure Off Days <span class="text-danger"></span></label>

                <div class="input-group">
                    <span class="input-group-text">Date</span>

                    <input type="date" class="form-control" name="offDayDate[]" value="{{(isset($data['wh']) AND count($data['wh']->offDays))? $data['offDayFirstRecord']->pluck('close_date')->first():''}}">

                    <button  type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"  fromData="#offDayGroup" toData="#offDayDivSection">
                        <i class="ri-add-fill me-1 align-bottom"></i> Add New Row</button>
                </div>
                <div class="input-group" id="offDayDivSection">

                    @if(isset($data['wh']) AND $data['offDaySliceRecord']->count() > 0)
                        @foreach($data['offDaySliceRecord'] as $offDay)

                    <div class="input-group mt-1" >
                        <span class="input-group-text">Date</span>
                        <input type="date" class="form-control" name="offDayDate[]" value="{{$offDay->close_date}}">
                        <button type="button" id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                    </div>
                        @endforeach
                    @endisset

                </div>

            </div>

            <div class="d-none">
                <div class="input-group mt-1" id="offDayGroup">
                    <span class="input-group-text">Date</span>
                    <input type="date" class="form-control" name="offDayDate[]">
                    <button type="button" id="remove" class="btn btn-outline-danger delete-row" title="Remove"><i class="ri-delete-bin-6-line align-bottom"></i></button>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="d-flex align-items-start gap-3 mt-4">

    <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bill-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back</button>
    <button type="button" class="btn btn-primary btn-label right ms-auto" id="btn-save-wh-info"><i class="ri-bank-card-line label-icon align-middle fs-16 ms-2"></i>Save &amp; Continue to Load Types</button>
    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab d-none" data-nexttab="pills-bill-address-tab" id="btnWorkingHours">Save & Next</button>
</div>
