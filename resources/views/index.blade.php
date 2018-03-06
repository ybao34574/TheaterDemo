<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>研发中心笔试题DEMO</title>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center">
        <h1 style="">研发中心笔试题DEMO</h1>
    </div>
    <div class="panel-body">
        <form action="/" role="form" style="margin-left: 40%;margin-right: 40%" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group">
                <label for="email">姓名</label>
                <input class="form-control" type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">邮箱</label>
                <input class="form-control" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="ticket">预购买票数量</label>
                <select class="form-control" name="tickets" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
    </div>
</div>
</body>
</html>