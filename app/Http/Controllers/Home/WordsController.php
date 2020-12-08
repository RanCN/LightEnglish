<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class WordsController extends Controller
{
    //
    public function index(Request $request) {
        $word = $request->get('val');
        $day = date('Ymd');

        $isExist = DB::table('le_user_words')->where('uid',1)->where('word',$word)->first();
        if($isExist) {
            $record = DB::table('le_query_record')->where('uw_id',$isExist->id)->orderBy('add_time', 'desc')->first();

            $now = time();
            if($record && ($now - $record->add_time  > 20)) {
                DB::transaction(function() use ($isExist) {
                    DB::table('le_user_words')->where('id',$isExist->id)->increment('repeat_num');
                    DB::table('le_query_record')->insert(['uw_id'=>$isExist->id,'word'=>$isExist->word,'type'=>'RECORD','add_time'=>time()]);
                });
            }

            $result['code'] = 400;
            $result['msg'] = '该单词已记录';
            if($isExist) {
                $result['data'] = DB::table('le_query_record')->where('uw_id',$isExist->id)->orderBy('add_time', 'desc')->get()->toArray();
            }
            return json_encode($result);
        }

        $res = DB::table('le_user_words')->insertGetId(['uid'=>1,'day'=>$day, 'word'=>$word,'add_time'=>time()]);

        $result = [];
        if($res) {
            $result['code'] = 200;
            $result['msg'] = "SUCCESS";
            $result['data'] = DB::table('le_user_words')->find($res);
            DB::transaction(function() use ($res,$word) {
                DB::table('le_user_words')->where('id',$res)->increment('repeat_num');
                DB::table('le_query_record')->insert(['uw_id'=>$res,'word'=>$word,'type'=>'RECORD','add_time'=>time()]);
            });
            return json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = "FAILED";
            return json_encode($result);
        }
    }

    /**
     * 当天单词接口
     */
    public function list(Request $request) {
        $day = $request->get('time');
        $day = date('Ymd',substr($day,0,10));
        $res = DB::table('le_user_words')->where('day',$day)->where('uid',1)->get();
        $res = $res ? $res->toArray() : [];

        $result = [];
        $result['code'] = 200;
        $result['msg'] = 'SUCCESS';
        $result['data'] = $res;

        return json_encode($result);
    }

    /**
     * 删除接口
     */
    public function del(Request $request) {
        $id = $request->get('id');
        DB::transaction(function() use ($id) {
            DB::table('le_user_words')->where('id',$id)->delete();
            DB::table('le_query_record')->where('uw_id',$id)->delete();
        });
        $res = true;
        if($res) {
            $result['code'] = 200;
            $result['msg'] = "删除成功";
            return json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = "删除失败";
            return json_encode($result);
        }
    }
}
