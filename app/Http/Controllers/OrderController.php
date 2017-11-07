<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 10:46
 */

namespace App\Http\Controllers;


use App\Model\Order;
use App\Model\OrderProduct;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Support\Facades\Session;

class OrderController  extends Controller
{
    const USERNAME = 'hector@zy1390.com';
    const PASSWORD = 'usadmin';
    public function login(){
        return view('login');
    }
    /*
    * 用户登录
    */
    public function login_in()
    {

        $input = Input::all();
        if (!strlen($input['name'])) {
            exit(json_encode(['flag'=>0,'msg'=>'用户名不能为空！']));
        }
        if (!strlen($input['pwd'])) {
            exit(json_encode(['flag'=>0,'msg'=>'密码不能为空！']));
        }
        if ($input['name']!=self::USERNAME || $input['pwd'] != self::PASSWORD) {
            exit(json_encode(['flag'=>0,'msg'=>'登录失败,请检查账号密码是否正确！']));
        }

        session(['name' => self::USERNAME]);
        Session::save();
        exit(json_encode(['flag'=>1,'msg'=>'']));
    }
    /*用户退出*/
    public function loginout()
    {
        session(['name' => null]);
        Session::save();
        return redirect('/');
    }
    /*未发货列表*/
    public function noSendOrder(){
        $order = new Order();
        $list = $order->getList();
        return view('nosendlist',compact('list'));
    }
    /*已发货列表*/
    public function hadSentOrder(){

        $order = new Order();
        $list = $order->gethadList();
        return view('hadsentlist',compact('list'));
    }
    /*导出excel*/
    public function downLoadExcel($id){

        $orderproduct = new OrderProduct();
        $order = new Order();
        $orderinfo = $order->getOneOrder($id);
        $data = $orderproduct->excelInfo($id);

        /*$cellData = [
            ['订单编号','运单编号','寄件人姓名','寄件人电话','寄件人地址','品牌','商品中文名','商品英文名','商品数量','商品单价','商品规格','采购地','重量(LBS)','保留','保险费','关税','收件人姓名','收件人电话','收件人省份','收件人城市','收件人区\县','收件人地址','收件人邮编','用户备注','优惠码']
        ];*/
        /*$cellData = [
            ['订单编号','运单编号','品牌','商品中文名','商品英文名','商品数量','商品单价','商品规格','采购地','担保金额','收件人姓名','收件人电话','收件人省份','收件人城市','收件人区\县','收件人地址','用户备注','优惠码']
        ];*/
        foreach ($data as $k=>$v){
            $cellData[] = [
                '订单编号' => $v->order_sn,
                '运单编号' => $v->logistics_no,
                '品牌' => $v->marque,
                '商品中文名' => $v->product_name,
                '商品英文名' => $v->english_name,
                '商品数量' => $v->product_num,
                '商品单价' => $v->product_price,
                '商品规格' => $v->speac_value,
                '采购地' => $v->country,
                '担保金额' => $v->fofe,
                '收件人姓名' => $v->reciver_name,
                '收件人电话' => $v->tel,
                '收件人省份' => $v->province,
                '收件人城市' => $v->city,
                '收件人区\县' => $v->area,
                '收件人地址' => $v->address,
                '用户备注' => $v->remark,
                '优惠码' => $v->voucher
            ];
        }

        //dd($cellData);

        Excel::create("$orderinfo->order_sn"."订单信息",function($excel) use ($cellData){
            $excel->sheet('订单信息', function($sheet) use ($cellData){
                $sheet->fromArray($cellData);
                $sheet->setWidth(array(
                    'A'=>20,
                    'B'=>20,
                ));

                /*$sheet->cells('', function($cells) {


                    $cells->setAlignment('center');

                });
                $sheet->setAutoSize(true);
                $sheet->setAllBorders('thin');*/
                $sheet->freezeFirstRow();

            });
        })->export('xls');
    }
    /*订单详情*/
    public function orderDetail($id){
        $orderproduct = new OrderProduct();
        $order = new Order();
        $addr = $order->receiveInfo($id);
        $list = $orderproduct->orderDetail($id);
        return view('orderdetail',compact('list','addr'));
    }
    /*获取指定订单商品*/
    public function product(){
        $id = Input::get('id');
        $order = new Order();
        $result =$order->getProduct($id);
        exit(json_encode($result));
    }
    /*拆分发货*/
    public function delivery(){
        $input = Input::all();
        $orderproduct = new OrderProduct();
        $order = new Order();
        $product = $orderproduct->getOneInfo($input['id']);
        /*判断发货数量*/
        if($product['product_num'] > $input['count']){//发货数量小于订单商品数量,进行拆分
            $newdata = [

                'order_id' => $product['order_id'],
                'product_id' =>$product['product_id'],
                'product_name' => $product['product_name'],
                'product_price' => $product['product_price'],
                'product_num' => $product['product_num'] - $input['count'],
                'product_image' => $product['product_image'],
                'product_pay_price' => $product['product_pay_price'],
                'buy_id' => $product['buy_id'],
                'speac_value' => $product['speac_value'],
                'rate' => $product['rate'],
                'created_at' => time()

            ];
            $split = $orderproduct->splitOrder($newdata);
            if($split){
                $data_del = [
                    'is_sorting' => $orderproduct::IS_SORTING,
                    'is_delivery' => $orderproduct::IS_DELIVERY,
                    'logistics_no' => $input['number'],
                    'product_num' => $input['count']
                ];
                $orderproduct->UpdateProduct($input['id'],$data_del);//该条记录状态改为已发货
                exit(json_encode(['flag'=>1,'msg'=>'发货成功！']));
            }
        }elseif($product['product_num'] == $input['count']){//该商品发货数量完成
            $data = [
                'is_sorting' => $orderproduct::IS_SORTING,
                'is_delivery' => $orderproduct::IS_DELIVERY,
                'logistics_no' => $input['number']
            ];
            $orderproduct->UpdateProduct($input['id'],$data);//该条记录状态改为已发货
            $countno = $orderproduct->getCount($product['order_id']);//获取改订单下未发货商品记录条数
            if(!$countno){
                $order->updateIpa($product['order_id']);//该订单下所有商品完成发货，更改订单处理状态
            }
            exit(json_encode(['flag'=>1,'msg'=>'发货成功！']));
        }else{
            exit(json_encode(['flag'=>0,'msg'=>'发货数量大于了购买数量！']));
        }
       // exit(json_encode($input));
    }
    /*一键发货*/
    public function deliveryAll(){
        $order_id = Input::get('id');
        $number =  Input::get('numberall');
        $orderproduct = new OrderProduct();
        $order = new Order();
        $data = [
            'is_sorting' => $orderproduct::IS_SORTING,
            'is_delivery' => $orderproduct::IS_DELIVERY,
            'logistics_no' => $number
        ];
        $result = $orderproduct->updateOneAll($order_id,$data);//该条记录状态改为已发货
        if($result){
            $order->updateIpa($order_id);//该订单下所有商品完成发货，更改订单处理状态
            exit(json_encode(['flag'=>1,'msg'=>'发货成功！']));

        }


    }
}