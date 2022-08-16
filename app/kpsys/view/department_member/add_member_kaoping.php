<!DOCTYPE html>
<html>

<head>
	<title>{$member.username}的添加考评</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" media="all">
	<script type="text/javascript" src="/static/layui/layui.js"></script>
</head>

<body style="padding:10px; box-sizing: border-box;">
	<form class="layui-form">
		<div class="layui-form-item">
			<div class="layui-inline">
				<label class="layui-form-label">日期</label>
				<div class="layui-input-block">
					<input type="text" class="layui-input" placeholder="yyyy-MM-dd" id="date" name="time" lay-verify="required">
				</div>
			</div>
		</div>

		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">工作内容</label>
			<div class="layui-input-block">
				<textarea placeholder="请输入内容" class="layui-textarea" lay-verify="required" name="content"></textarea>
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">补充内容</label>
			<div class="layui-input-block">
				<textarea placeholder="请输入内容" class="layui-textarea" name="beizhu"></textarea>
			</div>
		</div>
        
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">分值</label>
                <div class="layui-input-inline">
                    <input class="layui-input" type="number" name="score" value="0">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">奖惩</label>
                <div class="layui-input-inline">
                    <input class="layui-input" type="number" name="reward" value="0">
                </div>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
			<label class="layui-form-label">打分备注</label>
			<div class="layui-input-block">
				<textarea placeholder="请输入内容" class="layui-textarea" name="note"></textarea>
			</div>
		</div>

		<input type="hidden" name="mid" value="{$member.id}">
		<input type="hidden" name="did" value="{$member.department}">
		<input type="hidden" name="uname" value="{$member.username}">

		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
			</div>
		</div>
	</form>
</body>

</html>

<script type="text/javascript">
    layui.use('laydate', function() {
				var laydate = layui.laydate;
				//常规用法
				laydate.render({
					elem: '#date',
					min: -7,
					max: 0,
					value: new Date().toJSON().slice(0, 10),
					isInitValue: true
				});
			})

    /**
	 * from post
	 */
	layui.use(['form', 'layer'], function() {
		var form = layui.form;
		var $ = layui.$;
		var layer = layui.layer;

		form.on('submit(*)', function(data) {
			$.ajax({
				url: '/index.php/kpsys/DepartmentMember/addMemberKaopingFormPost',
				type: 'post', 									
				dataTyep: 'json', 
				contentType: 'application/json',
				data: JSON.stringify(data.field),
				success: (responseData) => {
					console.log(responseData);
					switch (responseData.code) {
						case 0: // 成功
							layer.msg(responseData.msg, {'icon':1});
							setTimeout(() => {	
								parent.window.location.reload();
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
					console.log('ajax请求失败');
					layer.msg('ajax请求失败: ' + textStatus, {'icon':2});
				}
			});
			return false;
		})
	});
</script>