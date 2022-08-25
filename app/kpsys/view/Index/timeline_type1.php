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
                        </li>
                    {/if}
                {/volist}
            {/if}
        </ul>
    </div>
</li>