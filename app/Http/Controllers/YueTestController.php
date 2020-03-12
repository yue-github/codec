<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Auth;
class YueTestController extends Controller
{
    
    public function yue_test(Request $request) {

        $validator = Validator::make($request->all(), [
            'offset' => 'required|integer|min:0',
            'length' => 'required|integer|min:1',
            'username' => 'string|max:255',
        ]);
        if($validator->fails()) {
            return $this->fails($validator->errors()->all());
        }

        $result = DB::table('yue_test')
            ->select([
                'yue_test.id as id',
                'yue_test.username as username',
                'yue_test.password as password',
                'yue_test.age as age',
                'yue_test.sex as sex',
                'yue_test.vip_name as vip_name',
            ]);
        if ($request->has('username'))
            $result = $result->where('yue_test.username', '=', $request->input('username'));
        $count = $result->count();
        $result = $result
            ->offset($request->input('offset'))
            ->limit($request->input('length'))
            ->get();
        
        $result = [
            'data' => $result,
            'total' => $count
        ];
        return $this->success($result);
    }
 
}
