<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\dock\DockInterface;
use Illuminate\Http\Request;

class DockController extends Controller
{
    private $dock;


    public function __construct(DockInterface $dock)
    {
        $this->dock = $dock;
    }
    public function storeDock(Request $request)
    {
        try {
            $saveDock=$this->dock->storeUpdateDock($request,$request->hidden_dock_id);
            if ($saveDock->get('status')){
                return Helper::ajaxSuccess($saveDock->get('data'),$saveDock->get('message'));
            }else{
                return Helper::error($saveDock->get('message'),[]);
            }
        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    public function dockList(Request $request){
        try {

                $res=$this->dock->dockList($request,1);
            if($res['data']->count() > 0){

                $data = collect([]);
                foreach ( $res['data'] as $row){

                    $loadTypeArray = collect([]);
                    foreach ($row->dockLoadTypes as $dock){
                        $load=$dock->loadType->direction->value .'('.$dock->loadType->operation->value .' ,'. $dock->loadType->duration.' minutes'.')';
                        $loadTypeArray->push($load);
                    }


                    $loadTypes = implode(',', $loadTypeArray->toArray());


                    $array = array(
                        'id' =>$row->id,
                        'loadType' =>$loadTypes,
                        'title' =>  $row->title,
                        'slot' => 'allow ' . $row->slot .' slots at same time ',
                        'schedule_limit' => 'can schedule '. $row->schedule_limit .' days in advance',
                        'schedule_cancel' =>'can not edit/reschedule before '. $row->cancel_before .' hours',
                        'status' =>$row->status,
                    );
                    $data->push($array);
                }

                return Helper::success($data,'Dock list');
            }else{
                return Helper::error('Dock not found',[]);
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }


    public function editDock($id)
    {
        try {
            $res= $this->dock->editDock($id);
            if($res->get('data')){
                $data=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }


    public function destroy($id)
    {

        try {
            $res = $this->dock->deleteDock($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }



    public function getDockListByLoadtype(Request $request){
        try {
             $request->all();
            return  $res = $this->dock->getDockListByLoadtype($request->loadtype,$request->whId);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
}
