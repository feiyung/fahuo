<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 8:52
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    const IS_SORTING = 1;//已分拣
    const IS_NOT_SORTING = 0;//未分拣
    const IS_DELIVERY = 1;//已发货
    const IS_NOT_DELIVERY = 0;//未发货
    public function Order()
    {
        return $this->belongsTo('App\Order','order_id');
    }
    /*获取一条记录*/
    public function getOneInfo($id){
        return $this->where(['id'=>$id])->first();
    }
    /*更新单一记录状态*/
    public function UpdateProduct($id,$data){
        return $this->where(['id'=>$id])->update($data);
    }
    /*更新一个订单下的所有未发货记录状态*/
    public function updateOneAll($order_id,$data){
        return $this->where(['order_id'=>$order_id,'is_delivery'=>self::IS_NOT_DELIVERY])->update($data);
    }

    /*获取一个订单未发货记录数量*/
    public function getCount($id){
        return $this->where(['order_id'=>$id,'is_delivery'=>self::IS_NOT_DELIVERY])->count();
    }
    /*订单拆分插入新记录*/
    public function splitOrder($data){
        return $this->insertGetId($data);
    }
    /*订单详情*/
    public function orderDetail($order_id){
        $data = $this->where(['order_id'=>$order_id])->get();
        foreach ($data as &$item){
            $img = DB::table('picture')->where('id', $item->product_image)->first(['path']);
            $product = DB::table('products')->where('id', $item->product_id)->first(['chinese_name','english_name','attributes']);
            $item->path = $img->path;
            $item->chinese_name = $product->chinese_name;
            $item->english_name = $product->english_name;
            $item->attribute = $product->attributes;

        }
        return $data;
    }

    /*excel信息获取*/
    public function excelInfo($order_id){
        $data = $this->where(['order_id'=>$order_id])->get();
        $order = DB::table('order')->where(['id'=>$order_id])->first();
        $addr = DB::table('daddress')->where(['id'=>$order->address_id])->first();
        $province = DB::table('locations')->where(['id'=>$addr->province_id])->first();
        $city = DB::table('locations')->where(['id'=>$addr->city_id])->first();
        $area = DB::table('locations')->where(['id'=>$addr->area_id])->first();
        foreach($data as &$item){
            $product = DB::table('products')->where('id', $item->product_id)->first();//商品信息
            $marque = DB::table('marques')->where('id', $product->marque_id)->first(['chinese_name']);//品牌
            $country = DB::table('countrys')->where('id', $product->country_id)->first(['chinese_name']);//采购地
            /*dd($addr);*/
            $item->marque = $marque->chinese_name;
            $item->country = $country->chinese_name;
            $item->english_name = $product->english_name;
            $item->fofe = $order->fofe;
            $item->province = $province->name;
            $item->city = $city->name;
            $item->area = $area->name;
            $item->address = $addr->address;
            $item->remark = $order->remark;
            $item->voucher = $order->voucher;
            $item->order_sn = $order->order_sn;
            $item->reciver_name = $order->reciver_name;
            $item->tel = '';
        }
        return $data;
    }
}