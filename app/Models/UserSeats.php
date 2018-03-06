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

    public static function randSelectSeats($user, $email,$number)
    {
        try {
            $results = new static();
            $row = $results->from($results->area_table)
                ->inRandomOrder()->first();

            $seat = $results->from($results->seats_table)
                ->where($results->seats_table . '.row', '=', $row->row)
                ->inRandomOrder()
                ->first();

            $seats = $row->area . ',' . $row->row . ',' . $seat->seat;
            $validate = self::getSeats($seats);
            if ($validate == true) {
                self::insertIntoUserSeats($user,$email,$seats);
                self::randSelectSeats($user, $email, $number - 1);
            } else {
                self::randSelectSeats($user, $email, $number);
            }
        } catch (\Exception $e) {
            Log::alert('UserSeatsController::store : '.$e);
        }
    }

    public static function insertIntoUserSeats($user,$email,$seats)
    {
        try {
            $results = new static();
            $results->table->insert([
                'user_name' => $user,
                'user_email' => $email,
                'user_seats' => $seats,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            Log::alert('UserSeatsController::store : '.$e);
        }
    }

    public static function getSeats($seats)
    {
        $results = new static();
        $seat = $results->select($results->table.'.*')->from($results->table)
            ->where($results->table . '.user_seats', '=', $seats)
            ->first();
        if(is_null($seat)) {
            return true;
        }
        return false;
    }
}
