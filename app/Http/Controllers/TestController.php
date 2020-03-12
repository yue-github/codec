<?php 
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
class TestController extends Controller{
     //url，请求的服务器地址
     private $url = 'https://coral3.com/yes/public/api/test';
    
     //is_return，是否返回结果而不是直接显示
     private $is_return = 1;
	public function init(){
		date_default_timezone_set('PRC');
    }
    public function crash(){
        $result = DB::table('crash')->get();
        if($result->isEmpty()){
            $r = DB::table('crash')->insert(['type'=>request('type'),'time'=>date('Y-m-d H:i:s',time())]);
        }else{
            $r = DB::table('crash')->where('id',json_decode($result,true)[0]['id'])->update(['type'=>request('type'),'time'=>date('Y-m-d H:i:s',time())]);
        }
        return response()->json(['status'=>200]);
    }
    public function t(){
        return DB::table("users")->get();
    }
    
    public function killClass(){
        $result = DB::table('class_order')->get();
        return $result;
    }
    public function post(Request $request){
        echo("hello123");
        //  DB::table("test")->insert(["nam"=>request("respTxnSsn"),"hah"=>123456]);
    }
	public function test(){
        return request('test')?request('test').date('Y-m-d H:i:s',time()):'hello lowingshan333666';
    }
    public function getTask(){
         
    }
    public function getName(){
        return DB::table('task')
                   ->orderBy('date','desc')
                   ->get();
    }
	public function upload(Request $request){
        // 文件是否上传成功
		$file = $request->file('file');
		 
		if ($file->isValid()) {
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $type = $file->getClientMimeType();     // image/jpeg
            
            // 上传文件
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            //这里的uploads是配置文件的名称
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            $path ='/uploads/'.$filename;
            return response()->json(['url'=>$path]); 
        }
    }
    
    // 需要token
    public function needToken(){
        return '测试token';
    }
    
}
?>