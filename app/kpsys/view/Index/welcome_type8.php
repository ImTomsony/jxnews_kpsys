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
			<div class="layui-col-xs7">
				<h1>欢迎使用大江网考评系统<h1>
						<div style="font-size: 80px;">Hi~ o(*￣▽￣*)ブ</div>
						<ul class="layui-timeline" id="main">
						</ul>
			</div>
			<div class="layui-col-xs5">
				<div class="layui-pane" style="position: fixed">
					<fieldset class="layui-elem-field layui-field-title">
						<legend>查看考评</legend>
					</fieldset>
					<div class="layui-form layui-form-pane">
						<div class="layui-form-item">
							<div class="layui-inline">
								<label class="layui-form-label">日期</label>
								<div class="layui-input-inline">
									<input type="text" class="layui-input" id="dateCalendar">
								</div>
							</div>
							<div class="layui-inline">
								<label class="layui-form-label">部门</label>
								<div class="layui-input-inline">
									<select id="departmentSelection" onchange="deptSelectionChange(this)">
										<option value="0" selected>所有部门</option>
                                        {volist name="$departmentList" id="department"}
                                            <option value="{$department.deptid}">{$department.deptname}</option>
                                        {/volist}
									</select>
								</div>
							</div>
						</div>
					</div>
					<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
						<legend>功能</legend>
					</fieldset>
					<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
						<ul class="layui-tab-title">
							<li class="layui-this">添加考评</li>
						</ul>
						<div class="layui-tab-content" style="height: 100px;">
							<div class="layui-tab-item layui-show">
								<form class="layui-form" id="addKaopingForm">
									<div class="layui-form-item">
										<div class="layui-inline">
											<label class="layui-form-label">日期</label>
											<div class="layui-input-block">
												<input type="text" class="layui-input" placeholder="yyyy-MM-dd" id="date" name="time" lay-verify="required">
											</div>
										</div>
									</div>
									<script>
										// 初始化laydate
										layui.use('laydate', function() {
											var laydate = layui.laydate;
											laydate.render({
												elem: '#date',
												min: <?php if($user['dfdays']){echo -$user['dfdays'] + 1;}else{echo -1;};  ?>,
												max: 0,
												value: new Date().toJSON().slice(0, 10),
												isInitValue: true
											});
										})
									</script>
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

									<input type="hidden" name="mid" value="{$user.id}">
									<input type="hidden" name="did" value="{$user.department}">
									<input type="hidden" name="uname" value="{$user.username}">

									<div class="layui-form-item">
										<div class="layui-input-block">
											<button type="button" class="layui-btn" lay-filter="submitNewKaoping" id="submitNewKaoping" lay-submit>立即提交</button>
											<button type="reset" class="layui-btn layui-btn-primary">重置</button>
										</div>
									</div>
									<script>
										/**
										 * 表单提交
										 * 功能包括：提交不刷新整个界面，只刷新局部天的li，然后自动滚到位置
										 */
										layui.use(['form', 'layer'], () => {
											var form = layui.form;
											var $ = layui.jquery;
											var layer = layui.layer;

											form.on('submit(submitNewKaoping)', data => {
												$.ajax({
													url: '/index.php/kpsys/KaopingManage/timelineAddKaoping',
													type: 'post',
													async: true,
													contentType: 'json',
													data: JSON.stringify(data.field),
													dataType: 'json',
													success: (responseData, textStatus) => {
														layer.msg(responseData.msg, {'icon':1}) // 提示框
														reloadTimeLine(data.field.time); // 局部刷新
														myScrollTo(data.field.time); // 滚动
														document.getElementById("addKaopingForm").reset(); // 重置
														layui.use('laydate', function() {
															var laydate = layui.laydate;
															laydate.render({
																elem: '#date',
																min: -1,
																max: 0,
																value: new Date().toJSON().slice(0, 10),
																isInitValue: true
															});
														})
													},
													error: (XMLHttpRequest, textStatus, errorThrown) => {
														
													}
												});

												return false; // 整体界面不刷新
											})
										})
									</script>
								</form>
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
	var minDate = '<?php echo date('Y-m-d', strtotime('today - 99 days'))?>';
	async function populates() {
		while (num < 100) {
			// // document bottom
			// let windowRelativeBottom = document.documentElement.getBoundingClientRect().bottom;

			// // if the user hasn't scrolled far enough (>100px to the end)
			// if (windowRelativeBottom > document.documentElement.clientHeight + 100) break;

			// let's add more data
			// we need to use promise to avoid while loop bug
			
			await new Promise((resolve, reject) => {
				layui.use(['jquery'], () => {
					let $ = layui.jquery;
					$.ajax({
						url: '/index.php/kpsys/Index/timeline',
						type: 'post',
						async: true,
						contentType: 'json',
						data: JSON.stringify({
							date: `today - ${num++} days`,
							department: $('#departmentSelection :selected').val()
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

	// window.addEventListener('scroll', function() {
	// 	populates();
	// });

	populates();

	layui.use('laydate', () => {
		let laydate = layui.laydate;

		let startDate = laydate.render({
			elem: '#dateCalendar',
			position: 'fixed',
			calendar: true,
			value: today,
			max: today,
			min: minDate,
			done: (value, date) => {
				myScrollTo(value);
			}
		})
	});

	/**
	 * 滚到你想要滚到的地方
	 */
	function myScrollTo(elementId){
		let windowRelativeTop = document.documentElement.getBoundingClientRect().top;
		let divTop = document.getElementById(elementId).getBoundingClientRect().top;

		window.scrollTo({
			top: divTop - windowRelativeTop,
			left: 0,
			behavior: 'smooth'
		});
	}

	/**
	 * 刷新你想刷新的某一天
	 */
	function reloadTimeLine(date){
		layui.use('jquery', () => {
			let $ = layui.jquery;

			$.ajax({
				url: '/index.php/kpsys/Index/timeline',
				type: 'post',
				async: true,
				contentType: 'json',
				data: JSON.stringify({
					date: date,
				}),
				dataType: 'json',
				success: (data, textStatus) => {
					// replaceWith data to main timeline
					$('#' + date + '-li').replaceWith(data.template);
				},
				error: (XMLHttpRequest, textStatus, errorThrown) => {

				}
			})
		})
	}

    function deptSelectionChange(selectedDept){
        console.log(selectedDept.value);
    }
</script>