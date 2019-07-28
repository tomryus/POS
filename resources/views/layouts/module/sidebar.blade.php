<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="/" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                <li><a href={{route('category.index')}} class=""><i class="fa fa-pencil"></i> <span>Category</span></a></li>
                <li><a href="{{route('product.index')}}" class=""><i class="lnr lnr-code"></i> <span>Product</span></a></li>
                @role('admin')
                <li>
                    <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="fa fa-key"></i> <span>Management ROle</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{route('role.index')}}" class="">Role</a></li>
                            <li><a href="{{route('user.role_permission')}}" class="">Role Permission</a></li>
                        </ul>
                    </div>
                </li>               
                <li><a href="{{route('user.index')}}" class=""><i class="lnr lnr-user"></i> <span>User</span></a></li>
                @endrole
                <li><a href="panels.html" class=""><i class="lnr lnr-cog"></i> <span>Panels</span></a></li>
                <li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
                <li>
                    <a href="#subPages1" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages1" class="collapse ">
                        <ul class="nav">
                            <li><a href="page-profile.html" class="">Profile</a></li>
                            <li><a href="page-login.html" class="">Login</a></li>
                            <li><a href="page-lockscreen.html" class="">Lockscreen</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="tables.html" class=""><i class="lnr lnr-dice"></i> <span>Tables</span></a></li>
                <li><a href="typography.html" class=""><i class="lnr lnr-text-format"></i> <span>Typography</span></a></li>
                <li><a href="icons.html" class=""><i class="lnr lnr-linearicons"></i> <span>Icons</span></a></li>
            </ul>
        </nav>
    </div>
</div>
