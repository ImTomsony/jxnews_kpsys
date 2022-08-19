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
    <style>
    </style>
</head>

<body style="zoom:1">
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">日期 还没做</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="dateRange">
            </div>
        </div>
    </form>

    <ul class="layui-timeline">
        {volist name="dateList" id="date" key="k"}
            <li class="layui-timeline-item">
                <i class="layui-icon layui-icon-circle layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
                    <div class="layui-timeline-title">
                        <h3>{$key}</h3>
                        <ul>
                            {volist name="date" id="member" key="kk"}
                                {if !empty($member.kaoping)}
                                    <li>
                                        <h3>
                                            <a style="color:black" href="javascript:;" onclick="searchMyDeptMember('{$member.id}')">{$key}</a> 
                                            <span class="layui-badge-rim"><?php echo count($member['kaoping']) ?>条考评</span>
                                        </h3>
                                        <ul>
                                            {volist name="member.kaoping" id="kaoping" key="kkk"}
                                                <li>
                                                    <h4 style="color:black">
                                                        <a style="color:black" href="javascript:;" onclick="grade('{$kaoping.id}')">{$kaoping.content}</a> 
                                                        {if $kaoping.tag == 1}<span class="layui-badge layui-bg-green">已报送</span> {else/}<span class="layui-badge">未报送</span> {/if}
                                                        {if $kaoping.total == 0}<span class="layui-badge">未打分</span> {else/}<span class="layui-badge layui-bg-green">{$kaoping.total}</span> {/if}
                                                        {if !empty($kaoping.note)}<span class="layui-badge-rim">{$kaoping.note}</span> {/if}
                                                    </h4>
                                                    <p>{$kaoping.beizhu}</p>
                                                </li>
                                            {/volist}
                                        </ul>
                                    </li>
                                {/if}
                            {/volist}
                        </ul>
                    </div>
                </div>
            </li>
        {/volist}
    </ul>
</body>

</html>

<script>
    layui.use(['layer'], function(){
        $ = layui.jquery;
    })

    layui.use('laydate', function(){
    var laydate = layui.laydate;
    
    //执行一个laydate实例
    laydate.render({
        elem: '#dateRange' //指定元素
    });
    });

    /**
     * 
     */
    function searchMyDeptMember(mid){
        var zIndex = layer.open({
            type: 2,
            content: `/index.php/kpsys/DepartmentMember/MyDeptMemberKaoping/mid/${mid}`,
            maxmin: true,
            shade: 0.3,
            offset: 'rt',
            area:['70%', '100%'],
            cancel: (index, layero) => {
                window.location.reload();// 不能用parent.window.location.reload(); 因为这个layer已经关闭了，parent就直接到外面去了
            }
        });
        layer.title('员工考评详细',zIndex)
    }

    /**
     * 给已有考评打分 类似于怎删改查之改
     */
    function grade(kaopingId){
        layer.open({
            type:2,
            title:"考评",
            offset: 'rb',
            area:['50%', '90%'],
            content: `/index.php/kpsys/DepartmentMember/gradeMemberKaoping/kaopingId/${kaopingId}`
        })
    }
</script>