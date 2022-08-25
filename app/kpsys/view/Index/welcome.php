<!DOCTYPE html>
<html>

<head>
	<title>欢迎</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" media="all">
	<script type="text/javascript" src="/static/layui/layui.js"></script>
</head>

<body>
	<div class="layui-fluid">
		<div class="layui-row">
			<div class="layui-col-xs6">
				<h1>欢迎使用大江网考评系统<h1>
						<div style="font-size: 80px;">Hi~ o(*￣▽￣*)ブ</div>
						<ul class="layui-timeline" id="main">
						</ul>
			</div>
			<div class="layui-col-xs6">
				<div class="layui-pane" style="position: fixed">
					<div class="layui-form layui-form-pane">
						<div class="layui-form-item">
							<div class="layui-inline">
								<label class="layui-form-label">日期</label>
								<div class="layui-input-inline">
									<input type="text" class="layui-input" id="dateCalendar">
								</div>
								<div class="layui-input-inline">
									<label class="layui-form-label">部门</label>
									<select name="quiz1">
										<option value="">请选择省</option>
										<option value="浙江" selected="">浙江省</option>
										<option value="你的工号">江西省</option>
										<option value="你最喜欢的老师">福建省</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>

<script>
	var num = 0;
	var today = '<?php echo date('Y-m-d', strtotime('today'))?>';
	var minDate = '<?php echo date('Y-m-d', strtotime('today - 29 days'))?>';
	async function populates() {
		while (num < 30) {
			// // document bottom
			// let windowRelativeBottom = document.documentElement.getBoundingClientRect().bottom;

			// // if the user hasn't scrolled far enough (>100px to the end)
			// if (windowRelativeBottom > document.documentElement.clientHeight + 100) break;

			// let's add more data
			// we need to use promise to avoid while loop bug
			await new Promise((resolve, reject) => {
				layui.use(['jquery', 'laydate'], () => {
					var $ = layui.jquery;
					var laydate = layui.laydate;
					$.ajax({
						url: '/index.php/kpsys/Index/timeline',
						type: 'post',
						async: false,
						contentType: 'json',
						data: JSON.stringify({
							date: `today - ${num++} days`,
						}),
						dataType: 'json',
						success: (data, textStatus) => {
							// add data to main timeline
							$('#main').append(data.template);
							resolve('done');
						},
						error: (XMLHttpRequest, textStatus, errorThrown) => {
							reject(new Error('wrong'));
						}
					})
				})
			});
		}
	}

	window.addEventListener('scroll', function() {
		populates();
	});

	populates();

	layui.use('laydate', () => {
		var laydate = layui.laydate;

		var startDate = laydate.render({
			elem: '#dateCalendar',
			position: 'fixed',
			calendar: true,
			value: today,
			max: today,
			min: minDate,
			done: (value, date) => {
				windowRelativeTop = document.documentElement.getBoundingClientRect().top;
				divpos = document.getElementById(value).getBoundingClientRect().top;

				console.log('divpos: '+divpos);
				console.log('windowRelativetop: ' + windowRelativeTop);

				window.scrollTo({
					top: divpos - windowRelativeTop,
					left: 0,
					behavior: 'smooth'
				});
			}
		})
	});

	// layui.use('layer', ()=>{
	// 	layer = layui.layer;

	// 	layer.open({
	// 		type: 1,
	// 		title: '目录',
	// 		content: '<ul><li>好</li></ul>'
	// 	})
	// })
	// layui.use('laydate', ()=>{
	// 	var laydate = layui.laydate;

	// 	laydate.render({
	// 		elem: '#calendar',
	// 		position: 'static'
	// 	})
	// })
</script>