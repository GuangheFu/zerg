<?php

namespace app\api\service;

use think\Request;
use think\Cache;
use app\lib\exception\TokenException;
use think\Exception;
use app\lib\exception\ForbiddenException;
use app\lib\enum\ScopeEnum;

class Token
{
    

    public static function generateToken(){
        //32位无意义随机字符串
        $randChars = getRandChar(32);
        $timestamp = time();
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key){
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }
        else{
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('尝试获取的Token变量不存在');
            }
        }    
    }

    //用户管理员都可访问的权限
    public static function needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope >= ScopeEnum::User){
                return true;
            }
            else{
                throw new ForbiddenException();
            }
        }
        else{
            throw new TokenException();
        }
    }
    //用户可访问的权限
    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope == ScopeEnum::User){
                return true;
            }
            else{
                throw new ForbiddenException();
            }
        }
        else{
            throw new TokenException();
        }
        
    }
    /**
     * 当需要获取全局UID时，应当调用此方法
     *而不应当自己解析UID
     *
     */
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        $scope = self::getCurrentTokenVar('scope');
        if ($scope == ScopeEnum::Super)
        {
            // 只有Super权限才可以自己传入uid
            // 且必须在get参数中，post不接受任何uid字段
            $userID = input('get.uid');
            if (!$userID)
            {
                throw new ParameterException(
                    [
                        'msg' => '没有指定需要操作的用户对象'
                    ]);
            }
            return $userID;
        }
        else
        {
            return $uid;
        }
    }
    //uid是否合法
    public static function isValidOperate($checkedUID)
    {
        if(!$checkedUID){
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }
    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }
}

?>