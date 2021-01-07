<style>
    .autocompleter-item:hover, .autocompleter-item-selected{
        color: #fff;
        background: #2494f2 !important;
    }
</style>
<form class="layui-form layui-card" action="{{$url}}" data-auto="true" method="post" autocomplete="off">

    <div class="layui-card-body">

        <div class="layui-form-item">
            <label class="layui-form-label label-required-next">上级菜单</label>
            <div class="layui-input-block">
                <select name='pid' class='layui-select' lay-search>
                    @foreach( $menus as $menu)
                        @if($menu['id'] == ($vo['pid'] ?? 0))
                            <option selected value='{{$menu['id']}}'>{{$menu['spl'].$menu['title']}}</option>
                        @else
                            <option value='{{$menu['id']}}'>{{$menu['spl'].$menu['title']}}</option>
                        @endif
                    @endforeach
                </select>
                <p class="help-block"><b>必选</b>，请选择上级菜单或顶级菜单（目前最多支持三级菜单）</p>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">菜单名称</label>
            <div class="layui-input-block">
                <input name="title" value='{{$vo['title'] ?? ""}}' required placeholder="请输入菜单名称" class="layui-input">
                <p class="help-block"><b>必选</b>，请填写菜单名称（如：系统管理），建议字符不要太长，一般4-6个汉字</p>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">菜单链接</label>
            <div class="layui-input-block">
                <input onblur="this.value=this.value === ''?'#':this.value" name="url" required placeholder="请输入菜单链接"
                       value="{{ $vo['url'] ?? '' }}" class="layui-input">
                <p class="help-block">
                    <b>必选</b>，请填写链接地址或选择系统节点（如：https://domain.com/admin/user/index.html 或 admin/user/index）
                    <br>当填写链接地址时，以下面的“权限节点”来判断菜单自动隐藏或显示，注意未填写“权限节点”时将不会隐藏该菜单哦
                </p>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">链接参数</label>
            <div class="layui-input-block">
                <input name="params" placeholder="请输入链接参数" value="{{ $vo['params'] ?? ''}}" class="layui-input">
                <p class="help-block">可选，设置菜单链接的GET访问参数（如：name=1&age=3）</p>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">菜单图标</label>
            <div class="layui-input-block">
                <div class="layui-input-inline">
                    <input placeholder="请输入或选择图标" name="icon" value='{{ $vo['icon'] ?? '' }}' class="layui-input">
                </div>
                <span style="padding:0 12px;min-width:45px" class='layui-btn layui-btn-primary'>
                    <i style="font-size:1.2em;margin:0" class='{{ $vo['icon'] ?? '' }}'></i>
                </span>
                <button data-icon='icon' type='button' class='layui-btn layui-btn-primary'>选择图标</button>
                <p class="help-block">可选，设置菜单选项前置图标</p>
            </div>
        </div>

    </div>

    <div class="hr-line-dashed"></div>
    @if(isset($vo['id']))<input type='hidden' value='{{$vo['id']}}' name='id'>@endif

    <div class="layui-form-item text-center">
        <button class="layui-btn" type='submit'>保存数据</button>
        <button class="layui-btn layui-btn-danger" type='button' data-confirm="确定要取消编辑吗？" data-close>取消编辑</button>
    </div>
</form>
<script>
    layui.form.render();
    require(['jquery.autocompleter'], function () {
        $('[name="icon"]').on('change', function () {
            $(this).parent().next().find('i').get(0).className = this.value
        });
        $('input[name=url]').autocompleter({
            limit: 5,
            highlightMatches: true,
            template: '@{{ label }} <span> @{{ title }} </span>',
            source: (function (subjects, data = []) {
                for (var i in subjects) data.push({
                    value: subjects[i].node,
                    label: subjects[i].node,
                    title: subjects[i].title
                });
                return data;
            })(JSON.parse('{!! json_encode($nodes) !!}'))
        });
    });
</script>
