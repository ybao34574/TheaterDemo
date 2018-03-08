@extends('app')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-warning alert-dismissable" style="margin-top: 5%">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center">
            <h1 style="">研发中心笔试题-某公司晚会购票DEMO系统</h1>
        </div>
        <div class="panel-body">
            <form action="/" role="form" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group col-md-4">
                    <label for="email">姓名</label>
                    <input class="form-control" type="text" name="name" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="email">邮箱</label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="ticket">预购买票数量</label>
                    <select class="form-control" name="tickets" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-default" name="search" value="search">查询我的晚会票</button>
                <button type="submit" class="btn btn-default" name="submit" value="submit">假设支付完成下一步</button>
                <button type="submit" class="btn btn-default" name="wexin" value="submit" disabled>微信支付</button>
                <button type="submit" class="btn btn-default" name="zhifubao" value="submit" disabled>支付宝</button>
            </form>
        </div>
    </div>
@endsection