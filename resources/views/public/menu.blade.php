<!--Header-part-->
<div id="header">
    <h1 onclick="location.href = '/'"></h1>
</div>
<!--顶部菜单-->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li  class="dropdown" id="profile-messages" >
            <a title="" href="/" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                <i class="icon icon-user"></i>  <span class="text">欢迎您 {{Auth::user()->nickname}}</span><b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a href="/update/admin/password.html"><i class="icon-key"></i> 修改密码</a></li>
                <li><a href="{{route('logout')}}"><i class="icon-key"></i> 退出</a></li>
            </ul>
        </li>
        @if(isset($menus[0]))
        @foreach($menus[0] as $menu)
        <li class=""><a title="" href="{{$menu['url']}}"><i class="icon icon-cog"></i> <span class="text">{{$menu['name']}}</span></a></li>
        @endforeach
        @endif
    </ul>
</div>
<!--左边菜单-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i></a>
    <ul>
        @if(isset($crumbs[0])&&isset($menus[$crumbs[0]->level_id]))
        @foreach($menus[$crumbs[0]->level_id] as $menu_two)
        @if(isset($menus[$menu_two['level_id']]))
        <li class="submenu<?php if (in_array($menu_two->getKey(), $crumb_ids)) { ?> open<?php } ?>">
            <a href="javascript:void(0);" onclick="$(this).parent().toggleClass('open')">
                <i class="icon icon-th-list"></i>
                <span>{{$menu_two['name']}}</span>
            </a>
            <ul>
                @foreach($menus[$menu_two['level_id']] as $menu)
                <li<?php if (in_array($menu->getKey(), $crumb_ids)) { ?> class="active" id="show-menu-item"<?php } ?>><a href="{{$menu['url']}}">{{$menu['name']}}</a></li>
                @endforeach
            </ul>
        </li>
        @endif
        @endforeach
        @endif
    </ul>
</div>
<script>
    @if(isset($tag))
    var a = $(".open li");
    a.each(function (i, o) {
        if ($(o).text() == '商机列表') {
            $(o).removeClass('active');
        }
        @if($tag == 'opplist')
            if ($(o).text() == '提交商机列表') {
                $(o).addClass('active');
            }
        @elseif($tag == 'apply')
            if ($(o).text() == '对接商机列表') {
            $(o).addClass('active');
        }
        @endif
    });
    @endif
</script>