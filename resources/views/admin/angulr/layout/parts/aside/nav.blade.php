<!-- nav -->
<nav ui-nav class="navi clearfix">
    <ul class="nav">
        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
            <span>Navigation</span>
        </li>
        <li>
            <a href class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                <i class="glyphicon glyphicon-stats icon text-primary-dker"></i>
                <span class="font-bold">Dashboard</span>
            </a>
            <ul class="nav nav-sub dk">
                <li class="nav-sub-header">
                    <a href>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span>Dashboard v1</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <b class="label bg-info pull-right">N</b>
                        <span>Dashboard v2</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                <i class="glyphicon glyphicon-stats icon text-primary-dker"></i>
                <span class="font-bold">系统设置</span>
            </a>
            <ul class="nav nav-sub dk">
                <li>
                    <a href="{{ url('admin/permissions') }}">
                        <span>权限管理</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/roles') }}">
                        <span>角色管理</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/admins') }}">
                        <span>后台用户管理</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/menus') }}">
                        <span>菜单管理</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="">
                <b class="badge bg-info pull-right">9</b>
                <i class="glyphicon glyphicon-envelope icon text-info-lter"></i>
                <span class="font-bold">Email</span>
            </a>
        </li>
        <li class="line dk"></li>

        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
            <span>菜单</span>
        </li>
        <my-menu-list></my-menu-list>
    </ul>
</nav>
<!-- nav -->