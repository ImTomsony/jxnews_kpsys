<li class="layui-timeline-item" id="{$dateList.date}-li">
    <i class="layui-icon layui-icon-circle layui-timeline-axis"></i>
    <div class="layui-timeline-content layui-text">
        <h3 class="layui-timeline-title">
            <a style="color:black" href="javascript:;" id="{$dateList.date}">{$dateList.date}</a>
            <!-- <script>
                layui.use(['dropdown'], ()=>{
                    var dropdown = layui.dropdown;

                    dropdown.render({
                        elem: '#{$dateList.date}',
                        data: [
                            {title: 'menu item11', id: 100},
                            {title: 'menu item12', id: 101},
                            {title: 'menu item13', id: 102},
                        ]
                    })
                })
            </script> -->
            <span class="layui-badge-rim">{$dateList.dateKaopingCounts}条考评</span>
        </h3>
        <ul>
            {if $dateList.dateKaopingCounts != 0}
                {volist name="$dateList.departments" id="department"}
                    {if $department.deptKaopingCounts != 0}
                        <li>
                            <h2>
                                <a style="color:black" href="javascript:;">{$department.deptname}</a>
                                <span class="layui-badge-rim">{$department.deptKaopingCounts}条考评</span>
                            </h2>
                            <ul>
                                {volist name="$department.memberList" id="member"}
                                    {if $member.memberKaopingCounts != 0}
                                        <li>
                                            <h3>
                                                <a style="color:black" href="javascript:;" id="{$dateList.date . '-' . $member.id}">{$member.username}</a>
                                                <span class="layui-badge-rim">{$member.memberKaopingCounts}条考评</span>
                                            </h3>
                                            <ul id="{$dateList.date . '-' . $member.id . '-' . 'ul'}">
                                                {volist name="$member.kaopingList" id="kaoping"}
                                                    <li>
                                                        <h4>
                                                            <a style="color:black" href="javascript:;" id="{$kaoping.id}">{$kaoping.content}</a>
                                                            {if $member.id == $Request.session.user_id && $kaoping.tag != 1}
                                                                <script>
                                                                    // layui dropdown for editing kaoping
                                                                    layui.use(['dropdown', 'form', 'layer'], ()=>{
                                                                        let dropdown = layui.dropdown;
                                                                        let $ = layui.jquery;
                                                                        let form = layui.form;
                                                                        let layer = layui.layer;

                                                                        dropdown.render({
                                                                            elem: '#{$kaoping.id}',
                                                                            trigger: 'click',
                                                                            delay: 0,
                                                                            align: 'right',
                                                                            content: 
                                                                                '<form class="layui-form layui-form-pane" style="width: 400px">'+
                                                                                    '<div class="layui-form-item layui-form-text">'+
                                                                                        '<label class="layui-form-label">修改工作内容</label>'+
                                                                                        '<div class="layui-input-block">'+
                                                                                            '<textarea placeholder="请输入内容" class="layui-textarea" lay-verify="required" name="content">{$kaoping.content}</textarea>'+
                                                                                        '</div>'+
                                                                                    '</div>'+
                                                                                    '<div class="layui-form-item layui-form-text">'+
                                                                                        '<label class="layui-form-label">修改补充内容</label>'+
                                                                                        '<div class="layui-input-block">'+
                                                                                            '<textarea placeholder="请输入内容" class="layui-textarea" name="beizhu">{$kaoping.beizhu}</textarea>'+
                                                                                        '</div>'+
                                                                                    '</div>'+
                                                                                    '<input type="hidden" name="id" value="{$kaoping.id}">'+
                                                                                    '<input type="hidden" name="time" value="{$kaoping.time}">'+
                                                                                    '<div class="layui-form-item">'+
                                                                                        '<div class="layui-input-block">'+
                                                                                            '<button type="reset" class="layui-btn layui-btn-primary">重置</button>'+
                                                                                            '<button type="button" class="layui-btn" lay-filter="submitEditKaoping" id="submitEditKaoping" lay-submit>提交修改</button>'+
                                                                                            '<button type="button" class="layui-btn layui-btn-danger" onclick="timelineDeleteKaoping({$kaoping.id}, \'{$kaoping.time}\')">删除考评</button>'+
                                                                                        '</div>'+
                                                                                    '</div>'+
                                                                                '</form>'
                                                                        })                                                                

                                                                        form.on('submit(submitEditKaoping)', data => {
                                                                            $.ajax({
                                                                                url: '/index.php/kpsys/KaopingManage/timelineEditKaoping',
                                                                                type: 'post',
                                                                                async: true,
                                                                                contentType: 'json',
                                                                                data: JSON.stringify(data.field),
                                                                                dataType: 'json',
                                                                                success: (responseData, textStatus) => {
                                                                                    layer.msg(responseData.msg, {'icon':1}) // 提示框
                                                                                    reloadTimeLine(data.field.time); // 局部刷新 调用welcome界面的方法
                                                                                    //myScrollTo(data.field.time); // 滚动 调用welcome界面的方法
                                                                                    $('.layui-dropdown').remove();
                                                                                },
                                                                                error: (XMLHttpRequest, textStatus, errorThrown) => {
                                                                                    
                                                                                }
                                                                            });

                                                                            return false; // 整体界面不刷新
                                                                        })
                                                                    })

                                                                    function timelineDeleteKaoping(id, time){
                                                                        layui.use(['jquery'], () => {
                                                                            let $ = layui.jquery;

                                                                            $.ajax({
                                                                                url: '/index.php/kpsys/KaopingManage/timelineDeleteKaoping',
                                                                                type: 'post',
                                                                                async: true,
                                                                                contentType: 'json',
                                                                                data: JSON.stringify({id: id}),
                                                                                dataType: 'json',
                                                                                success: (responseData, textStatus) => {
                                                                                    layer.msg(responseData.msg, {'icon':1}) // 提示框
                                                                                    reloadTimeLine(time); // 局部刷新 调用welcome界面的方法
                                                                                    //myScrollTo(time); // 滚动 调用welcome界面的方法
                                                                                    $('.layui-dropdown').remove();
                                                                                },
                                                                                error: (XMLHttpRequest, textStatus, errorThrown) => {
                                                                                    
                                                                                }
                                                                            });
                                                                        })
                                                                    }
                                                                </script>
                                                            {else/}
                                                                <script>
                                                                     layui.use(['dropdown'], ()=>{
                                                                        var dropdown = layui.dropdown;

                                                                        dropdown.render({
                                                                            elem: '#{$kaoping.id}',
                                                                            trigger: 'click',
                                                                            delay: 100,
                                                                            align: 'right',
                                                                            content: '<h2>无权限修改<h2>'
                                                                        })
                                                                    })
                                                                </script>
                                                            {/if}
                                                            {if !empty($kaoping.beizhu)}<span class="layui-badge-rim">{$kaoping.beizhu}</span> {/if}
                                                            {if $kaoping.tag == 1}<span class="layui-badge layui-bg-green">已报送</span> {else/}<span class="layui-badge">未报送</span> {/if}
                                                            {if $kaoping.total == 0}<span class="layui-badge">未打分</span> {else/}<span class="layui-badge layui-bg-green">{$kaoping.total}</span> {/if}
                                                            {if !empty($kaoping.note)}<span class="layui-badge-rim">{$kaoping.note}</span> {/if}
                                                        </h4>
                                                    </li>
                                                {/volist}
                                            </ul>
                                        </li>
                                    {/if}
                                {/volist}
                            </ul>
                        </li>
                    {/if}
                {/volist}
            {/if}
        </ul>
    </div>
</li>