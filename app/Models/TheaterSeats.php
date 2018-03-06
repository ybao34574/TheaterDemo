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

            /**
             * 得到所有的奇数列数组
             */
            for($i=1; $i<=$row;$i++) {
                $odd_seats[$i] = self::buildSeatsInOneRow($i);
            }
            /**
             * 得到所有的欧数列数组，
             * 最后一排为100，则座位数增加到100后不再增加，
             * 偶数排比奇数排少一排
             */
            for($i=1; $i<=$row-1;$i++) {
                $even_seats[$i] = self::buildSeatsInOneRow($i);
            }
            /**
             * 合并奇数列和偶数列并根据座位的数量重新排列
             */
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
     * 对比两个数组A和B
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
     * 利用等差公式，根据排号计算出没排座位的数量
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
     * 剧场座位隔排增加，于是每一个奇数排比之前的奇数排增加2个座位，每一排偶数排比之前的偶数排增加两个座位
     * 将奇数排和偶数排看做两个不同的等差数列
     * 从50增加到100需要的排数：
     * (last - first)/d+1 = row
     * 因为剧场座位最后一排为100排 假设增加到100排结束，所以奇数排到达100个座位之后，偶数排不再增加
     * 则剧场所有座位的总排数为
     * 2*row-1
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
