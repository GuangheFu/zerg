<?php
namespace app\api\validate;

use think\Validate;
use think\Request;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $parms = $request->param();
        $result = $this->batch()->check($parms);
        if(!$result){
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            //$e->msg = $this->error;
            throw $e;
        }
        else{
            return true;
        }
        
    }

    protected function isInteger($value,$rule = '',$data = '',$field = ''){
        if(is_numeric($value) && is_int($value+0) && ($value + 0) > 0){
            return true;
        }
        else{
            return false;
            //return $field.'必须是正整数';   
        }
    }

    protected function isNotEmpty($value,$rule='',$data='',$field=''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }

    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays) | array_key_exists('uid',$arrays)){
            throw new ParameterException([
                'msg' => '参数中包含非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach($this->rule as $key => $value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule,$value);
        if($result){
            return true;
        }else{
            return false;   
        }
    }
}
?>