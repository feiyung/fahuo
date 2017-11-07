@extends('layouts.master')
@section('title')
    订单详情
@endsection
@section('content')
    <div class="container-fluid">

        <div class="cl-mcont" style="padding: 0">
            <div class="row">


                <div class="col-sm-12 col-md-12 column">



                    <div class="block-flat">
                        <div class="header">
                            <h3>订单详情</h3>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table table-bordered hover" id="datatable-icons" >
                                    <thead>
                                    <tr>
                                        <th style="word-break: keep-all;white-space:nowrap;width: 5%">商品图片</th>
                                        <th style="word-break: keep-all;white-space:nowrap;width: 25%">商品名称</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">商品规格</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">数量</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">是否发货</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">单价（元）</th>
                                        <th style="word-break: keep-all;white-space:nowrap;">小计</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $v)
                                        <tr class="odd gradeX">
                                            <td><img src="http://{{$v->path}}" alt="商品图片" class="img-responsive"></td>
                                            <td>{{$v->product_name}}</td>
                                            <td>{{$v->speac_value}}</td>
                                            <td>{{$v->product_num}}</td>
                                            <td>
                                                @if($v->is_delivery)
                                                    <span>已发货</span>
                                                @else
                                                    <span style="color:red;">未发货</span>
                                                @endif
                                            </td>
                                            <td>&yen;{{number_format($v->product_price)}}</td>
                                            <td>&yen;{{number_format($v->product_price*$v->product_num)}}</td>
                                             @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-sm-12 col-md-12 column">
                    <div class="block-flat">
                        <div class="content">
                            <p style="font-size: 16px;color: #000">收货人：
                                <span style="font-size: 14px;color: #777">{{$addr->reciver_name}}</span>
                            </p>
                            <p style="font-size: 16px;color: #000">电话号码：
                                <span style="font-size: 14px;color: #777"></span>
                            </p>
                            <p style="font-size: 16px;color: #000">邮政编码：
                                <span style="font-size: 14px;color: #777"></span>
                            </p>
                            <p style="font-size: 16px;color: #000">收货地址：
                                <span style="font-size: 14px;color: #777">{{$addr->address}}</span>
                            </p>
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
                "bLengthChange": false,
                "bInfo":false,
                "bFilter":false,
                "bSort": false,
                "iDisplayLength":10
            });
            $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
            $('.dataTables_length select').addClass('form-control');
        })
    </script>
@endsection