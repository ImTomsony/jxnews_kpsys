<li>
    <h4>
        <a style="color:black" href="javascript:;" id="{$kaoping.id}">{$kaoping.content}</a>
        {if $kaoping.tag == 1}<span class="layui-badge layui-bg-green">已报送</span> {else/}<span class="layui-badge">未报送</span> {/if}
        {if $kaoping.total == 0}<span class="layui-badge">未打分</span> {else/}<span class="layui-badge layui-bg-green">{$kaoping.total}</span> {/if}
        {if !empty($kaoping.note)}<span class="layui-badge-rim">{$kaoping.note}</span> {/if}
    </h4>
    <p>{$kaoping.beizhu}</p>
</li>