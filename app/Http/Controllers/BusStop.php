<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BusStop extends Controller
{

    public $BusArrivalLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusArrivalv2';
    public $BusStopLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusStops';
    public $BusRouteLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusRoutes';
    public $BusDataLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusServices';

    function get_nearest_busstop(Request $req){
        $lat = isset($req['lat']) ? $req['lat'] : 0;
        $long = isset($req['long']) ? $req['long'] : 0;
        $AccountKey = isset($req['AccountKey']) ? $req['AccountKey'] : '';
        $resultLength = isset($req['length']) ? $req['length']: 10;
        $AccountKey = str_replace(" ", "+", $AccountKey);
        $calls = 500;
        $check = 0;
        $AllBusStops = array();
        $result = array();
        $array = array();
        $actualResult = array();

        if (!($lat || $long || $AccountKey)) {
            return "Invalid Parameters";
        }

        $BusStops = Http::withHeaders([
            'AccountKey' => $AccountKey
        ])->get($this->BusStopLink);

        if ($BusStops->serverError()) {
            return "Server Error";
        } else if ($BusStops->clientError()) {
            return "Account Code Wrong";
        }
        foreach($BusStops['value'] as $i) {
            array_push($AllBusStops, $i);
        }

        while(count($BusStops['value']) != 0) {
            $BusStops = Http::withHeaders([
                'AccountKey' => $AccountKey
            ])->get($this->BusStopLink);

            if ($BusStops->serverError()) {
                return "Server Error";
            } else if ($BusStops->clientError()) {
                return "Account Code Wrong";
            }
            foreach($BusStops['value'] as $i) {
                array_push($AllBusStops, $i);
            }

            $this->BusStopLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusStops?$skip='.$calls;
            $calls += 500;
        }

        foreach($AllBusStops as $i) {
            $array['code'] = $i['BusStopCode'];
            $latdiff = abs($lat - $i['Latitude']);
            $longdiff = abs($long - $i['Longitude']);
            $array['diff'] = $latdiff + $longdiff;
            $count = 0;
            $temp = array();
            $temp[] = $array;
            if (!$result) {
                array_push($result, $array);
            } else {
                foreach($result as $n) {
                    if ($array['diff'] < $n['diff']) {
                        array_splice($result, $count, 0, $temp);
                        break;
                    }
                    if ($count == count($result)-1) {
                        array_push($result, $array);
                    }
                    $count++;
                }
            }
        }

        foreach($result as $i) {
            foreach($AllBusStops as $n) {
                if ($i['code'] == $n['BusStopCode']) {
                    array_push($actualResult, $n);
                    $check++;
                    break;
                }
            }
            if ($check == $resultLength) {
                break;
            }
        }
        return ($actualResult);
    }

    function get_bus_stop_timing(Request $req) {
        $BusStopCode = isset($req['BusStopCode']) ? $req['BusStopCode'] : 0;
        $busNo = isset($req['ServiceNo']) ? $req['ServiceNo'] : 0;
        $AccountKey = isset($req['AccountKey']) ? $req['AccountKey'] : '';
        $AccountKey = str_replace(" ", "+", $AccountKey);
        date_default_timezone_set("Singapore");
        $result = array();
        $busData = array();
        $actualResult = array();

        if (!($BusStopCode || $AccountKey)) {
            return "Invalid Parameters";
        }

        $Buses = Http::withHeaders([
            'AccountKey' => $AccountKey
        ])->get($this->BusArrivalLink, [
            'BusStopCode' => $BusStopCode
        ]);

        if ($Buses->serverError()) {
            return "Server Error";
        } else if ($Buses->clientError()) {
            return "Account Code Wrong";
        }

        $currentTime = time();
        foreach($Buses['Services'] as $i) {
            $busDataContainer = array();

            $result['ServiceNo'] = $i['ServiceNo'];
            $result['OriginCode'] = $i['NextBus']['OriginCode'];
            $result['DestinationCode'] = $i['NextBus']['DestinationCode'];

            if (isset($busNo) && $result['ServiceNo'] == $busNo) {
                $ArrivalTime = strtotime($i['NextBus']['EstimatedArrival']);
                $busData['EstimatedArrival'] = (round(($ArrivalTime - $currentTime)/60) <= 0) ? "Arr" : round(($ArrivalTime - $currentTime)/60);
                $busData['Type'] = $i['NextBus']['Type'];
                $busData['Load'] = $i['NextBus']['Load'];
                $busData['Feature'] = isset($i[$NextBus]['Feature']) ? $i['NextBus']['Feature'] : "none";
                $result['BusData'] = $busDataContainer;
                $actualResult[] = $result;
                break;
            } else {
                $nextBus = "NextBus";
                for($n = 1; $n < 4; $n++) {
                    if ($i[$nextBus]['Type'] != "") {
                        $ArrivalTime = strtotime($i[$nextBus]['EstimatedArrival']);
                        $busData['EstimatedArrival'] = (round(($ArrivalTime - $currentTime)/60) <= 0) ? "Arr" : round(($ArrivalTime - $currentTime)/60);
                        $busData['Type'] = $i[$nextBus]['Type'];
                        $busData['Load'] = $i[$nextBus]['Load'];
                        $busData['Feature'] = isset($i[$nextBus]['Feature']) ? $i[$nextBus]['Feature'] : "none";
                    }
                    switch ($n) {
                        case 2: 
                            $nextBus = "NextBus2";
                            break;
                        case 3: 
                            $nextBus = "NextBus3";
                            break;
                        default: 
                            $nextBus = "NextBus";
                    }
                    $busDataContainer[] = $busData;
                }
            }
            $result['BusData'] = $busDataContainer;
            $actualResult[] = $result;
        }
        return $actualResult;
    }

    function get_bus_route(Request $req) {
        $BusNumber = isset($req['BusNumber']) ? $req['BusNumber'] : '';
        $AccountKey = isset($req['AccountKey']) ? $req['AccountKey'] : '';
        $AccountKey = str_replace(" ", "+", $AccountKey);
        $AllBuses = [];
        $AllBusStops = [];
        $calls = 0;
        $result = array();

        if (!($BusNumber || $AccountKey)) {
            return "Invalid Parameters";
        }

        $Buses = Http::withHeaders([
            'AccountKey' => $AccountKey
        ])->get($this->BusRouteLink);

        if ($Buses->serverError()) {
            return "Server Error";
        } else if ($Buses->clientError()) {
            return "Account Code Wrong";
        }

        foreach($Buses['value'] as $i) {
            if ($i['ServiceNo'] == $BusNumber) {
                array_push($AllBuses, $i);
            }
        }

        while(count($Buses['value']) != 0) {
            $Buses = Http::withHeaders([
                'AccountKey' => $AccountKey
            ])->get($this->BusRouteLink);

            if ($Buses->serverError()) {
                return "Server Error";
            } else if ($Buses->clientError()) {
                return "Account Code Wrong";
            }
            foreach($Buses['value'] as $i) {
                if ($i['ServiceNo'] == $BusNumber) {
                    array_push($AllBuses, $i);
                }
            }

            $this->BusRouteLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusRoutes?$skip='.$calls;
            $calls += 500;
        }

        $calls = 0;

        $BusStops = Http::withHeaders([
            'AccountKey' => $AccountKey
        ])->get($this->BusStopLink);

        if ($BusStops->serverError()) {
            return "Server Error";
        } else if ($BusStops->clientError()) {
            return "Account Code Wrong";
        }
    
        foreach($BusStops['value'] as $i) {
            array_push($AllBusStops, $i);
        }

        while(count($BusStops['value']) != 0) {
            $BusStops = Http::withHeaders([
                'AccountKey' => $AccountKey
            ])->get($this->BusStopLink);

            if ($BusStops->serverError()) {
                return "Server Error";
            } else if ($BusStops->clientError()) {
                return "Account Code Wrong";
            }
            foreach($BusStops['value'] as $i) {
                array_push($AllBusStops, $i);
            }

            $this->BusStopLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusStops?$skip='.$calls;
            $calls += 500;
        }

       foreach($AllBuses as $i) {
            $data = array();
            $data['ServiceNo'] = $i['ServiceNo'];
            $data['Operator'] = $i['Operator'];
            $data['Direction'] = $i['Direction'];
            $data['StopSequence'] = $i['StopSequence'];
            $data['BusStopCode'] = $i['BusStopCode'];
            $data['Distance'] = $i['Distance'];
            $data['WD_FirstBus'] = $i['WD_FirstBus'];
            $data['WD_LastBus'] = $i['WD_LastBus'];
            $data['SAT_FirstBus'] = $i['SAT_FirstBus'];
            $data['SAT_LastBus'] = $i['SAT_LastBus'];
            $data['SUN_FirstBus'] = $i['SUN_FirstBus'];
            $data['SUN_LastBus'] = $i['SUN_LastBus'];

            foreach ($AllBusStops as $n) {
                if ($n['BusStopCode'] == $i['BusStopCode']) {
                    $data['RoadName'] = $n['RoadName'];
                    $data['Description'] = $n['Description'];
                    $data['Latitude'] = $n['Latitude'];
                    $data['Longitude'] = $n['Longitude'];
                    break;
                }
            }
            $result[] = $data;
       }
       return $result;
    }

    function search_bus(Request $req) {
        $BusNumber = isset($req['BusNumber']) ? $req['BusNumber'] : '';
        $AccountKey = isset($req['AccountKey']) ? $req['AccountKey'] : '';
        $AccountKey = str_replace(" ", "+", $AccountKey);
        $calls = 0;
        $result = array();

        if (!($AccountKey)) {
            return "Invalid Parameters";
        }

        $Buses = Http::withHeaders([
            'AccountKey' => $AccountKey
        ])->get($this->BusDataLink);

        if ($Buses->serverError()) {
            return "Server Error";
        } else if ($Buses->clientError()) {
            return "Account Code Wrong";
        }

        foreach($Buses['value'] as $i) {
            if ($i['ServiceNo'] == $BusNumber) {
                $result[] = $i;
                return $result;
            }
        }

        while(count($Buses['value']) != 0) {
            $Buses = Http::withHeaders([
                'AccountKey' => $AccountKey
            ])->get($this->BusDataLink);

            if ($Buses->serverError()) {
                return "Server Error";
            } else if ($Buses->clientError()) {
                return "Account Code Wrong";
            }
            foreach($Buses['value'] as $i) {
                if ($i['ServiceNo'] == $BusNumber) {
                    $result[] = $i;
                    return $result;
                }
            }

            $this->BusDataLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusRoutes?$skip='.$calls;
            $calls += 500;
        }

        $result['output'] = "no data found";
        return $result;
    }

    function get_bus_stop(Request $req) {
        $BusStopCode = isset($req['BusStopCode']) ? $req['BusStopCode'] : '';
        $AccountKey = isset($req['AccountKey']) ? $req['AccountKey'] : '';
        $AccountKey = str_replace(" ", "+", $AccountKey);
        $calls = 0;
        $result = array();

        if (!($BusStopCode || $AccountKey)) {
            return "Invalid Parameters";
        }

        $BusStops = Http::withHeaders([
            'AccountKey' => $AccountKey
        ])->get($this->BusStopLink);

        if ($BusStops->serverError()) {
            return "Server Error";
        } else if ($BusStops->clientError()) {
            return "Account Code Wrong";
        }
    
        foreach($BusStops['value'] as $i) {
            if ($i['BusStopCode'] == $BusStopCode) {
                $result[] = $i;
                return $result;
            }
        }

        while(count($BusStops['value']) != 0) {
            $BusStops = Http::withHeaders([
                'AccountKey' => $AccountKey
            ])->get($this->BusStopLink);

            if ($BusStops->serverError()) {
                return "Server Error";
            } else if ($BusStops->clientError()) {
                return "Account Code Wrong";
            }
            foreach($BusStops['value'] as $i) {
                if ($i['BusStopCode'] == $BusStopCode) {
                    $result[] = $i;
                    return $result;
                }
            }

            $this->BusStopLink = 'http://datamall2.mytransport.sg/ltaodataservice/BusStops?$skip='.$calls;
            $calls += 500;
        }
        $result['output'] = "no data found";
        return $result;
    }
}
