<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\lib\exception\SuccessMessage;

class Order extends BaseController
{
    //用户选择商品后，提交所选择的商品相关信息
    //接受信息后，检查订单相关商品库存量
    //有库存，订单存入数据库，返回消息，可支付
    //调用支付接口进行支付
    //在次进行库存检测
    //服务器调用支付接口进行支付
    //微信返回支付结果
    //成功库存量检测与扣除，失败返回失败结果

    protected $beforeActionList  = [
        'checkExclusiveScope' => ['only'=>'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getSummaryByUser,getDetail'],

    ];
    //订单列表
    public function getSummaryByUser($page=1,$size=15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pageOrder = OrderModel::getSummaryByUser($uid,$page,$size);
        if($pageOrder->isEmpty()){
            return [
                'data' => [],
                'current_page' => $page,
            ];
        }
        return [
            'data' => $pageOrder->hidden(['snap_items','snap_address','prepay_id'])->toArray(),
            'current_page' => $page,
        ];
    }
    //cms 获取订单
    public function getSummary($page=1, $size = 20){
        (new PagingParameter())->goCheck();
//        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByPage($page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];
    }
    //订单详情
    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail)
        {
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }
    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid,$products);
        return $status;
    }
    public function delivery($id){
        (new IDMustBePositiveInt())->goCheck();
        $order = new OrderService();
        $success = $order->delivery($id);
        if($success){
            return new SuccessMessage();
        }
    }
}

?>