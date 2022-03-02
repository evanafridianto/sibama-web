<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Navbar-left -->
        <ul class="nav navbar-nav navbar-left nav-menu-left">
            <li>
                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class="dripicons-menu"></i>
                </button>
            </li>
        </ul>
        <!-- Right(Notification) -->
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown user-box">
                <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                    <span class="text-uppercase" style="color: aliceblue;"><?= $this->session->nama ?> <img
                            src="<?php if (!file_exists('upload/users/' . $this->session->photo) || $this->session->photo == '') {
                                                                                                                        $this->session->photo = 'noimage.jpg';
                                                                                                                    }
                                                                                                                    echo base_url('upload/users/' . $this->session->photo) ?>" alt="user-img"
                            class="img-circle user-img"></span>
                </a>
                <ul
                    class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                    <li><a href="javascript: void(0);" onclick="profil_user(<?= $this->session->id_user ?>)">Profil</a>
                    </li>
                    <li><a href="javascript: void(0);" onclick="ganti_pass(<?= $this->session->id_user ?>)">Ganti
                            Password</a></li>
                    <li class="divider"></li>
                    <li><a href="javascript: void(0);" onclick="logout()">Log Out</a></li>
                </ul>
            </li>
        </ul> <!-- end navbar-right -->
    </div><!-- end container -->
</div><!-- end navbar -->