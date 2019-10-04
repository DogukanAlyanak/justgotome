<?php

include "modules/adminconfig.php";
include "modules/adminfunction.php";
include "modules/adminconnectdb.php";
include "modules/adminsession.php";


// Yetki Kontrol 

echo yetki(s('user_rank')) == "verified" // Eğer Yetkisi yoksa Kaybolsun! 
    ? ""
    : git($GirisURL);



include "inc/header.php";
include "inc/navbar.php";
include "inc/sidebar.php";

?>

<body id="app-container" class="menu-sub-hidden show-spinner">
    <main>
        <div class="container-fluid disable-text-selection">
            <div class="row">
                <div class="col-12">
                    <div class="mb-2">
                        <h1>
                            <i class="simple-icon-link"></i>
                            &nbsp;
                            Linkler
                        </h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo $YonetimURL; ?>">Yönetim</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo $YonetimLinklerURL; ?>">Linkler</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a><?php echo $_POST['kisaAdres']; ?></a>
                                </li>
                            </ol>
                        </nav>

                    </div>
                    <div class="separator mb-5">
                    </div>
                </div>
            </div>

            <div class="memedit-geri">
                <a href="<?php echo $YonetimLinklerURL; ?>">
                    <button type="button" class="jbt bt-admin-outline-light bt-sm2">
                        < Geri </button> </a> </div> <h5 class="mb-4">' <?php echo $_POST['kisaAdres']; ?> '&nbsp;&nbsp; Kısa Link Bilgileri</h5>


                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <form id="LinksEditSaveForm">

                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>DB Satır ID:</p>
                                                    </div>
                                                    <p class="member-text"><?php echo $_POST['dbid']; ?></p>
                                                    <input name="dbid" value="<?php echo $_POST['dbid']; ?>" type="hidden">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Kısa Adres:</p>
                                                    </div>
                                                    <input name="kisaAdres" placeholder="ornek.com" type="text" class="form-control" 
                                                    value="<?php echo $_POST['kisaAdres']; ?>" aria-describedby="basic-addon1">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Uzun Adres:</p>
                                                    </div>
                                                    <input name="uzunAdres" placeholder="http://www.ornekadresuzun.com/kjasdghksdfsdf" type="text" class="form-control" 
                                                    value="<?php echo $_POST['uzunAdres']; ?>" aria-describedby="basic-addon1">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Tıklanma Sayısı:</p>
                                                    </div>
                                                    <p id="hit" class="member-text"><?php echo $_POST['hit']; ?></p>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Oluşturan:</p>
                                                    </div>
                                                    <input name="linkOwner" placeholder="username" type="text" class="form-control" 
                                                    value="<?php echo idtousername($_POST['linkOwner']); ?>" aria-describedby="basic-addon1">
                                                </div>
                                                
                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Oluşturulma Tarihi:</p>
                                                    </div>
                                                    <p class="member-text"><?php echo DateHourRead($_POST['cDate']); ?></p>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Güncellenme Tarihi:</p>
                                                    </div>
                                                    <p class="member-text"><?php echo DateHourRead($_POST['uDate']); ?></p>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="LinkEditAlert"></div>
                                        </div>
                                        <div class="col">
                                            <div class="memberedit-btn-area">                                              
                                                <a href="<?php echo $YonetimLinklerURL; ?>"><button type="button" class="jbt bt-admin-outline-light bt-sm2">< Geri</button></a>
                                                <button type='button' class='jbt bt-admin-outline-danger bt-sm2' data-toggle='modal' data-target='#delLinkModal'>Linki Sil</button>


                                                 <!-- Link Sil Modal START -->
                                                 <div class="modal fade" id="delLinkModal" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Linki Sil</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Kısa Link: <h5><?php echo $_POST['kisaAdres']; ?> ,</h5> Uzun Link: <h5><?php echo $_POST['uzunAdres']; ?></h5>
                                                                <br> Linkini Silmek istediğinizden Emin misiniz?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="jbt bt-admin-outline-light bt-sm2" data-dismiss="modal">Vazgeç</button>
                                                                <button id='LinkEditSilBt' type="button" class="jbt bt-admin-primary bt-sm2">Onayla</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Link Sil Modal END -->


                                                <button id="LinkEditKaydetBt" type="button" class="jbt bt-admin-primary bt-sm2">Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
    </main>

    <?php include "inc/footer.php"; ?>