<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function PHPSTORM_META\elementType;

class UserSeats extends Model
{
    //
    protected $table = 'user_seats';
    protected $area_table = 'area_row';
    protected $seats_table = 'row_seats';

    /**
     * @param $user
     * @param $email
     * @param $number
     */
    public static function randSelectSeats($user, $email,$number)
    {
        try {
            if($number > 0) {
                $results = new static();
                /**
                 * 随机选取区域和排数
                 */
                $row = $results->from($results->area_table)
                    ->inRandomOrder()->first();
                /**
                 * 根据区域和排数随机选取座位号
                 */
                $seat = $results->from($results->seats_table)
                    ->where($results->seats_table . '.row', '=', $row->row)
                    ->inRandomOrder()
                    ->first();

                /**
                 * 将seats的格式转换为与user_seats表中user_seats的格式一样，便于对比
                 */
                $seats = $row->area . ',' . $row->row . ',' . $seat->seat;

                /**
                 * 确认所选择的的座位是不是已经存在数据库中
                 */
                $validate = self::validateSeats($seats);
                switch ($validate) {
                    /**
                     * 若是选择的座位不在user_seats中，
                     * 将座位号与用户信息写入到user_seats表中，
                     * 用recursion进行下一个座位的选择
                     */
                    case 1:
                        self::insertIntoUserSeats($user, $email, $seats);
                        self::randSelectSeats($user, $email, $number - 1);
                        break;
                    /**
                     * 若是选择的座位已经存在于user_seats表中，
                     * recursion重新开始选择座位
                     */
                    case 2:
                        self::randSelectSeats($user, $email, $number);
                        break;
                    default:
                        Log::alert('UserSeats::randSelectSeats : validate is wrong');
                }
            }
        } catch (\Exception $e) {
            Log::alert('UserSeats::randSelectSeats : '.$e);
        }
    }

    /**
     * @param $user
     * @param $email
     * @param $seats
     */
    protected static function insertIntoUserSeats($user,$email,$seats)
    {
        try {
            DB::table('user_seats')->insert([
                'user_name' => $user,
                'user_email' => $email,
                'user_seats' => $seats,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            Log::alert('UserSeats::insertIntoUserSeats : '.$e);
        }
    }

    /**
     * @param $seats
     * @return bool|int
     */
    protected static function validateSeats($seats)
    {
        try {
            $results = new static();
            $seat = $results->select($results->table.'.*')->from($results->table)
                ->where($results->table . '.user_seats', '=', $seats)
                ->first();
            if(is_null($seat)) {
                return 1;
            }
            return 0;
        } catch (\Exception $e) {
            Log::alert('UserSeats::validateSeats : '.$e);
        }
        return false;
    }

    /**
     * @param $email
     * @return null
     * 根据用户的邮箱查询该用户所购买的所有座位
     */
    public static function getUserSeats($email)
    {
        try {
            $results = new static();
            $seats = $results->select($results->table . '.*')
                ->from($results->table)
                ->where($results->table . '.user_email', '=', $email)
                ->get();
            return $seats;
        }catch (\Exception $e) {
            Log::alert('UserSeats::getUserSeats : '.$e);
        }
        return null;
    }
}
