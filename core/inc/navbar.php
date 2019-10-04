<?php include "core/modules/config.php"; ?>

<header>
    <!-- Navbar START -->
    <!-- Navbar Passive START -->
    <nav id="passive-nav" class="passive-nav">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div>
                        <a href="<?php echo $BuSiteURL; ?>">
                            <svg class="login-nav-logo" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="55px" viewBox="0 0 1920 1920" enable-background="new 0 0 1920 1920" xml:space="preserve">
                                <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="151.3975" y1="1014.5049" x2="1647.4951" y2="1014.5049">
                                    <stop offset="0" style="stop-color:#0072FF" />
                                    <stop offset="0.1133" style="stop-color:#0083FF" />
                                    <stop offset="0.3249" style="stop-color:#009EFF" />
                                    <stop offset="0.5412" style="stop-color:#00B1FF" />
                                    <stop offset="0.7634" style="stop-color:#00BCFF" />
                                    <stop offset="1" style="stop-color:#00C0FF" />
                                </linearGradient>
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="url(#SVGID_1_)" d="M151.397,1419.563 c8.513-68.711,24.933-218.92,66.667-234.943c31.685-12.947,48.506,0.658,53.771,5.371c5.966,5.342,11.926,10.58,18.078,15.539 c38.508,31.047,79.255,58.125,122.501,80.816c27.18,14.26,55.702,21.186,85.799,21.166c44.715-0.025,88.354-6.686,129.281-27.129 c15.95-7.967,31.356-17.588,46.076-28.006c52.427-37.109,101.85-78.711,150.971-120.713 c212.694-181.873,425.355-363.793,638.025-545.7c60.251-51.535,120.494-103.08,180.745-154.613c1.176-1.006,2.413-1.928,4.185-2.22 c-0.852,0.821-1.694,1.652-2.555,2.461c-145.292,136.555-290.584,273.108-435.877,409.662 c-102.299,96.148-243.863,209.714-299.588,299.363c-5.754,12.648-2.182,22.863-0.655,27.553c9.554,29.34,1.649,4.512,17.715,54.264 c55.735,154.434,40.477,152.52,12.448,179.512c-27.665,24.418-44.938,39.842-78.872,69.512 c-38.66,33.545-78.633,65.072-122.763,89.91c-39.035,21.971-80.735,33.314-124.349,37.141 c-59.037,5.18-116.558-4.867-173.389-20.928c-40.061-11.32-79.823-23.688-117.417-43.066c-51.533-26.564-99.64-59.285-145.88-95.305 c-19.825-15.443-3.221-1.373-22.686-17.359C152.898,1421.252,152.287,1420.482,151.397,1419.563z" />
                                <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="465.1616" y1="695.0576" x2="1747.8252" y2="695.0576">
                                    <stop offset="0" style="stop-color:#0072FF" />
                                    <stop offset="0.1133" style="stop-color:#0083FF" />
                                    <stop offset="0.3249" style="stop-color:#009EFF" />
                                    <stop offset="0.5412" style="stop-color:#00B1FF" />
                                    <stop offset="0.7634" style="stop-color:#00BCFF" />
                                    <stop offset="1" style="stop-color:#00C0FF" />
                                </linearGradient>
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="url(#SVGID_2_)" d="M1743.131,331.945 c-16.081,12.886-5.194,4.103-21.166,17.148c-594.477,494.291-827.149,656.838-861.199,698.885 c-17.183,20.809-28.69,21.879-40.798,15.576C703.044,993.447,586.026,923.523,469.024,853.57c-5.269-3.691-4.027-8.178-2.746-10.613 c50.207-87.768,630.172-238.748,1237.006-504.746C1758.353,312.5,1749.367,326.345,1743.131,331.945z" />
                                <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="954.334" y1="949.4424" x2="1792.4902" y2="949.4424">
                                    <stop offset="0" style="stop-color:#0072FF" />
                                    <stop offset="0.1133" style="stop-color:#0083FF" />
                                    <stop offset="0.3249" style="stop-color:#009EFF" />
                                    <stop offset="0.5412" style="stop-color:#00B1FF" />
                                    <stop offset="0.7634" style="stop-color:#00BCFF" />
                                    <stop offset="1" style="stop-color:#00C0FF" />
                                </linearGradient>
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="url(#SVGID_3_)" d="M956.294,1160.957 c-35.823-44.568,426.396-435.263,810.968-830.751c14.334-15.741,36.175-33.003,18.819,21.26 c-129.097,439.958-206.226,728.192-335.603,1169.108c-36.406,96.916-89.964,62.799-123.422,30.77" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <ul class="passive-nav-ul">
                        <?php echo yetki(s('user_rank')) == "verified" // Yönetim Paneli / Boş
                            ? "<li><div class='col'><a href='" . $YonetimURL . "' class='passive-nav-li-a bt bt-passive-1'>Yönetim</a></div></li class='passive-nav-li'>"
                            : ""
                        ?>
                        <?php echo @s('user_id') != NULL // Kullanıcı Adı / Giriş Buton
                            ? "<li><div class='col'><a href='" . $ProfilURL . "' class='passive-nav-li-a bt bt-passive-1'>" . s('user_nick') . "</a></div></li class='passive-nav-li'>"
                            : "<li><div class='col'><a href='" . $UyeOlURL . "' class='passive-nav-li-a bt bt-passive-1'>Üye Ol!</a></div></li class='passive-nav-li'>"
                        ?>
                        <?php echo @s('user_id') != NULL // Kullanıcı Adı / Üye Ol Buton
                            ? "<li><div class='col'><a href='" . $ListemURL . "' class='passive-nav-li-a bt bt-passive-2'>Link Listem</a></div></li class='passive-nav-li'>"
                            : ""
                        ?>
                        <?php echo @s('user_id') != NULL // Üye Ol / Çıkış Buton
                            ? "<li><div class='col'><a href='core/modules/process.php?process=Cikis' class='passive-nav-li-a bt bt-passive-2'>Çıkış</a></div></li class='passive-nav-li'>"
                            : "<li><div class='col'><a href='" . $GirisURL . "' class='passive-nav-li-a bt bt-passive-2'>Giriş</a></div></li class='passive-nav-li'>"
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar Passive END -->

    <!-- Navbar Active START -->
    <nav id="active-nav" class="active-nav">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <a href="<?php echo $BuSiteURL; ?>">
                            <img src="../core/img/jgt-b-216.png">
                            <h1>JustGoTo.me</h1>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <ul class="active-nav-ul">
                        <?php echo yetki(s('user_rank')) == "verified" // Yönetim Paneli / Boş
                            ? "<li><div class='col'><a href='" . $YonetimURL . "' class='active-nav-li-a bt bt-active-1'>Yönetim</a></div></li class='active-nav-li'>"
                            : ""
                        ?>
                        <?php echo @s('user_id') != NULL // Kullanıcı Adı / Giriş Buton
                            ? "<li><div class='col'><a href='" . $ProfilURL . "' class='active-nav-li-a bt bt-active-1'>" . s('user_nick') . "</a></div></li class='active-nav-li'>"
                            : "<li><div class='col'><a href='" . $UyeOlURL . "' class='active-nav-li-a bt bt-active-1'>Üye Ol!</a></div></li class='active-nav-li'>"
                        ?>
                        <?php echo @s('user_id') != NULL // Kullanıcı Adı / Üye Ol Buton
                            ? "<li><div class='col'><a href='" . $ListemURL . "' class='active-nav-li-a bt bt-active-2'>Link Listem</a></div></li class='passive-nav-li'>"
                            : ""
                        ?>
                        <?php echo @s('user_id') != NULL // Üye Ol / Çıkış Buton
                            ? "<li><div class='col'><a href='core/modules/process.php?process=Cikis' class='active-nav-li-a bt bt-active-2'>Çıkış</a></div></li class='active-nav-li'>"
                            : "<li><div class='col'><a href=' " . $GirisURL . " ' class='active-nav-li-a bt bt-active-2'>Giriş</a></div></li class='active-nav-li'>"
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar Active END -->
    <!-- Navbar END -->
</header>