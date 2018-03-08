@extends('app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center">
            <h1 style="">研发中心笔试题-某公司晚会购票DEMO系统</h1>
        </div>
        <div class="panel-body">
            @if(count($user_seats)<20)
                <a type="button" class="btn btn-primary" href="/">返回继续购买晚会票</a>
            @else
                <div>对不起，您已经购买超过了20张晚会票，无法再继续购买</div>
            @endif
            @if(!empty($user_seats))
                <h1>尊敬的用户您好,<br />您所使用的邮箱{{$email}}已购得以下晚会票，<br /></h1>
                <table class="table">
                    <thead>
                    <tr>
                        <th>区域</th>
                        <th>排数</th>
                        <th>座位号</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user_seats as $seat)
                        <tr>
                            <td>{{$seat[0]}}</td>
                            <td>第{{$seat[1]}}排</td>
                            <td>{{$seat[2]}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h1>对不起，您未购买任何晚会票</h1>
            @endif
            <h1>剧场地图一览</h1>
            <img src="{{URL::asset('/map.png')}}" style="width: 50%">
        </div>
    </div>
@endsection