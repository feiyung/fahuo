@extends('layouts.master')
@section('title')
    未发货订单
@endsection
<style>
    .tab-pane table thead th,td{
        font-size: 12px !important;
    }
</style>
@section('content')

    <div class="container-fluid">
        {{--<div class="page-head">
            <h2>未发货订单</h2>
            --}}{{--<ol class="breadcrumb">
                <li><a href="#">首页</a></li>
                <li><a href="#">红酒管理</a></li>
                <li class="active">红酒列表</li>
            </ol>--}}{{--
        </div>--}}
        <div class="md-modal colored-header md-effect-3 info" id="md-slideUp">
            <div class="md-content">
                <div class="modal-header">
                    <h3>发货方式</h3>
                    <button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="max-height: 750px;overflow-y: auto;background-color: #f6f6f6">
                    <div class="tab-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">一键发货</a></li>
                            <li><a href="#profile" data-toggle="tab">拆分发货</a></li>
                        </ul>
                        <div class="tab-content" style="margin-bottom: 0;">
                            <div class="tab-pane active cont" id="home">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">运单编号</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="" placeholder="请输入运单编号" style="border-radius: 4px;" name="numberall">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="button" class="btn btn-info btn-xs btn-rad" style="margin-left: 0;" id="sendall">确认发货</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane cont" id="profile">
                                <table class="hover">
                                    <thead class="no-border">
                                    <tr>
                                        <th width="20%">商品名称</th>
                                        <th width="15%">规格</th>
                                        <th width="15%">购买数量</th>
                                        <th width="15%">发货数量</th>
                                        <th width="20%">运单编号</th>
                                        <th class="text-right" width="15%">执行发货</th>
                                    </tr>
                                    </thead>
                                    <tbody class="no-border-y order_p">


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer alert alert-danger" role="alert" style="text-align: start">
                    <i class="fa fa-info-circle sign"></i>提醒：一次发完订单所有商品用（一键发货），否则用拆分发货！

                    {{--<button type="button" class="btn btn-default btn-flat md-close btn-rad" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning btn-flat md-close btn-rad" data-dismiss="modal">Proceed</button>--}}
                </div>
            </div>
        </div>

        <div class="md-overlay"></div>
        <div class="cl-mcont" style="padding: 0">
            <div class="row">


                <div class="col-sm-12 col-md-12 column">



                    <div class="block-flat">
                        <div class="header">
                            <h3>待发货订单</h3>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table table-bordered hover" id="datatable-icons" >
                                    <thead>
                                    <tr>
                                        <th style="word-break: keep-all;white-space:nowrap;">订单编号</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">支付单号</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">订单价格</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">订单所属</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">创建时间</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">订单操作</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">客服备注</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">用户备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $v)
                                    <tr class="odd gradeX">
                                        <td>{{$v->order_sn}}</td>
                                        <td>{{$v->pay_sn}}</td>
                                        <td>&yen;{{number_format($v->order_amount)}}</td>
                                        <td>{{$v->buy_name}}</td>
                                        <td>{{$v->created_at}}</td>
                                        <td class="center ">

                                            <button class="btn btn-info btn-rad btn-xs btn-flat" type="button" data-toggle="collapse" data-target="#collapseExample{{$v->id}}" aria-expanded="false" aria-controls="collapseExample">操作选项<span class="caret"></span></button>
                                            <div class="collapse" id="collapseExample{{$v->id}}">
                                                <div class="well" style="padding: 5px 0;width: 70px;background: none;border:none;margin-bottom: 0;">
                                                    <button type="button" class="gosend btn btn-info btn-rad btn-xs btn-flat md-trigger" data-modal="md-slideUp" data-id="{{$v->id}}">去发货</button><br/>
                                                    <a href="{{url('/order/excel',[$v->id])}}" ><button type="button" class="btn btn-info btn-rad btn-xs btn-flat" style="margin-top: 5px;margin-bottom: 5px !important;">导出excel</button></a>
                                                    <br/>  <a href="{{url('/order/orderdetail',[$v->id])}}" target="_blank"><button type="button" class="btn btn-info btn-rad btn-xs btn-flat md-trigger" data-modal="detail">订单详情</button></a>
                                                </div>
                                            </div>
                                            {{--<div class="btn-group">
                                                <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">操作选项<span class="caret"></span></button>
                                                <ul role="menu" class="dropdown-menu pull-left" style="width: 80px;background: #fff">
                                                    <li style="width: 80px;"><button type="button" class="gosend btn btn-info btn-rad btn-xs btn-flat md-trigger" data-modal="md-slideUp" data-id="{{$v->id}}">去发货</button></li>
                                                    <li style="width: 80px;"><button type="button" class="btn btn-info btn-rad btn-xs btn-flat">导出excel</button></li>
                                                    <li style="width: 80px;"><button type="button" class="btn btn-info btn-rad btn-xs btn-flat md-trigger" data-modal="detail">订单详情</button></li>
                                                </ul>
                                            </div>--}}
                                        </td>
{{--                                        <td>
                                            <button type="button" class="gosend btn btn-info btn-rad btn-xs btn-flat md-trigger" data-modal="md-slideUp" data-id="{{$v->id}}">去发货</button><br/>
                                            <button type="button" class="btn btn-info btn-rad btn-xs btn-flat" style="margin-top: 5px;margin-bottom: 5px !important;">导出excel</button>
                                            <br/>  <button type="button" class="btn btn-info btn-rad btn-xs btn-flat md-trigger" data-modal="detail">订单详情</button>
                                        </td>--}}
                                        <td class="center">{{$v->shop_explain}}</td>
                                        <td class="center">{{$v->remark}}</td>
                                    </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>


                </div>
            </div>




        </div>
    </div>

@endsection
@section('javascript')
    <script>


    $(function(){
        //Horizontal Icons dataTable
        var config = {
            "oLanguage": {
                "sLengthMenu": "每页显示 _MENU_ 条记录",
                "sZeroRecords": "抱歉， 没有找到",
                "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                "sInfoEmpty": "没有数据",
                "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "前一页",
                    "sNext": "后一页",
                    "sLast": "尾页"
                }}};
        $('#datatable-icons').dataTable();
        $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
        $('.dataTables_length select').addClass('form-control');
    })


        $(".gosend").click(function(){
            var id = $(this).attr('data-id');
            var str = '';
            $("#sendall").attr('data-id',id);
            $(".order_p").empty();
            $.post("{{url('/order/product')}}",{id:id,_token:"{{csrf_token()}}"},function(data){
                    $.each(data,function(k,v){
                        str = str + `<tr>
                            <td>`+v.product_name+`</td>
                            <td>`+v.speac_value+`</td>
                            <td>`+v.product_num+`</td>
                            <td>
                                    <input type="text" class="form-control" id="" placeholder="" style="border-radius: 4px;width: 70%;height: 24px;" name="count">


                            </td>
                            <td>
                                    <input type="text" class="form-control" id="" placeholder="" style="border-radius: 4px;width: 100%;height: 24px;" name="number">


                            </td>
                            <td class="text-right">
                                <button type="button" class="btn btn-info btn-rad btn-xs btn-flat md-trigger submitinfo" data-modal="md-slideUp" data-id="`+v.id+`" onclick="delivery(this);">确认发货</button>
                            </td>
                        </tr>`;
                    })
                $(".order_p").html(str);

            },'json')
        })
    /*拆分发货*/
        function delivery(th){

            var count = $(th).parent().prev().prev().find("input[name='count']").val();
            var number = $(th).parent().prev().find("input[name='number']").val();
            var id = $(th).attr('data-id');
            reg = /^[1-9]\d*$/;
            if(!reg.test(count)){
                alertfail('请输入有效数量！');
                return false;
            }
            if(!number.length){
                alertfail('请输入运单编号！');
                return false;
            }

            $.post("{{url('/order/delivery')}}",{
                count:count,
                number:number,
                id:id,
                _token:"{{csrf_token()}}"
            },function(data){
                if(data.flag==0){
                    alertfail(data.msg);
                }else if(data.flag==1){
                    alertsuccess(data.msg);
                    setTimeout(function(){
                        location.reload(true);
                    },1500);

                }
            },'json')

        }
        /*一键发货*/
        $("#sendall").click(function(){
            var id = $(this).attr('data-id');
            var numberall = $("input[name=numberall]").val();
            if(!numberall.length){
                alertfail('请输入运单编号！');
                return false;
            }
            $.post("{{url('/order/deliveryall')}}",{id:id,numberall:numberall,_token:"{{csrf_token()}}"},function(data){
                if(data.flag==1){
                    alertsuccess(data.msg);
                    setTimeout(function(){
                        location.reload(true);
                    },1500);
                }else{
                    alertfail('发货失败！');
                }
            },'json')
        })
    </script>
@endsection