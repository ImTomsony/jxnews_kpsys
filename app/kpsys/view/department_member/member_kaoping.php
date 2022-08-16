<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>所有部门人员</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" media="all">
    <script type="text/javascript" src="/static/layui/layui.js"></script>
</head>

<body>
    <script type="text/html" id="toolbar">
    </script>
    <table id="demo" lay-filter="test" lay-size="sm">
        <thead>
            <tr>
                <th lay-data="{field:'k', sort:true, width:69, align:'center'}">序号</th>
                <th lay-data="{field:'time', sort:true, width:92}">日期</th>
                <th lay-data="{field:'content', sort:true, minWidth:500}">工作内容</th>
                <th lay-data="{field:'beizhu', sort:true, width:93}">补充内容</th>
                <th lay-data="{field:'score', sort:true, width:69, align:'center'}">分值</th>
                <th lay-data="{field:'reward', sort:true, width:69, align:'center'}">奖惩</th>
                <th lay-data="{field:'reward_note', sort:true, width:93}">打分备注</th>
            </tr>
        </thead>
        <tbody>
            {volist name='list' id='vo' key='k'}
                <tr>
                    <td>{$k}</td>
                    <td>{$vo.time}</td>
                    <td>{$vo.content}</td>
                    <td>{$vo.beizhu}</td>
                    <td>{$vo.score}</td>
                    <td>{$vo.reward}</td>
                    <td>{$vo.note}</td>
                </tr>
            {/volist}
        </tbody>
	</table>
</body>

</html>

<script>
    layui.use('table', function(){
        var table = layui.table;

        table.init('test', {
			limit: 20,
			limits: [10,20,50,100,500,1000,100000000],
			page: true,
			toolbar: '#toolbar',
            even: true,
        })
    })
</script>