<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>大江网考评系统</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" media="all">
	<link rel="stylesheet" type="text/css" href="/static/bews/css/index.css" media="all">
	<link rel="icon" href="//common.jxnews.com.cn/sys/jxnews.ico" type="image/x-icon" />
	<script type="text/javascript" src="/static/layui/layui.js"></script>
	<script type="text/javascript" src="/static/bews/js/admin.js"></script>
	<style>
		.layadmin-side-shrink .layui-layout-admin .layui-logo {
			width: 60px;
			background-image:url("/static/bews/images/jxnews32.jpeg");
		}
	</style>
</head>
<body layadmin-themealias="default" class="layui-layout-body">
	<div id="LAY_app" class="layadmin-tabspage-none">
		<div class="layui-layout layui-layout-admin">
			<div class="layui-header">
				<!-- 头部区域 -->
				<ul class="layui-nav layui-layout-left">
					<li class="layui-nav-item layadmin-flexible" lay-unselect onclick="shrink()">
						<a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
							<i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
						</a>
					</li>
				</ul>
				<ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
					<li class="layui-nav-item layui-hide-xs" lay-unselect title="全屏" onclick="fullScreen()">
						<a href="javascript:;" layadmin-event="fullscreen">
							<i class="layui-icon layui-icon-screen-full"></i>
						</a>
					</li>
					<li class="layui-nav-item" lay-unselect>
						<a href="javascript:;">
							<cite>{$user['username']}</cite>
						</a>
						<dl class="layui-nav-child">
							<dd><a lay-href="">个人中心</a></dd>
							<hr>
							<dd layadmin-event="logout" style="text-align:center;" onclick="logout()">
								<a>退出</a>
							</dd>
						</dl>
					</li>
				</ul>
			</div>
			<!-- 侧边菜单 -->
			<div class="layui-side layui-side-menu">
				<div class="layui-side-scroll">
					<div class="layui-logo" lay-href="">
						<span>大江网考评系统</span>
					</div>
					<ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
						<li data-name="" data-jump="" class="layui-nav-item">
							<a href="javascript:;" lay-tips="考评管理" lay-direction="2">
								<i class="layui-icon layui-icons layui-icon-circle-dot"></i>
								<cite>考评管理</cite>
							</a>
							<dl class="layui-nav-child">
								<dd data-name="" data-jump="/">
									<a href="javascript:;" onclick="menuFire('/index.php/kpsys/KaopingManage')">
										<i class="layui-icon layui-icons layui-icon-form"></i>本人考评
									</a>
								</dd>
								<dd data-name="" data-jump="/">
									<a href="javascript:;" onclick="menuFire('/index.php/kpsys/DepartmentMember')">
										<i class="layui-icon layui-icons layui-icon-list"></i>所有部门人员
									</a>
								</dd>
								<dd data-name="" data-jump="/">
									<a href="javascript:;" onclick="menuFire('')">
										<i class="layui-icon layui-icons layui-icon-list"></i>查看当月考评
									</a>
								</dd>
								<dd data-name="" data-jump="/">  
									<a href="javascript:;" onclick="menuFire('')">
										<i class="layui-icon layui-icons layui-icon-date"></i>历史考评查询
									</a>
								</dd>
							</dl>
						</li>
						<li data-name="" data-jump="" class="layui-nav-item">
							<a href="javascript:;" lay-tips="个人管理" lay-direction="2">
								<i class="layui-icon layui-icons layui-icon-circle-dot"></i>
								<cite>个人管理</cite>
							</a>
							<dl class="layui-nav-child">
								<dd data-name="" data-jump="/">
                                    <a href="javascript:;" onclick="menuFire('')">
                                        <i class="layui-icon layui-icons layui-icon-username"></i>用户: {$user['username']}
									</a>
								</dd>
								<dd>
                                    <a href="javascript:;" onclick="menuFire('')">
										<i class="layui-icon layui-icons layui-icon-password"></i>修改密码
									</a>
								</dd>
							</dl>
						</li>
					</ul>
				</div>
			</div>
			<!-- 主体内容 -->
			<div class="layui-body" id="LAY_app_body">
				<div class="layadmin-tabsbody-item layui-show">
					<div class="layui-fluid">
						<div class="layui-card">
							<iframe src="/index.php/kpsys/index/welcome" style="width:100%;height:100%;" frameborder="0" scrolling="0"></iframe>
						</div>
					</div>
				</div>
			</div>
			<!-- 辅助元素，一般用于移动设备下遮罩 -->
			<div class="layadmin-body-shade" layadmin-event="shade" onclick="shrink()"></div>
		</div>
	</div>
	<!-- 辅助元素，一般用于移动设备下遮罩 -->
	<div class="layadmin-body-shade" layadmin-event="shade"></div>
	</div></div>

	<script type="text/javascript">
		layui.use(['element','layer','jquery'], function(){
			element = layui.element;
			$ = layui.jquery;
			layer = layui.layer;
			setter = layui.setter;
			resetMainHeight($("iframe"));
		});

		// 重新设置主操作页面高度
		function resetMainHeight(obj){
			var height = parent.document.documentElement.clientHeight - 80;
			$(obj).parent('div').height(height);
		}

		// 菜单点击
		function menuFire(obj){
			$('iframe').attr('src',obj);
			var width = screen();
			if(width < 2){
				shrink();
			}
		}
        
        // 退出方法
        function logout(){
            layer.confirm(
                '确定要推出吗?',
                { icon:3, btn:['确定','取消'] },
                () => {$.get(
                    '/index.php/kpsys/Login/logout',
                    (res) => {
                        if(res.code == 0){
                            layer.msg(res.msg, {'icon':1});
                            setTimeout(
                                () => {window.location.href = '/index.php/kpsys/Login/index'},
                                1000
                            );
                        }else{
                            layer.msg(res.msg, {'icon':2});
                        }
                    },
                    'json'
                )}
            )
        }
	</script>
</body>
</html>