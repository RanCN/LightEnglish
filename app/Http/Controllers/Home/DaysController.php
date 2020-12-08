<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DaysController extends Controller
{
    public function list(Request $request)
    {
        $res = DB::select('select day, count("*") count from le_user_words group by day');
        $data = [];
        foreach($res as $item) {
            $result['day'] = self::changeDate($item->day);
            $result['count'] = $item->count;
            $result['time'] = $item->day;
            $data[] = $result;
        }
        $res2['code'] = 200;
        $res2['msg'] = "SUCCESS";
        $res2['data'] = $data;
        return json_encode($res2);
    }

    public function changeDate($date)
    {
        $year = substr($date,0,4);
        $month = substr($date,4,2);
        $day = substr($date,6,2);
        if($month[0] == 0) $month = $month[1];
        if($day[0] == 0) $day = $day[1];
        return $year . '年' . $month . '月' . $day . '日';
    }
}
