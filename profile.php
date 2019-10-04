<?php
include "core/modules/connectdb.php";
include "core/modules/function.php";
include "core/modules/session.php";
include "core/modules/config.php";
include "core/inc/header.php";
include "core/inc/navbar-login.php";
?>

<body>
    <!-- Slider START -->
    <div class="jm-login-cont">
        <div class="container">
            <div class="row list-area">
                <!-- Başlık ve Link icon Area START -->
                <div class="head">
                    <div class="link-icon">
                        <a>
                            <span class="glyphicon glyphicon-user"></span>
                        </a>
                    </div>
                    <h1 class="jm-slider-h1-baslik">
                        Profilim
                    </h1>
                </div>
                <!-- Başlık ve Link icon Area END -->
                <br>


                <!-- Veri Tabanı Veri Çekme START -->

                <?php

                $usrid = $_SESSION['user_id'];
                $pinfov = $db->prepare("SELECT * FROM accounts_table WHERE ACCOUNT_ID='$usrid' ORDER BY ACCOUNT_DBID ASC");
                $pinfov->execute(array());
                $piv = $pinfov->fetchAll(PDO::FETCH_ASSOC);
                foreach ($piv as $myprf) {

                    ?>

                <!-- Veri Tabanı Veri Çekme END -->


                <!-- Profil Bilgileri START -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="Profil-area">
                                <a title="Profilimi Sil" class="btn bt-spantrash" data-toggle="modal" data-target="#deleteProfilModal">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>&nbsp;&nbsp;

                                <!-- SİL MODAL START -->
                                <div class="modal fade" id="deleteProfilModal">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3>Profilimi Sil</h3>
                                            </div>
                                            <div class="modal-body">
                                                Kısaltılmış Linkleriniz dahil tüm bilgileriniz silinecektir! Onaylıyor musunuz?
                                            </div>
                                            <div class="modal-footer">
                                                <a href="core/modules/process.php?process=profilDelete" class="btn btn-warning">Onayla</a>
                                                <button class="btn btn-light" data-toggle="modal" data-target="#deleteProfilModal">Vazgeç</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- SİL MODAL END -->

                                <a title="Düzenle" href="<?php echo $EditProfilURL ?>" class="btn bt-span1"><span class="glyphicon glyphicon-edit"></span></a>
                                <h2><?php echo $myprf['ACCOUNT_NAME'] . " " . $myprf['ACCOUNT_SURNAME'] ?></h2>
                                <h4><?php echo $myprf['ACCOUNT_NICKNAME'] ?></h4>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>Kullanıcı Adı:</p>
                                        <p>Rütbe:</p>
                                        <p>Nicki:</p>
                                        <p>İsmi:</p>
                                        <p>Soyismi:</p>
                                        <p>Doğum Tarihi:</p>
                                        <p>Mail Adresi:</p>
                                        <p>Kayıt Tarihi:</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p><?php echo $myprf['ACCOUNT_USERNAME'] ?></p>
                                        <p><?php echo $myprf['ACCOUNT_RANK'] ?></p>
                                        <p><?php echo $myprf['ACCOUNT_NICKNAME'] ?></p>
                                        <p><?php echo $myprf['ACCOUNT_NAME'] ?></p>
                                        <p><?php echo $myprf['ACCOUNT_SURNAME'] ?></p>
                                        <p><?php echo DateRead2($myprf['ACCOUNT_BIRTHDAY']) ?></p>
                                        <p><?php echo $myprf['ACCOUNT_MAIL'] ?></p>
                                        <p><?php echo KayitDR($myprf['ACCOUNT_DATE']) ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="EPpweBt-area">
                                        <a href="<?php echo $EditPwURL; ?>" title="Şifre Değiştir" class="bt bt-editpw">Şifre Değiştir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
                <!-- Profil Bilgileri END -->
                <?php  } // foreach döngü kapama  
                ?>
                <br>
                <!-- Alert Area START -->
                <div id="ListAlert"></div>
                <!-- Input Area END -->
            </div>
            <div> <input type="hidden" id="listcopyinput" value=""></div>
            <!-- Sağ Area END -->
        </div>
    </div>
    </div>
</body>

<!-- Eğer Kullanıcı Aktif Değilse Giriş Sayfasına Git! -->
<?php echo @s('user_id') == NULL ? "<meta http-equiv='refresh' content='0;URL=" . $GirisURL . "'>" : "" ?>


<?php include "core/inc/footer.php"; ?>