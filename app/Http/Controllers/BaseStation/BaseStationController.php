<?php

namespace GL\Http\Controllers\BaseStation;

use GL\Exceptions\NotExistsBaseStationException;
use GL\Http\Controllers\Controller;
use GL\Models\BaseStation\ChinaMobile;
use GL\Models\BaseStation\ChinaTelecom;
use GL\Models\BaseStation\ChinaUnicom;
use GL\Support\Validation\Validation;
use Illuminate\Http\Request;

class BaseStationController extends Controller
{
    use Validation;

    /**
     * Get location by data of gprs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function location(Request $request)
    {
        $this->validate($request, [
            'mnc'     => 'required|integer|in:0,1,2',                     // 设备类型
            'lac'     => 'required_if:mnc,0|required_if:mnc,1|integer',   // 移动、联通小区号
            'cell_id' => 'required_if:mnc,0|required_if:mnc,1|integer',   // 移动、联通基站号
            'sid'     => 'required_if:mnc,2|integer',                     // 电信SID系统识别码（各地区1个）
            'nid'     => 'required_if:mnc,2|integer',                     // 电信NID网络识别码（各地区1-3个）
            'bid'     => 'required_if:mnc,2|integer',                     // 电信基站号
        ]);

        $mnc    = $request->input('mnc');
        $lac    = $request->input('lac');
        $cellId = $request->input('cell_id');
        $sid    = $request->input('sid');
        $nid    = $request->input('nid');
        $bid    = $request->input('bid');

        // 示例
        // return $this->json([
        //     "lat"     => 39.95666122,
        //     "lon"     => 116.31658628953,
        //     "radius"  => 100,
        //     "address" => "北京市海淀区紫竹院街道中广国际新农村;学院南路与中关村南大街路口西北132米"
        // ]);

        switch ($mnc) {
            case 0:
                $baseStation = ChinaMobile::findBy($lac, $cellId);
                break;
            case 1:
                $baseStation = ChinaUnicom::findBy($lac, $cellId);
                break;
            case 2:
                $baseStation = ChinaTelecom::findBy($sid, $nid, $bid);
                break;
            default:
                throw new \Exception('invalid mnc.');
                break;
        }

        if (!$baseStation) {
            throw new NotExistsBaseStationException();
        }

        return $this->json([
            'lat'     => $baseStation->lat,
            'lon'     => $baseStation->lon,
            'radius'  => $baseStation->radius,
            'address' => $baseStation->address,
        ]);
    }

    public function locationByBaseStations(Request $request)
    {
        $this->validate($request, [
            'mnc'   => 'required|integer|in:0,1,2',                     // 设备类型
            'multi' => 'required|json',                                 // 多个
        ]);

        $mnc   = intval($request->input('mnc'));
        $multi = json_decode($request->input('multi'), true);
        if (!is_array($multi) || empty($multi)) {
            return $this->jsonException('no multi.');
        }

        if (count($multi) > 8) {
            return $this->jsonException('too many multi.');
        }

        $keys = [];
        foreach ($multi as $item) {
            if ($mnc === 0 || $mnc === 1) {
                $this->validateData($item, [
                    'lac'     => 'required|integer',   // 移动、联通小区号
                    'cell_id' => 'required|integer',   // 移动、联通基站号
                ]);
                array_push($keys, sprintf('%s-%s', $item['lac'], $item['cell_id']));
            } else {
                $this->validateData($item, [
                    'sid' => 'required|integer',        // 电信SID系统识别码（各地区1个）
                    'nid' => 'required|integer',        // 电信NID网络识别码（各地区1-3个）
                    'bid' => 'required|integer',        // 电信基站号
                ]);
                array_push($keys, sprintf('%s-%s-%s', $item['sid'], $item['nid'], $item['bid']));
            }
        }

        switch ($mnc) {
            case 0:
                $baseStations = ChinaMobile::findByKeys($keys);
                break;
            case 1:
                $baseStations = ChinaUnicom::findByKeys($keys);
                break;
            case 2:
                $baseStations = ChinaTelecom::findByKeys($keys);
                break;
            default:
                throw new \Exception('invalid mnc.');
        }



//        //$result = position_analysis("30.24563 103.2098 -30 30.14363 103.4057 -50 30.4284 103.3087 -20 30.5203 103.6934 -40 30.9372 103.0837 -70 30.73463 103.643 -20");
//        //if(strcmp($type, 'so')) {
//        if('so' == $type) {
//            $result = position_analysis($data);
//            //} else if (strcmp($type, 'bin')) {
//        } else if ('bin' == $type) {
//            $result = exec("./Uploads/PositionAnalyser $data");
//        }




    }
}
