<?php

namespace GrimReapper\LaravelSiteMaintenance\Http\Controllers;

use App\Http\Controllers\Controller;
use GrimReapper\LaravelSiteMaintenance\Http\Requests\MaintenanceModeRequest;
use GrimReapper\LaravelSiteMaintenance\Supports\MaintenanceMode;
use Illuminate\Http\Request;
use Modules\Core\Http\Responses\BaseHttpResponse;

class MaintenanceModeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $isDownForMaintenance = app()->isDownForMaintenance();
        return view('grimreapper::maintenance', compact('isDownForMaintenance'));
    }

    /**
     * @param MaintenanceModeRequest $request
     * @param BaseHttpResponse $response
     * @param MaintenanceMode $maintenanceMode
     * @return BaseHttpResponse
     */
    public function run(
        MaintenanceModeRequest $request,
        BaseHttpResponse $response,
        MaintenanceMode $maintenanceMode
    ): BaseHttpResponse
    {
        if(app()->isDownForMaintenance()){
            $maintenanceMode->up();
            return $response
                ->setMessage(trans('grimreapper::maintenance-mode.application_live'))
                ->setData([
                    'is_down' => false,
                    'notice'  => trans('grimreapper::maintenance-mode.notice_disable'),
                    'message' => trans('grimreapper::maintenance-mode.enable_maintenance_mode'),
                ]);
        }
        $maintenanceMode->down($request);
        return $response
            ->setMessage(trans('grimreapper::maintenance-mode.application_down'))
            ->setData([
                'is_down' => true,
                'notice'  => trans('grimreapper::maintenance-mode.notice_enable'),
                'message' => trans('grimreapper::maintenance-mode.disable_maintenance_mode'),
            ]);
    }
}
