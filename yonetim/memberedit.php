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



//Değişkenler
$AdminEditUye = g('AdminEditUye');

// Seçili Verinin Bilgilerini Çekme
$query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
$query->execute(array($AdminEditUye));
$thequery = $query->fetchAll(PDO::FETCH_ASSOC);

// Seçili Verileri Dizme
foreach ($thequery as $queryresult)

    //kullanıcı id yoksa
    if ($thequery) {
        echo "";
    } else {
        echo "<meta http-equiv='refresh' content='0;URL=" . $YonetimUyelerURL . "'>";
    }

// Yetki Kontrol 2
echo ceoCtrl($queryresult['ACCOUNT_ID']) == "verified" // Eğer Yetkisi yoksa Kaybolsun! 
    ? ''
    : "<meta http-equiv='refresh' content='0;URL=" . $YonetimUyelerURL . "'>";


?>

<body id="app-container" class="menu-sub-hidden show-spinner">
    <main>
        <div class="container-fluid disable-text-selection">
            <div class="row">
                <div class="col-12">
                    <div class="mb-2">
                    <h1>
                            <i class="simple-icon-people"></i>
                            &nbsp;
                            Üyeler
                        </h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo $YonetimURL; ?>">Yönetim</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo $YonetimUyelerURL; ?>">Üyeler</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a><?php echo $queryresult['ACCOUNT_USERNAME']; ?></a>
                                </li>
                            </ol>
                        </nav>

                    </div>
                    <div class="separator mb-5">
                    </div>
                </div>
            </div>

            <div class="memedit-geri">
                <a href="<?php echo $YonetimUyelerURL; ?>">
                    <button type="button" class="jbt bt-admin-outline-light bt-sm2">
                        < Geri </button> </a> </div> <h5 class="mb-4"><?php echo  $queryresult['ACCOUNT_NAME'] . ' " ' . $queryresult['ACCOUNT_NICKNAME'] . ' " ' . $queryresult['ACCOUNT_SURNAME']; ?> &nbsp;&nbsp; Kullanıcısının Bilgileri</h5>


                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <form id="memEditSaveForm">


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>ID:</p>
                                                    </div>
                                                    <p id="memEditUserID" class="member-text" value="<?php echo $queryresult['ACCOUNT_ID']; ?>"><?php echo $queryresult['ACCOUNT_ID']; ?></p>
                                                    <input name="memUserid" class="form-control" value="<?php echo $queryresult['ACCOUNT_ID']; ?>" type="hidden">
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Kullanıcı Adı:</p>
                                                    </div>
                                                    <input type="text" name="memUsername" class="form-control" placeholder="Kullanıcı Adı" value="<?php echo $queryresult['ACCOUNT_USERNAME']; ?>" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Rütbesi:</p>
                                                    </div>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-outline-primary dropdown-toggle mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="dropdown-rutbe-text" id="rutbeDDTxt"><?php echo rutbeText($queryresult['ACCOUNT_RANK']); ?></span>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a id="memberDDuser" class="dropdown-item jdd-item">Kullanıcı</a>
                                                            <a id="memberDDvip" class="dropdown-item jdd-item">V.I.P</a>
                                                            <a id="memberDDpremium" class="dropdown-item jdd-item">Premium</a>
                                                            <a id="memberDDadmin" class="dropdown-item jdd-item">Yönetici</a>
                                                            <?php
                                                            echo s('user_rank') == "owner" // Eğer Sahipse Değiştirebilsin
                                                                ? '<a id="memberDDowner" class="dropdown-item jdd-item" value="owner">Sahip</a>'
                                                                : "";
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <input id="memberRutbeInput" name="memRank" class="form-control" type="hidden" value="<?php echo $queryresult['ACCOUNT_RANK']; ?>">
                                                </div>



                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Takma Adı:</p>
                                                    </div>
                                                    <input name="memNickname" class="form-control" type="text" class="form-control" placeholder="Takma Adı" value="<?php echo $queryresult['ACCOUNT_NICKNAME']; ?>" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Adı:</p>
                                                    </div>
                                                    <input name="memName" type="text" class="form-control" placeholder="Adı" value="<?php echo $queryresult['ACCOUNT_NAME']; ?>" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Soyadı:</p>
                                                    </div>
                                                    <input name="memSurname" type="text" class="form-control" placeholder="Soyadı" value="<?php echo $queryresult['ACCOUNT_SURNAME']; ?>" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Maili:</p>
                                                    </div>
                                                    <input name="memMail" type="text" class="form-control" placeholder="Maili" value="<?php echo $queryresult['ACCOUNT_MAIL']; ?>" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Doğum Tarihi:</p>
                                                    </div>
                                                    <div style="width: 175px;">

                                                        <input name="memBirthday" type="date" class="form-control" aria-describedby="basic-addon1" placeholder="DD-MM-YYYY" value="<?php echo $queryresult['ACCOUNT_BIRTHDAY'] ?>" id="editProfilBirthday">
                                                    </div>
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Kayıt Tarihi:</p>
                                                    </div>
                                                    <p class="member-text"><?php echo DateHourRead($queryresult['ACCOUNT_DATE']); ?></p>
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Son Değişiklik Tarihi:</p>
                                                    </div>
                                                    <p class="member-text"><?php echo DateHourRead($queryresult['ACCOUNT_UPDATE']); ?></p>
                                                </div>


                                                <div class="input-group mb-3">
                                                    <div class="member-label-area">
                                                        <p>Ban Durumu:</p>
                                                    </div>
                                                    <p class="member-text"><?php echo banText($queryresult['ACCOUNT_BANCONTROL']); ?></p>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="membereditAlert"></div>
                                        </div>
                                        <div class="col">
                                            <div class="memberedit-btn-area">
                                                <a href="<?php echo $YonetimUyelerURL; ?>"><button type="button" class="jbt bt-admin-outline-light bt-sm2">Vazgeç</button></a>

                                                <?php echo s('user_rank') == "owner" // Eğer Yetkisi yoksa Kaybolsun! 
                                                    ? "<button type='button' class='jbt bt-admin-outline-danger bt-sm2' data-toggle='modal' data-target='#delMemberModal'>Kullanıcıyı Sil</button>"
                                                    : ''; ?>

                                                <!-- Kişi Sil Modal START -->
                                                <div class="modal fade" id="delMemberModal" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Kullanıcıyı Sil</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php echo  $queryresult['ACCOUNT_NAME'] . ' " ' . $queryresult['ACCOUNT_NICKNAME'] . ' " ' . $queryresult['ACCOUNT_SURNAME'] . " ( username: " . $queryresult['ACCOUNT_USERNAME'] . " )"; ?> &nbsp;&nbsp; Kullanıcısını Silmek istediğinizden Emin misiniz? Bu kullanıcıya ait tüm veriler silinecektir!
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button id="delModalvazgecBt" type="button" class="jbt bt-admin-outline-light bt-sm2" data-dismiss="modal">Vazgeç</button>
                                                                <button id='memEditKisiyiSilBt' type="button" class="jbt bt-admin-primary bt-sm2">Onayla</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Kişi Sil Modal END -->


                                                <button type="button" class="jbt bt-admin-outline-warning bt-sm2" data-toggle="modal" data-target="#resetPWmodal">Şifresini Sıfırla</button>

                                                <!-- Şifre Sıfırla Modal START -->
                                                <div class="modal fade" id="resetPWmodal" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Şifre Sıfırla</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php echo  $queryresult['ACCOUNT_NAME'] . ' " ' . $queryresult['ACCOUNT_NICKNAME'] . ' " ' . $queryresult['ACCOUNT_SURNAME'] . " ( username: " . $queryresult['ACCOUNT_USERNAME'] . " )"; ?> &nbsp;&nbsp; Kullanıcısının Şifresini Sıfırlamak istediğinizden Emin misiniz?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button id="AdminUserResetPWvazgecBt" type="button" class="jbt bt-admin-outline-light bt-sm2" data-dismiss="modal">Vazgeç</button>
                                                                <button id="AdminUserResetPWonayBt" type="button" class="jbt bt-admin-primary bt-sm2">Onayla</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Şifre Sıfırla Modal END -->

                                                <?php if ($queryresult['ACCOUNT_BANCONTROL'] == NULL) {
                                                    echo "<button id='memEditBanla' type='button' class='jbt bt-admin-outline-danger bt-sm2'>Banla</button>";
                                                } else {
                                                    echo "<button id='memEditBanKaldir' type='button' class='jbt bt-admin-outline-danger bt-sm2'>Ban Kaldır</button>";
                                                } ?>
                                                <button id="memberEditKaydetBt" type="button" class="jbt bt-admin-primary bt-sm2">Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
    </main>

    <?php include "inc/footer.php"; ?>