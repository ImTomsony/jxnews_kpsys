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
			<div class="layui-col-xs5">
				<h1>欢迎使用大江网考评系统<h1>
				<div style="font-size: 80px;">Hi~ o(*￣▽￣*)ブ</div>
				<ul class="layui-timeline" id="main">
				</ul>
			</div>
			<div class="layui-col-xs7">
				<div class="layui-pane" style="position: fixed">
					<ul id="dateIndex">
						
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>

</html>

<script>
var num = 0;
async function populates(){
	while(true) {
    // document bottom
    let windowRelativeBottom = document.documentElement.getBoundingClientRect().bottom;

    // if the user hasn't scrolled far enough (>100px to the end)
    if (windowRelativeBottom > document.documentElement.clientHeight + 100) break;

    // let's add more data
	// we need to use promise to avoid while loop bug
	await new Promise((resolve, reject) => {
		layui.use(['jquery'], ()=>{
			var $ = layui.jquery;
			$.ajax({
				url: '/index.php/kpsys/Index/timeline',
				type:'post',
				async: false,
				contentType: 'json',
				data: JSON.stringify({
					date: `today - ${num++} days`,
				}),
				dataType:'json',
				success: (data, textStatus) => {
					$('#main').append(data.template); // add data to main timeline
					$('#dateIndex').append(data.date);
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
