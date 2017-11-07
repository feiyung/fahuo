<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 16:06
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';
    const ORDER_STATE_PAY = 20;//已付款
    const ORDER_STATE_SEND = 30;//已发货
    const ORDER_IPA_STATE_YES = 2;//已处理
    const ORDER_IPA_STATE_NO = 1;//未处理

    public function Product(){
        return $this->hasMany('App\Model\OrderProduct','order_id');
    }

    /*获取已付款订单*/

    public function getList(){
        $result = $this->where(['order_state'=>self::ORDER_STATE_PAY])->get();
        return $result;
    }
    /*获取已发货订单*/
    public function gethadList(){
        $result = $this->where(['order_state'=>self::ORDER_STATE_SEND])->paginate(20);
        return $result;
    }

    /*获取订单对应未发货商品*/
    public function getProduct($id){
        $orderProduct = new OrderProduct();
        return $orderProduct->where(['order_id'=>$id,'is_delivery'=>$orderProduct::IS_NOT_DELIVERY])->get();
    }
    /*更改处理状态和订单状态*/

    public function updateIpa($id){
        $this->where(['id'=>$id])->update(['order_state'=>self::ORDER_STATE_SEND]);
    }
    /*获取订单收货人信息*/
    public function receiveInfo($id){
        $data = $this->where(['id'=>$id])->first(['address_id','reciver_name']);
        $addr = DB::table('daddress')->where(['id'=>$data['address_id']])->first();
        $data->address = $addr->address;
        return $data;

    }
    /*获取一条订单*/
    public function getOneOrder($id){
        return $this->where(['id'=>$id])->first();
    }


}