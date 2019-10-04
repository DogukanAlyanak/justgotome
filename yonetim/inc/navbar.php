<?php

include "modules/adminconfig.php";
include "modules/adminsession.php";

?>

<nav class="navbar fixed-top">
    <div class="d-flex align-items-center navbar-left">
        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1" />
                <rect x="0.48" y="7.5" width="7" height="1" />
                <rect x="0.48" y="15.5" width="7" height="1" />
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1" />
                <rect x="1.56" y="7.5" width="16" height="1" />
                <rect x="1.56" y="15.5" width="16" height="1" />
            </svg>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1" />
                <rect x="0.5" y="7.5" width="25" height="1" />
                <rect x="0.5" y="15.5" width="25" height="1" />
            </svg>
        </a>

    </div>


    <a class="navbar-logo" href="<?php echo $YonetimURL; ?>">
        <img class="jgt-admin-logo" src="<?php echo $logo; ?>" alt="Logo">
        <h1><?php echo $BuSiteName; ?></h1>
    </a>

    <div class="navbar-right">
        <div class="header-icons d-inline-block align-middle">

        <a class="btn btn-sm btn-outline-primary mr-2 d-none d-md-inline-block mb-2" href="<?php echo $BuSiteURL; ?>">&nbsp;Siteye Dön&nbsp;</a>
        
        
        <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
            <i class="simple-icon-size-fullscreen"></i>
            <i class="simple-icon-size-actual"></i>
        </button>
        
    </div>
    
    <div class="user d-inline-block">
        <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="name">
                <?php echo s('user_nick')?>
            </span>
        </button>
        &nbsp;
        <a title="Çıkış" class="btn btn-sm btn-outline-dark mr-2 d-none d-md-inline-block mb-2" href="modules/adminprocess.php?process=Cikis"><i class='simple-icon-logout'></i></a>
            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item" href="<?php echo $YonetimCikis; ?>">Çıkış Yap</a>
            </div>
        </div>
    </div>
</nav>