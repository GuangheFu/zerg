<?php
namespace app\lib\exception;

use think\Exception;
use think\exception\Handle;
use think\Request;
use think\Log;
use think\Config;
//use api\lib\exception\BaseException;
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorcode;

    public function render(\Exception $ex)
    {
        if($ex instanceof BaseException){
            $this->code = $ex->code;
            $this->msg = $ex->msg;
            $this->errorcode = $ex->errorcode;
        }
        else{
            if(Config::get('app_debug')){
                return parent::render($ex);
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorcode = 999;
                $this->recordErrorLog($ex);   
            }
        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorcode,
            'request_url' => $request->url(),
        ];
        return json($result,$this->code);
    }
    public function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}
?>