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

        $isExist = DB::table('le_user_words')->where('uid',1)->where('word',$word)->count();

        if($isExist) {
            $result['code'] = 400;
            $result['msg'] = '该单词已记录';
            return json_encode($result);
        }

        $res = DB::table('le_user_words')->insertGetId(['uid'=>1,'day'=>$day, 'word'=>$word,'add_time'=>time()]);
        // dump($res);
        $result = [];
        if($res) {
            $result['code'] = 200;
            $result['msg'] = "SUCCESS";
            $result['data'] = DB::table('le_user_words')->find($res);
            return json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = "FAILED";
            return json_encode($result);
        }
    }

    public function list(Request $request) {
        $res = DB::table('le_user_words')->where('uid',1)->get();
        $res = $res ? $res->toArray() : [];

        $result = [];
        $result['code'] = 200;
        $result['msg'] = 'SUCCESS';
        $result['data'] = $res;

        return json_encode($result);
    }

    public function del(Request $request) {
        $id = $request->get('id');
        $res = DB::table('le_user_words')->where('id',$id)->delete();
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
