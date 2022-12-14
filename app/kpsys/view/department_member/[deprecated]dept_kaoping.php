<!-- 需要用到的一些变量 -->
<?php
    $lastWeek = strtotime('today - 1 week'); // 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>所在部门考评</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" media="all">
    <script type="text/javascript" src="/static/layui/layui.js"></script>
</head>

<body style="padding:10px; box-sizing: border-box;">
    {volist name="memberList" id="member" key="k"}
        <script type="text/html" id="{$member.id}-toolbar">
            <span>{$member.username}的考评列表</span>
            <span class="layui-btn-container">
                <button class="layui-btn layui-btn-xs" onclick="add()">
                    <i class="layui-icon layui-icon-add-1"></i>增
                </button>
                <button class="layui-btn layui-btn-xs layui-bg-red" onclick="">
                    </i>批量报送 还没做
                </button>
            </span>
        </script>
        <table id="{$member.id}-tableId" lay-filter="{$member.id}-tableId" lay-size="sm">
            <thead>
                <tr>
                    <th lay-data="{type: 'checkbox'}"></th>
                    <th lay-data="{field:'k', sort:true, width:69, align:'center'}">序号</th>
                    <th lay-data="{field:'time', sort:true, width:92}">日期</th>
                    <th lay-data="{field:'content', sort:true, minWidth:400}">工作内容</th>
                    <th lay-data="{field:'beizhu', width:78}">补充内容</th>
                    <th lay-data="{field:'score', sort:true, width:69, align:'center'}">分值</th>
                    <th lay-data="{field:'reward', sort:true, width:69, align:'center'}">奖惩</th>
                    <th lay-data="{field:'reward_note', width:78}">打分备注</th>
                    <th lay-data="{field:'operation', sort:true, width:130, align:'center'}">操作</th>
                </tr>
            </thead>
            <tbody>
                {volist name="member.kaopingList" id="kaoping" key="kk"}
                    <tr>
                        <td></td>
                        <td>{$kk}</td>
                        <td>{$kaoping.time}</td>
                        <td>{$kaoping.content}</td>
                        <td>{$kaoping.beizhu}</td>
                        <td>{$kaoping.score}</td>
                        <td>{$kaoping.reward}</td>
                        <td>{$kaoping.note}</td>
                        {if $kaoping.tag == 1}
                            <td>
                                <div class="layui-bg-green">已报送</div>
                            </td>
                        {else/}
                            {if strtotime($kaoping.time) >= $lastWeek}
                                <td>
                                    <button class="layui-btn layui-btn-xs laui-bg-blue" onclick="grade('{$kaoping.id}')">打分</button>
                                    <button class="layui-btn layui-btn-xs layui-bg-red">报送</button>
                                </td>
                            {else/}
                                <td>
                                    <div class="layui-bg-orange">未报送-已过期</div>
                                </td>
                            {/if}
                        {/if}
                    </tr>
                {/volist}
            </tbody>
        </table> 
        <script>
            layui.use('table', function(){
                var table = layui.table;

                table.init('{$member.id}-tableId', {
                    limit: 20,
                    limits: [10,20,50,100,500,1000,100000000],
                    page: true,
                    toolbar: '#{$member.id}-toolbar',
                    even: true,
                })
            })
        </script>
    {/volist}
</body>

</html>

<script>
    layui.use('laydate', ()=>{
        var laydate = layui.laydate;

        //日期范围
        laydate.render({
            elem: '#test6'
            ,type: 'date'
            ,range: ['#test-startDate-1', '#test-endDate-1']
        });
    })
</script>

