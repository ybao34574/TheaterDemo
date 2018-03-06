<?php

namespace App\Http\Controllers;

use App\Models\UserSeats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserSeatsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 主页的controller
     */
    public static function index()
    {
        return view('index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 用户选择座位并将所选择的的所有座位和用户信息保存到数据库中
     */
    public static function store(Request $request)
    {
        try {
            $seats = UserSeats::getUserSeats($request->email);
            if((isset($request->submit))&&(count($seats)<20)) {
                UserSeats::randSelectSeats($request->name, $request->email, $request->tickets);
            }
            elseif(isset($request->search)) {
                return redirect("/show/$request->email");
            }
            else{
                return redirect("/")->withInput()->withErrors('每位用户最多只能购买20张晚会票，您可以从查询按钮中查询自己所购买的晚会票，谢谢支持！');
            }
        } catch (\Exception $e) {
            Log::alert('UserSeatsController::store : '.$e);
        }
        return redirect("/show/$request->email");
    }

    /**
     * @param $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 根据用户邮箱查找到用户信息并展现在页面上以便用户查询
     */
    public static function show($email)
    {
        try {
            $seats = UserSeats::getUserSeats($email);
            $user_seats = array();
            foreach ($seats as $seat) {
                $email = $seat->user_email;
                $user_seats[] = explode(',',$seat->user_seats);
            }
        } catch (\Exception $e) {
            Log::alert('UserSeatsController::show : '.$e);
        }

        return view('show', ['email' => $email,'user_seats' => $user_seats]);
    }
}
