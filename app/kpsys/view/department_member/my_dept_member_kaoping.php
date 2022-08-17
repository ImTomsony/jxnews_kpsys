<!-- 需要用到的一些变量 -->
<?php
    $lastWeek = strtotime('today - 1 week'); // 
?>

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
    <style type="text/css">
			.header span{background:#009688;margin-left:30px;padding:10px;color:#ffffff;}
			.header div{border-bottom:solid 2px #009688;margin-top: 8px;}
		</style>
</head>

<body style="padding:10px; box-sizing: border-box;">
    <div class="header">
        <span>{$member.username}的考评列表</span>
        <div></div>
    </div>
    <script type="text/html" id="toolbar">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-xs" onclick="add()">
				<i class="layui-icon layui-icon-add-1"></i>增
			</button>
            <button class="layui-btn layui-btn-xs layui-bg-red" onclick="">
				</i>批量报送 还没做
			</button>
        </div>
    </script>
    <table id="demo" lay-filter="test" lay-size="sm">
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
            {volist name='list' id='vo' key='k'}
                <tr>
                    <td></td>
                    <td>{$k}</td>
                    <td>{$vo.time}</td>
                    <td>{$vo.content}</td>
                    <td>{$vo.beizhu}</td>
                    <td>{$vo.score}</td>
                    <td>{$vo.reward}</td>
                    <td>{$vo.note}</td>
                    {if $vo.tag == 1}
                        <td>
                            <div class="layui-bg-green">已报送</div>
                        </td>
                    {else/}
                        {if strtotime($vo.time) >= $lastWeek}
                            <td>
                                <button class="layui-btn layui-btn-xs laui-bg-blue" onclick="grade('{$vo.id}')">打分</button>
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

    /**
	 * 增删改查 之 增
	 */
	function add(){
		layer.open({
			type:2,
			title:"{$member.username}的添加考评",
			area: ['700px', '580px'],
			content: '/index.php/kpsys/DepartmentMember/addMemberKaoping/mid/{$member.id}'
		})
	}

    /**
     * 给已有考评打分 类似于怎删改查之改
     */
    function grade(kaopingId){
        layer.open({
			type:2,
			title:"{$member.username}的考评",
			area: ['700px', '580px'],
			content: `/index.php/kpsys/DepartmentMember/gradeMemberKaoping/kaopingId/${kaopingId}`
		})
    }
</script>