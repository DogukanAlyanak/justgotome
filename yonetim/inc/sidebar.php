<?php

include "modules/adminconfig.php"

?>

<div class="sidebar">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                <li class="<?php echo $_SERVER['REQUEST_URI'] == "/yonetim/" // Eğer Yönetim Sayfasındaysa
                                ? "active"
                                : ""
                            ?>">
                    <a href="<?php echo $YonetimURL; ?>">
                        <i class="iconsmind-Shop-4"></i>
                        <span>Yönetim Paneli</span>
                    </a>
                </li>
                <li class="<?php echo $_SERVER['REQUEST_URI'] == "/yonetim/members" // Eğer Yönetim Sayfasındaysa
                                ? "active"
                                : ""
                            ?>">
                    <a href="members">
                        <i class="simple-icon-people"></i>
                        <span>Üyeler</span>
                    </a>
                </li>
                <li class="<?php echo $_SERVER['REQUEST_URI'] == "/yonetim/links" // Eğer Yönetim Sayfasındaysa
                                ? "active"
                                : ""
                            ?>">
                    <a href="links">
                        <i class="simple-icon-link"></i>
                        <span>Linkler</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>