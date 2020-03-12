<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Controller extends BaseController
{
    protected $token = '';
    public function __construct(){
        // header("Access-Control-Allow-Origin: *");//允许所有来源访问
        // header('Access-Control-Allow-Methods: "GET, POST, PATCH, PUT, OPTIONS"');//允许访问的方式
        // header('Access-Control-Allow-Credentials: true');
        // header('Access-Control-Allow-Headers: "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"');
        // header('Access-Control-Max-Age: "3600"');
        date_default_timezone_set('Asia/Shanghai');
        $tk = Auth::user();
        if ($tk) {
            $this->token = $tk;
        }
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function success($result = '')
    {
        return response()->json(['status' => 'success', 'result' => $result]);
    }

    protected function fails($msg = '')
    {
        return response()->json(['status' => 'fail', 'errorMsg' => $msg]);
    }
}
