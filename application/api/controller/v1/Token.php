<?php

namespace app\api\controller\v1;

use app\api\validate\TokenGet;
use app\api\service\UserToken;
use app\api\service\AppToken;

class Token
{
    public function getToken($code=''){
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get($code);
        return [
            'token' => $token,
        ];        
        //081kRueV1koYaY0DXDhV1FBgeV1kRueU
    }

    //cms登陆
    public function getAppToken($ac='',$se=''){
        (new AppTokenGet())->goCheck();
        $app = new AppToken();
        $token = $app->get($ac,$se);
        return [
            'token'=>$token
        ];
    }
    
}

?>