<?php

namespace app\api\controller\v1;

use app\api\model\UserAddress;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\UserException;
use app\lib\exception\SuccessMessage;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\api\controller\BaseController;

class Address extends BaseController
{
    protected $beforeActionList  = [
        'checkPrimaryScope' => ['only'=>'createorupdateaddress']
    ];

    public function getUserAddress(){
        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
               'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }

    public function createOrUpdateAddress(){

        $valiedate = new AddressNew();
        $valiedate->goCheck();
        //token获取uid
        //根据uid查找用户
        //获取用户提交来的信息
        //地址是否存在，做相应添加或更新
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
        $dataArray = $valiedate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if(!$userAddress){
            $user->address()->save($dataArray);
        }
        else{
            $user->address->save($dataArray);
        }
        return new SuccessMessage();
    }
}

?>