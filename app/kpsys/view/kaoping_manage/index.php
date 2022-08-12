<!DOCTYPE html>
<html>
	<head>
		<title>管理员列表 - 后台管理系统</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" media="all">
		<script type="text/javascript" src="/static/layui/layui.js"></script>
		<style type="text/css">
			.header span{background:#009688;margin-left:30px;padding:10px;color:#ffffff;}
			.header div{border-bottom:solid 2px #009688;margin-top: 8px;}
			.header button{float:right;margin-top:-5px;}
			.layui-table{height: auto;}
		</style>
	</head>
	<body style="padding:10px; box-sizing: border-box;">
		<div class="header">
			<span>{$user.username}的考评列表</span>
			<div></div>
		</div>

		<!-- 整体思路就是先同过tp6模板的volist遍历打印出真个表格。再通过layui将静态表格转换为动态表格 -->
		
		<!-- 这里是layui模板, 用于表格的toolbar, 文档: https://www.layui.site/demo/table/toolbar.html -->
		<script type="text/html" id="toolbar">
			<div class="layui-btn-container">
				<button class="layui-btn layui-btn-xs" onclick="add()">
					<i class="layui-icon layui-icon-add-1"></i>增
				</button>
				<button class="layui-btn layui-btn-xs layui-bg-black" onclick="search()">
					<i class="layui-icon layui-icon-search "></i>查
				</button>
			</div>
		</script>
		<table class="layui-table" lay-size="sm" lay-filter="demo">
			<thead>
				<tr>
					<th lay-data="{field:'k', sort:true, width:69, align:'center'}">序号</th>
					<th lay-data="{field:'time', sort:true, width:92}">日期</th>
					<th lay-data="{field:'content', sort:true, minWidth:500}">工作内容</th>
					<th lay-data="{field:'beizhu', sort:true, width:150}">补充内容</th>
					<th lay-data="{field:'score', sort:true, width:69, align:'center'}">分值</th>
					<th lay-data="{field:'reward', sort:true, width:69, align:'center'}">奖惩</th>
					<th lay-data="{field:'reward_note', sort:true, width:150}">打分备注</th>
					<th lay-data="{field:'operation', sort:true, width:130, align:'center'}">操作</th>
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
						{if $vo.tag == 0}
						<td>
							<button type="button" class="layui-btn layui-btn-xs layui-btn-normal" onclick="update('{$vo.id}')">
								<i class="layui-icon layui-icon-edit"></i>改
							</button>
							<button type="button" class="layui-btn layui-btn-xs layui-btn-danger" onclick="del('{$vo.id}')">
								<i class="layui-icon layui-icon-delete"></i>删
							</button>
						</td>
						{/if}
					</tr>
				{/volist}
			</tbody>
		</table>
	</body>
</html>

<script>
	layui.use(['layer'], function(){
		$ = layui.jquery;
	})

	/**
	 * 这个是layui table表格静态转换, 开启头部工具栏
	 * 详情请看文档https://www.layui.site/doc/modules/table.html#autoRender
	 */
	layui.use('table', function(){
		var table = layui.table;
		table.init('demo', {
			limit: 20,
			limits: [10,20,50,100,500,1000,100000000],
			page: true,
			toolbar: '#toolbar'
		});
	})

	/**
	 * 增删改查 之 增
	 */
	function add(){
		layer.open({
			type:2,
			title:"添加考评",
			area: ['700px', '450px'],
			content: '/index.php/kpsys/KaopingManage/addKaoping'
		})
	}

	/**
	 * 增删改查 之 查
	 */
	function search(){
		layer.alert('还没做', {icon:5});
	}

	/**
	 * 增删改查 之 改
	 */
	function update(uid){
		layer.open({
			type:2,
			title:"修改考评",
			area: ['700px', '450px'],
			content: `/index.php/kpsys/KaopingManage/editKaoping/id/${uid}`
		})
	}

	/**
	 * 增删改查 之 删
	 */
	function del(uid){
		$.ajax({
				url: '/index.php/kpsys/KaopingManage/deleteKaoping', 
				type: 'post', 									
				dataTyep: 'json', 
				contentType: 'application/json', 
				data: JSON.stringify({id:uid}),
				success: (responseData) => {
					switch (responseData.code) {
						case 0: // 成功
							layer.msg(responseData.msg, {'icon':1});
							setTimeout(() => {	
								window.location.reload();
							}, 0);
							break;

						case 1: // 失败
							layer.msg(responseData.msg, {'icon':2});
							break;

						default:
							break;
					}
				},
				error: (XMLHttpRequest, textStatus, errorThrown) => {
					layer.msg('ajax请求失败: ' + textStatus, {'icon':2});
				}
			});
	}
</script>