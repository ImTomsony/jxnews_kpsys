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

<body >
    <!-- 首先需要打印出所有的部门 -->
    <div class="layui-fluid">
        <div class="layui-row">
            {volist name="departmentList" id="dept" key="k"}
                <!-- 在下面的div中的style属性嵌套php代码，实现user所在部门的边框为solid -->
                <div class="layui-col-xs1" style="width: 235px; margin: 5px; <?php if($dept['deptid'] == app('request')->session('userDept_id')) echo 'border: 2px solid'; ?>">
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>{$dept.deptname}</legend>
                    </fieldset>
                    <!-- 然后把部门下的所有员工打印出来 -->
                    <table class="layui-table" lay-size="sm" lay-filter="demo">
                        <thead>
                            <tr>
                                <th lay-data="{field:'k', sort:true, width:70, align:'center'}">序号</th>
                                <th lay-data="{field:'time', sort:true, minWidth:70, align:'center'}">姓名</th>
                                <th lay-data="{field:'operation', sort:true, width:70, align:'center'}">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            {volist name='$dept.memberList' id='member' key='kk'}
                                <tr>
                                    <td>{$kk}</td>
                                    <td>{$member.username}</td>
                                    <td>
                                        <button class="layui-btn layui-btn-xs <?php if($member['id'] == app('request')->session('user_id')) {echo 'layui-bg-red';} else {echo 'layui-bg-cyan';} ?>" onclick="search('{$member.id}')">
                                            <i class="layui-icon layui-icon-search "></i>查
                                        </button>
                                    </td>
                                </tr>
                            {/volist}
                        </tbody>
                    </table>
                </div>
            {/volist}
        </div>
    </div>
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
            height: 340,
            limit: 100000,
            even: true,
		});
	})

    function search(mid){
        var zIndex = layer.open({
            type: 2,
            content: `/index.php/kpsys/DepartmentMember/memberKaoping/mid/${mid}`,
            maxmin: true,
            area: ['1240px', '810px']
        });
        // layer.full(zIndex);
    }
</script>