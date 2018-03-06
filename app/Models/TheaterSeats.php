<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TheaterSeats extends Model
{
    //
    //
    /**
     * 剧场座位分为四个区
     * 每个区座位数量一样，第一排50个座位，最后一行100个座位
     * $area = ['A','B''C','D']
     * $row = getRow();
     * $seat = [1=>[1,...50],2=>[1,...50],3=>[1,...52],...$row-1=>[1,...98],$row=>[1,...100]
     * 隔排递增（奇数排递增）
     * $odd_seats
     * $even_seats
     */
    public static function buildAllSeats()
    {
        try {
            $row = self::getExtensionRow();
            $odd_seats = array();
            $even_seats = array();

            for($i=1; $i<=$row;$i++) {
                $odd_seats[$i] = self::buildSeatsInOneRow($i);
            }
            for($i=1; $i<=$row-1;$i++) {
                $even_seats[$i] = self::buildSeatsInOneRow($i);
            }
            $seats = array_merge($odd_seats ,$even_seats);
            usort($seats,array('self','mySort'));

            return $seats;
        } catch (\Exception $e) {
            Log::alert('TheaterSeats::buildAllSeats : '.$e);
        }
        return null;
    }

    /**
     * 剧场总共有2*getRow-1排
     * 四个区域
     */
    public static function insertIntoAreaRow()
    {
        try {
            $areas = ['A','B','C','D'];
            $ext_row = self::getExtensionRow();
            $row = $ext_row*2-1;
            foreach ($areas as $area) {
                for ($i=1; $i<=$row; $i++) {
                    DB::table('area_row')->insert([
                        'area' => $area,
                        'row' => $i,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::alert('TheaterSeats::buildAllSeats : '.$e);
        }
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    private static function mySort($a,$b)
    {
        try {
            return (count($a)<count($b))?-1:1;
        } catch (\Exception $e) {
            Log::alert('TheaterSeats::buildAllSeats : '.$e);
        }
        return null;
    }

    /**
     * @param $row
     * @return array
     */
    private static function buildSeatsInOneRow($row)
    {
        try {
            $seats = array();
            $first = 50;
            $last = $first+($row-1)*2;
            for($i=1; $i<=$last; $i++) {
                $seats[$i] = $i;
            }
            return $seats;
        } catch (\Exception $e) {
            Log::alert('TheaterSeats::buildAllSeats : '.$e);
        }
       return null;
    }

    /**
     * 利用等差数列求出剧场总共有多少排座位
     * last = first+(row-1)*d
     * last = 100
     * first = 50
     * d = 2
     * 从50增加到100需要的排数：
     * (last - first)/d+1 = row
     * 座位隔排递增，实际排数是两倍的row
     */
    private static function getExtensionRow()
    {
        try {
            $first = 50;
            $last = 100;
            $d = 2;
            $row = ($last - $first)/$d+1;
            return $row;
        } catch (\Exception $e) {
            Log::alert('TheaterSeats::buildAllSeats : '.$e);
        }
      return null;
    }
}
