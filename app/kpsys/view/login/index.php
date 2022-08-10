<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>后台管理系统</title>
		<meta name="renderer" content="bew">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css">
		<link rel="stylesheet" type="text/css" href="/static/bews/css/login.css">
		<link rel="icon" href="//common.jxnews.com.cn/sys/jxnews.ico" type="image/x-icon" />
		<script type="text/javascript" src="/static/layui/layui.js"></script>
	</head>
	<body>
		<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">
			<div class="layadmin-user-login-main">
				<div class="layadmin-user-login-box layadmin-user-login-header">
					<img src="/static/bews/images/jxnews.jpeg"/>
					<h2>考评系统</h2>
				</div>
				<div class="layadmin-user-login-box layadmin-user-login-body layui-form">
					<form class="layui-form login-form">
						<!-- 用户名 -->
						<div class="layui-form-item">
							<label class="layadmin-user-login-icon layui-icon layui-icon-username" for="username"></label>
							<input type="text" id="username" name="username" placeholder="用户名" class="layui-input">
						</div>

						<!-- 密码 -->
						<div class="layui-form-item">
							<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="password"></label>
							<input type="password" name="password" class="layui-input" placeholder="密码" class="layui-input">
						</div>

						<!-- 验证码 -->
						<div class="layui-form-item">
							<div class="layui-row">
								<div class="layui-col-xs7">
									<label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="captcha"></label>
									<input type="text" name="captcha" placeholder="图形验证码" class="layui-input">
								</div>
								<div class="layui-col-xs5">
									<div style="margin-left:10px;">
										<img src="{:captcha_src()}" class="layadmin-user-login-codeimg" onclick="reloadImg()" id="img">
									</div>
								</div>
							</div>
						</div>

						<!-- 是否记住密码 -->
						<!-- 此功能没做 -->
						<div class="layui-form-item" style="margin-bottom: 20px;">
							<input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
						</div>
					</form>

					<!-- 登录按钮 -->
					<div class="layui-form-item">
						<button class="layui-btn layui-btn-fluid" onclick="login()">登 陆</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	layui.use(['layer','form'],function(){
		var form = layui.form;
		layer = layui.layer;
		$ = layui.jquery;
		// 用户名控件获取焦点
		$('#account').focus();
	});

	// 验证码图片点击刷新方法
	function reloadImg(){
		$("#img").attr('src', '{:captcha_src()}?rand=' + Math.random());
	};
	
	// 登录按钮点击方法
	function login(){
		$.post(
			'/index.php/kpsys/Login/login',
			$('form').serialize(),
			(result) => {
				switch (result.code) {
					case 0:// 成功
						layer.msg(result.msg, {'icon' : 1});
						setTimeout(()=>{window.location.href='/index.php/kpsys/index'}, 1000);
						break;

					case 1:// 失败
						layer.msg(result.msg, { 'icon' : 2 });
						reloadImg();
						break;
				
					default:
						break;
				}
			},
			'json'
		);
	}
</script>