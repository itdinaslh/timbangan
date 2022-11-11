<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @yield('Title') 
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item">
                        <a type="button" class="btn btn-outline-primary mb-2 showMe" href="/login">
                            Login
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div id='myModal' class='modal fade in' data-bs-keyboard="false" data-bs-backdrop="static" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div id='myModalContent'></div>
        </div>
    </div>
</div>
