<?php

namespace App;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use PDO;

class ShiftManagement
{
    public $result;


    public function getShiftPattern($index, $is_reverse =false){
        $shift_pattern = ["Shift Malam","Shift Malam","Shift Sore","Shift Sore","Shift Pagi","Shift Pagi","Libur","Libur"];
        if($is_reverse){
            return array_reverse($shift_pattern)[$index];
        }
        return $shift_pattern[$index];
    }

    
        public function getStartPattern($grup){
            switch($grup){
                case "Grup A":
                    return Carbon::create(2025,1,29);
                case "Grup B":
                    return Carbon::create(2025,1,27);
                case "Grup C":
                    return Carbon::create(2025,1,25);
                case "Grup D":
                    return Carbon::create(2025,1,23);
                    default:
                    break;
            }
        }
    public function getShift(Carbon $dt){
        $diffA = $dt->diffInDays($this->getStartPattern("Grup A"),true);
        $diffB = $dt->diffInDays($this->getStartPattern("Grup B"),true);
        $diffC = $dt->diffInDays($this->getStartPattern("Grup C"),true);
        $diffD = $dt->diffInDays($this->getStartPattern("Grup D"),true);

        $this->result = [
                "shift" => [
                      $this->getShiftByDiff($diffA, $dt, "Grup A") => "Grup A",
                      $this->getShiftByDiff($diffB, $dt, "Grup B") => "Grup B",
                      $this->getShiftByDiff($diffC, $dt, "Grup C") => "Grup C",
                      $this->getShiftByDiff($diffD, $dt, "Grup D") => "Grup D",
                    ],
                "grup" => [
                        "Grup A" => $this->getShiftByDiff($diffA, $dt, "Grup A"),
                        "Grup B" => $this->getShiftByDiff($diffB, $dt, "Grup B"),
                        "Grup C" => $this->getShiftByDiff($diffC, $dt, "Grup C"),
                        "Grup D" => $this->getShiftByDiff($diffD, $dt, "Grup D"),
                    ],
                "time" => [
                    
                        "Shift Pagi" => CarbonInterval::minutes(1)->toPeriod("08:00", "15:59"),
                        "Shift Sore" => CarbonInterval::minutes(1)->toPeriod("16:00", "21:59"),
                        "Shift Malam" => CarbonInterval::minutes(1)->toPeriod("22:00", "07:59"),
                    ]
            ];

            return $this;
        

            
    }

    public function byShift($shift){
        return $this->result['shift'][$shift];
    }

    public function byGroup($grup){
        return $this->result['grup'][$grup];
    }

    public function byTime($time){
        $interval_pagi = [];
        $interval_sore = [];
        $interval_malam = [];
        foreach($this->result["time"]["Shift Pagi"] as $date){
            $interval_pagi[] = $date->format("H:i");
        }
        foreach($this->result["time"]["Shift Sore"] as $date){
            $interval_sore[] = $date->format("H:i");
        }
        foreach($this->result["time"]["Shift Malam"] as $date){
            $interval_malam[] = $date->format("H:i");
        }
        switch($time){
            case in_array($time,$interval_pagi):
                return "Shift Pagi";
                break;
            case in_array($time,$interval_sore):
                return "Shift Sore";
                break;
            default:
                return "Shift Malam";
                break;
        }
        
    }


    private function getShiftByDiff($diff, $dt, $grup){

        if($diff > 7){
                if($dt > $this->getStartPattern($grup))
                {
                    $shift_index = $diff % 8;
                    return $this->getShiftPattern($shift_index);
                } else{
                    $shift_index = $diff % 9;
                    return $this->result = $this->getShiftPattern($shift_index, true);
                }
        } else{
                if($dt > $this->getStartPattern($grup))
                {
                    return $this->getShiftPattern($diff);
                } else{
                    return $this->getShiftPattern($diff, true);
                }
        }
    }

}
