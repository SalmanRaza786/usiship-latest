<?php
namespace App\Repositries\wh;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\OperationalHour;
use App\Models\OrderBookedSlot;
use App\Models\WareHouse;
use App\Models\WhAssignedField;
use App\Models\WhOffDay;
use App\Models\WhOperationHour;
use App\Models\WhWorkingHour;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;


class WhRepositry implements WhInterface {

    public function getWhList($request)
    {
        try {
            $data['totalRecords'] = WareHouse::count();

            $qry = WareHouse::query();


            $qry=$qry->when($request->name, function ($query, $name) {
                return $query->where('title', 'LIKE', "%{$name}%")
                    ->orWhere('email','LIKE',"%{$name}%")
                    ->orWhere('phone','LIKE',"%{$name}%")
                    ->orWhere('address','LIKE',"%{$name}%")
                    ->orWhere('note','LIKE',"%{$name}%");
            });

            $qry=$qry->when($request->status, function ($query, $status) {
                return $query->where('status',$status);
            });
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data']=$qry->orderByDesc('id')->get();

            if (!empty($request->get('name')) OR !empty($request->get('status')) ) {
                $data['totalRecords']=$data['data']->count();
            }
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


    public function updateOrCreate($request,$id)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'wh_title' => 'required|string|max:255',
                'wh_email' => 'required|string|email|max:255|unique:ware_houses,email,'. $id,
                'wh_phone' => 'required|string|max:255',
                'wh_status' => 'required|string|max:255',
                'wh_address' => 'required|string|max:255',
                'wh_note' => 'required|string|max:255',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());



            $wh = WareHouse::updateOrCreate(
                [
                    'id' => $id
                ],
                [

                    'title' => $request->wh_title,
                    'email' => $request->wh_email,
                    'phone' => $request->wh_phone,
                    'address' => $request->wh_address,
                    'note' => $request->wh_note,
                    'status' => $request->wh_status,

                ]
            );

             $res=$this->saveWhOperationalHours($request,$wh->id);
             $res=$this->saveOffDays($request,$wh->id);



            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($wh, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deleteWh($id)
    {
        try {
            $role = WareHouse::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editWh($id)
    {
        try {
              $res = WareHouse::with('whWorkingHours','offDays')->findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }
    public function getAllWhList()
    {
        try {
            $qry = WareHouse::with('whWorkingHours.oprationHoursFrom','whWorkingHours.oprationHoursTo','loadTypes','docks','assignedFields');
            $data=$qry->get();
            return Helper::success($data, $message=__('translation.record_found'));
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function storeAssignFields($request)
    {

        try {
            $id=$request->hidden_assigned_field_id;
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'field_id' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());
            foreach ($request->field_id as $key=>$val) {
                $wh = WhAssignedField::updateOrCreate(
                    [
                        'id' =>$id
                    ],
                    [
                        'wh_id' =>$request->hidden_wh_id_fields,
                        'field_id' =>$val,
                        'status' => $request->status,
                    ]
                );
            }
            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();

            return Helper::success($wh, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function assignFieldsList($request)
    {
        try {
            $qry = WhAssignedField::query();
            $qry = $qry->with('customFields');
            $qry = $qry->where('wh_id',$request->wh_id);
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message=__('translation.record_found'));
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function editAssignFields($id)
    {
        try {
            $res = WhAssignedField::findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function deleteAssignFields($id)
    {
        try {
            $role = WhAssignedField::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function getGeneralOperationalHours()
    {
        try {
            $qry = OperationalHour::query();
            $data=$qry->get();
            return Helper::success($data, $message=__('translation.record_found'));
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getWareHousesWithOperationHour($request=null)
    {
        try {
            $qry = WareHouse::with('docks','loadTypes.direction','loadTypes.operation','loadTypes.eqType','loadTypes.transMode','assignedFields.customFields');
            $qry = $qry->where('status',1);
            ($request AND $request->wh_id > 0)?$qry = $qry->where('id',$request->wh_id):'';
            $data = $qry->get();

            $wareHouses=collect([]);
            if($data->count() > 0){
                foreach ($data as $wh)
                {
                    foreach ($wh->docks as $dock){
                        $scheduleLimit=  $dock->schedule_limit;
                        $currentDate = Carbon::now();
                        $upToScheduleDate = $currentDate->copy()->addDays((int)$scheduleLimit);

                        $dates = collect([]);

                        while ($currentDate->lessThanOrEqualTo($upToScheduleDate)) {

                            $daysSlots=$this->getDaysSlots($currentDate->dayName);
                            $offDay = $this->getOffDays($currentDate->toDateString(),$wh->id);

//                            $unwantedIds = [3];
//                            $removedItems = $daysSlots->reject(function ($slot) use ($unwantedIds) {
//                                return in_array($slot['id'], $unwantedIds);
//                            });

                            $slotArray=array(
                                'day'=>$currentDate->dayName,
                                'date'=>$currentDate->toDateString(),
                                'availableSlots'=>(($offDay==1)?[]:$daysSlots)
                            );
                            $dates->push($slotArray);
                            $currentDate->addDay();
                        }

                    }

                    $whArray=array(
                        'id'=>$wh->id,
                        'title'=>$wh->title,
                        'email'=>$wh->email,
                        'phone'=>$wh->phone,
                        'address'=>$wh->address,
                        'note'=>$wh->note,
                        'status'=>$wh->status,
                        'operationalHours'=>$dates,
                        'docks'=>$wh->docks,
                        'loadTypes'=>$wh->loadTypes,
                        'formFields'=>$wh->assignedFields,
                    );

                    $wareHouses->push($whArray);
                }
            return Helper::success($wareHouses, $message=__('translation.record_found'));
            }
            else{
                return Helper::error('Warehouse list is empty',[]);
            }
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function getDaysSlots($dayName)
    {

        $dayaData= WhWorkingHour::where('day_name',$dayName)->get();
        $daySlots = collect([]);
        foreach ($dayaData as $row) {
            $opeartionalHours = OperationalHour::whereBetween('id', [$row->from_wh_id, $row->to_wh_id])->get();
            foreach ($opeartionalHours as $opeartionalHour) {

                $slotArray = array(
                    'id' => $opeartionalHour->id,
                    'working_hour' => $opeartionalHour->working_hour,
                );
                $daySlots->push($slotArray);
            }
        }

        return $daySlots;

    }
    public function getOffDays($date,$wh_id)
    {
        return  $offdaysData= WhOffDay::whereDate('close_date',$date)->where('wh_id',$wh_id)->count();

    }

    public function saveWhOperationalHours($request,$wh_id)
    {

        try {
           $workingHour= WhWorkingHour::where('wh_id',$wh_id)->delete();
        $operateHour=Helper::getFirstLastOperationHourId();

            if($request->mon_from){
                if($request->mon_wh_setup==2){

                    $wh = WhWorkingHour::updateOrCreate(
                        [
                            'id' =>$request->mon_hidden_id
                        ],
                        [
                            'day_name' =>'monday',
                            'wh_id' =>$wh_id,
                            'from_wh_id' =>$operateHour['first'],
                            'to_wh_id' =>$operateHour['last'],
                            'is_open' =>($request->mon_wh_setup==3)?2:1,
                            'open_type' =>$request->mon_wh_setup,
                        ]
                    );

                }
                if($request->mon_wh_setup==1) {
                    foreach ($request->mon_from as $key => $val) {
                        if ($val != null) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->mon_hidden_id
                                ],
                                [
                                    'day_name' => 'monday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => ($request->mon_wh_setup < 3) ? ($request->mon_wh_setup == 1) ? $request->mon_from[$key] : $operateHour['first'] : null,
                                    'to_wh_id' => ($request->mon_wh_setup < 3) ? ($request->mon_wh_setup == 1) ? $request->mon_to[$key] : $operateHour['last'] : null,
                                    'is_open' => ($request->mon_wh_setup == 3) ? 2 : 1,
                                    'open_type' => $request->mon_wh_setup,
                                ]
                            );
                        }

                        if ($request->mon_wh_setup == 3) {
                            break;
                        }

                    }
                }

            }

            // Tuesday
            if($request->tue_from){
                if($request->mon_wh_setup==2){

                    $wh = WhWorkingHour::updateOrCreate(
                        [
                            'id' =>$request->tue_hidden_id
                        ],
                        [
                            'day_name' =>'tuesday',
                            'wh_id' =>$wh_id,
                            'from_wh_id' =>$operateHour['first'],
                            'to_wh_id' =>$operateHour['last'],
                            'is_open' =>($request->tue_wh_setup==3)?2:1,
                            'open_type' =>$request->tue_wh_setup,
                        ]
                    );

                }

                if($request->tue_wh_setup==1) {
                    foreach ($request->tue_from as $key => $val) {
                        if ($val != null) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->tue_hidden_id
                                ],
                                [
                                    'day_name' => 'tuesday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => ($request->tue_wh_setup < 3) ? ($request->tue_wh_setup == 1) ? $request->tue_from[$key] : $operateHour['first'] : null,
                                    'to_wh_id' => ($request->tue_wh_setup < 3) ? ($request->tue_wh_setup == 1) ? $request->tue_to[$key] : $operateHour['last'] : null,
                                    'is_open' => ($request->tue_wh_setup == 3) ? 2 : 1,
                                    'open_type' => $request->tue_wh_setup,
                                ]
                            );
                        }

                        if ($request->tue_wh_setup == 3) {
                            break;
                        }

                    }
                }


            }

            // Wednesday
            if($request->wed_from){

                if($request->wed_wh_setup==1) {
                    foreach ($request->wed_from as $key => $val) {
                        if ($val != null) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->wed_hidden_id
                                ],
                                [
                                    'day_name' => 'wednesday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => ($request->wed_wh_setup < 3) ? ($request->wed_wh_setup == 1) ? $request->wed_from[$key] : $operateHour['first'] : null,
                                    'to_wh_id' => ($request->wed_wh_setup < 3) ? ($request->wed_wh_setup == 1) ? $request->wed_to[$key] : $operateHour['last'] : null,
                                    'is_open' => ($request->wed_wh_setup == 3) ? 2 : 1,
                                    'open_type' => $request->wed_wh_setup,
                                ]
                            );
                        }

                        if ($request->wed_wh_setup == 3) {
                            break;
                        }

                    }
                }

                if($request->wed_wh_setup==2) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->wed_hidden_id
                                ],
                                [
                                    'day_name' => 'wednesday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => $operateHour['first'] ,
                                    'to_wh_id' =>  $operateHour['last'],
                                    'is_open' =>1,
                                    'open_type' => $request->wed_wh_setup,
                                ]
                            );

                }

            }

            // Thursday
            if($request->thur_from){

                if($request->thur_wh_setup==1) {
                    foreach ($request->thur_from as $key => $val) {
                        if ($val != null) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->thur_hidden_id
                                ],
                                [
                                    'day_name' => 'thursday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => ($request->thur_wh_setup < 3) ? ($request->thur_wh_setup == 1) ? $request->thur_from[$key] : $operateHour['first'] : null,
                                    'to_wh_id' => ($request->thur_wh_setup < 3) ? ($request->thur_wh_setup == 1) ? $request->thur_to[$key] : $operateHour['last'] : null,
                                    'is_open' => ($request->thur_wh_setup == 3) ? 2 : 1,
                                    'open_type' => $request->thur_wh_setup,
                                ]
                            );
                        }

                        if ($request->thur_wh_setup == 3) {
                            break;
                        }

                    }
                }


                if($request->thur_wh_setup==2) {

                            $wh =WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->thur_hidden_id
                                ],
                                [
                                    'day_name' => 'thursday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => $operateHour['first'],
                                    'to_wh_id' =>  $operateHour['last'],
                                    'is_open' => 1,
                                    'open_type' => $request->thur_wh_setup,
                                ]
                            );
                        }
            }

            // Friday
            if($request->fri_from){
                if($request->fri_wh_setup==1) {
                    foreach ($request->fri_from as $key => $val) {
                        if ($val != null) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->fri_hidden_id
                                ],
                                [
                                    'day_name' => 'friday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => ($request->fri_wh_setup < 3) ? ($request->fri_wh_setup == 1) ? $request->fri_from[$key] : $operateHour['first'] : null,
                                    'to_wh_id' => ($request->fri_wh_setup < 3) ? ($request->fri_wh_setup == 1) ? $request->fri_to[$key] : $operateHour['last'] : null,
                                    'is_open' => ($request->fri_wh_setup == 3) ? 2 : 1,
                                    'open_type' => $request->fri_wh_setup,
                                ]
                            );
                        }

                        if ($request->fri_wh_setup == 3) {
                            break;
                        }

                    }
                }

                if($request->fri_wh_setup==2) {

                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->fri_hidden_id
                                ],
                                [
                                    'day_name' => 'friday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => $operateHour['first'] ,
                                    'to_wh_id' => $operateHour['last'] ,
                                    'is_open' => 1,
                                    'open_type' => $request->fri_wh_setup,
                                ]
                            );


                }

            }

            // Sat
            if($request->sat_from){
                if($request->sat_wh_setup==1) {
                    foreach ($request->sat_from as $key => $val) {
                        if ($val != null) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->sat_hidden_id
                                ],
                                [
                                    'day_name' => 'saturday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => ($request->sat_wh_setup < 3) ? ($request->sat_wh_setup == 1) ? $request->sat_from[$key] : $operateHour['first'] : null,
                                    'to_wh_id' => ($request->sat_wh_setup < 3) ? ($request->sat_wh_setup == 1) ? $request->sat_to[$key] : $operateHour['last'] : null,
                                    'is_open' => ($request->sat_wh_setup == 3) ? 2 : 1,
                                    'open_type' => $request->sat_wh_setup,
                                ]
                            );
                        }

                        if ($request->sat_wh_setup == 3) {
                            break;
                        }

                    }
                }

                if($request->sat_wh_setup==2) {

                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->sat_hidden_id
                                ],
                                [
                                    'day_name' => 'saturday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => $operateHour['first'],
                                    'to_wh_id' => $operateHour['last'],
                                    'is_open' => 1,
                                    'open_type' => $request->sat_wh_setup,
                                ]
                            );

                }

            }

            // Sunday
            if($request->sun_from){
                if($request->sun_wh_setup==1) {
                    foreach ($request->sun_from as $key => $val) {
                        if ($val != null) {
                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->sun_hidden_id
                                ],
                                [
                                    'day_name' => 'sunday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => ($request->sun_wh_setup < 3) ? ($request->sun_wh_setup == 1) ? $request->sun_from[$key] : $operateHour['first'] : null,
                                    'to_wh_id' => ($request->sun_wh_setup < 3) ? ($request->sun_wh_setup == 1) ? $request->sun_to[$key] : $operateHour['last'] : null,
                                    'is_open' => ($request->sun_wh_setup == 3) ? 2 : 1,
                                    'open_type' => $request->sun_wh_setup,
                                ]
                            );
                        }

                        if ($request->sun_wh_setup == 3) {
                            break;
                        }

                    }
                }

                if($request->sun_wh_setup==2) {

                            $wh = WhWorkingHour::updateOrCreate(
                                [
                                    'id' => $request->sun_hidden_id
                                ],
                                [
                                    'day_name' => 'sunday',
                                    'wh_id' => $wh_id,
                                    'from_wh_id' => $operateHour['first'],
                                    'to_wh_id' => $operateHour['last'] ,
                                    'is_open' => 1,
                                    'open_type' => $request->sun_wh_setup,
                                ]
                            );
                }

            }
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public function saveOffDays($request,$wh_id)
    {

        try {
            $offDay= WhOffDay::where('wh_id',$wh_id)->delete();
            if($request->offDayDate){
                foreach ($request->offDayDate as $key=>$val){
                    if($val!=null){
                        $wh = WhOffDay::updateOrCreate(
                            [
                                'id' =>0
                            ],
                            [
                                'wh_id' =>$wh_id,
                                'close_date' =>$request->offDayDate[$key],
                            ]
                        );
                    }
                }
            }
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public function getWhDayWiseOperationalHours($wh_id)
    {
        return  $results = DB::table('wh_working_hours as wh')
            ->select('day_name')
            ->selectSub(function ($query) use($wh_id) {
                $query->from('wh_working_hours')
                    ->select('from_wh_id')
                    ->whereColumn('day_name', 'wh.day_name')
                    ->where('wh_id',$wh_id)
                    ->orderBy('id')
                    ->limit(1);
            }, 'first_from_wh_id')
            ->selectSub(function ($query) use ($wh_id)  {
                $query->from('wh_working_hours')
                    ->select('to_wh_id')
                    ->whereColumn('day_name', 'wh.day_name')
                    ->where('wh_id',$wh_id)
                    ->orderByDesc('id')
                    ->limit(1);
            }, 'to_wh_id')
            ->groupBy('day_name')

            ->get();


        return   $offdaysData= WhWorkingHour::with('oprationHoursFrom','oprationHoursTo')->where('wh_id',$wh_id)->get()->groupBy('day_name');


    }

    public function getDockWiseOperationalHour($request)
    {
        try {
            $dockId=$request->dockId;
            $loadTypeId=$request->loadTypeId;

               $dockInfo= Helper::getDockInfo($dockId,$loadTypeId);
               $allowSlots=$dockInfo->dock->slot;
               $sliceSequenceLength=$dockInfo->loadType->duration /30;

//            $bookedOrdersSlots = OrderBookedSlot::join('orders', 'order_booked_slots.order_id', '=', 'orders.id')
//                ->select(DB::raw('orders.order_date, order_booked_slots.operational_hour_id, count(order_booked_slots.id) as operational_hour_count'))
//                ->where('orders.dock_id',$dockId)
//                ->groupBy('orders.order_date', 'order_booked_slots.operational_hour_id')
//                ->having('operational_hour_count', '>=', $allowSlots)
//                ->get();


            $bookedOrdersSlots = OrderBookedSlot::join('orders', 'order_booked_slots.order_id', '=', 'orders.id')
                ->join('order_statuses', 'orders.status_id', '=', 'order_statuses.id') // Join with the statuses table
                ->select(DB::raw('orders.order_date, order_booked_slots.operational_hour_id, count(order_booked_slots.id) as operational_hour_count'))
                ->where('orders.dock_id', $dockId)
                ->where('order_statuses.order_by', '>', 10) // Add the condition for order_by > 10
                ->groupBy('orders.order_date', 'order_booked_slots.operational_hour_id')
                ->having('operational_hour_count', '>=', $allowSlots)
                ->get();




            $request->merge(['wh_id'=>$dockInfo->wh_id]);
            $whInfo =Helper::fetchOnlyData($this->getWareHousesWithOperationHour($request));


            $whHours =collect([]);
            foreach ($whInfo[0]['operationalHours'] as $row){

                $bookedIds = [];

                foreach ($bookedOrdersSlots as $booked){
                    if($booked->order_date==$row['date']){
                        $bookedIds[] = $booked->operational_hour_id;
                    }
                }



                $collection = collect($row['availableSlots']);
                $filteredCollection = $collection->reject(function ($item) use ($bookedIds) {
                    return in_array($item['id'], $bookedIds);
                })->values();

                $data=$rejectedBookedSlotsFromAvailableSlots = $filteredCollection->all();


                //$sliceSequenceLength=2;
                $nonSequentialIds = [];
                for($i=0; $i < count($data); $i++){
                    $isSequential = true;
                    for ($j = 1; $j < $sliceSequenceLength; $j++) {
                        if (!isset($data[$i + $j]['id']) || $data[$i + $j]['id'] != $data[$i]['id'] + $j) {
                            $isSequential = false;
                            break;
                        }
                    }

                    if(!$isSequential){
                        $nonSequentialIds[] = $data[$i]['id'];
                    }
                }

                $filterDataCollection = collect($rejectedBookedSlotsFromAvailableSlots);
                $nonSeqFilteredCollection = $filterDataCollection->reject(function ($item) use ($nonSequentialIds) {
                    return in_array($item['id'], $nonSequentialIds);
                })->values();

                $nonSeqFilterData = $nonSeqFilteredCollection->all();
                $array=array(
                    'day'=>$row['day'],
                    'date'=>$row['date'],
//                    'filterData'=>$rejectedBookedSlotsFromAvailableSlots,
//                    'nonSequentialIds'=>$nonSequentialIds,
                    'availableSlots'=>$nonSeqFilterData,
                );

                $whHours->push($array);
            }
            return $whHours;

        }
        catch (\Exception $e) {
            throw $e;
        }
    }


}





