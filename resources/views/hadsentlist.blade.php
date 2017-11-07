@extends('layouts.master')
@section('title')
    已发货订单
@endsection
@section('content')
    <div class="container-fluid">

        <div class="cl-mcont" style="padding: 0">
            <div class="row">


                <div class="col-sm-12 col-md-12 column">



                    <div class="block-flat">
                        <div class="header">
                            <h3>已发货订单</h3>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatable-icons" >
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


                                                        <button type="button" class="btn btn-info btn-rad btn-xs btn-flat" style="margin-top: 5px;margin-bottom: 5px !important;">导出excel</button>
                                                        <br/> <a href="{{url('/order/orderdetail',[$v->id])}}" target="_blank"><button type="button" class="btn btn-info btn-rad btn-xs btn-flat md-trigger" data-modal="detail">订单详情</button></a>

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
                    $('#datatable-icons').dataTable({
                        "bPaginate": false,
                        "bInfo":false,
                        "bFilter":false,
                    });
                    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
                    $('.dataTables_length select').addClass('form-control');
                    $(".pull-right").eq(1).html(`{{$list->links()}}`);
                })
            </script>
@endsection