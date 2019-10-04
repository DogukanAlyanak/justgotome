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
                            </ol>
                        </nav>
                    </div>

                    <div class="mb-2">
                        <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions" role="button" aria-expanded="true" aria-controls="displayOptions">
                            Display Options
                            <i class="simple-icon-arrow-down align-middle"></i>
                        </a>
                        <div class="collapse d-md-block" id="displayOptions">

                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Sırala ...
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                    </div>
                                </div>
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input placeholder="Ara...">
                                </div>
                                <div id="membersAlert" class="member-alert"></div>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small">Displaying 1-10 of 210 items </span>
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    20
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">10</a>
                                    <a class="dropdown-item active" href="#">20</a>
                                    <a class="dropdown-item" href="#">30</a>
                                    <a class="dropdown-item" href="#">50</a>
                                    <a class="dropdown-item" href="#">100</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-1">
                    <h4 class="member-h4s">Kullanıcı Adı</h4>
                </div>
                <div class="col">
                    <h4 class="member-h4s">ID</h4>
                </div>
                <div class="col-2">
                    <h4 class="member-h4s">Ad, Soyad</h4>
                </div>
                <div class="col-1">
                    <div class="col-j"></div>
                    <h4 class="member-h4s">Mail</h4>
                </div>
                <div class="col">
                    <h4 class="member-h4s">Doğum Tarihi</h4>
                </div>
                <div class="col">
                    <h4 class="member-h4s">Rütbesi</h4>
                </div>
                <div class="col">
                    <h4 class="member-h4s">Kayıt Tarihi</h4>
                </div>
                <div class="col">
                    <h4 class="member-h4s">Ban Durumu</h4>
                </div>
                <div class="col"></div>
                <div class="col"></div>
            </div>


            <?php

            // Değişkenker


            // Seçili Verinin Bilgilerini Çekme
            $query = $db->prepare(" SELECT * FROM accounts_table ");
            $query->execute(array());
            $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

            // Seçili Verileri Dizme
            foreach ($thequery as $queryresult) {

                ?>


                <div class="card d-flex flex-row mb-3">
                    <div class="d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                            <p class="list-item-heading mb-1 truncate w-5 w-xs-100"><?php echo $queryresult['ACCOUNT_USERNAME'] ?></p>
                            <p class="mb-1 text-muted text-small w-5 w-xs-100"><?php echo $queryresult['ACCOUNT_ID'] ?></p>
                            <p class="mb-1 text-muted text-small w-10 w-xs-100"><?php echo $queryresult['ACCOUNT_NAME'] . " " . $queryresult['ACCOUNT_SURNAME'] ?></p>
                            <p class="mb-1 text-muted text-small w-10 w-xs-100"><?php echo $queryresult['ACCOUNT_MAIL'] ?></p>
                            <p class="mb-1 text-muted text-small w-5 w-xs-100"><?php echo DateRead3($queryresult['ACCOUNT_BIRTHDAY']) ?></p>
                            <p class="mb-1 text-muted text-small w-5 w-xs-100"><?php echo rutbeText($queryresult['ACCOUNT_RANK']) ?></p>
                            <p class="mb-1 text-muted text-small w-5 w-xs-100"><?php echo DateHourRead($queryresult['ACCOUNT_DATE']) ?></p>
                            <p id="banTextp" class="mb-1 text-muted text-small w-5 w-xs-100"><?php echo banText($queryresult['ACCOUNT_BANCONTROL']) ?></p>

                            <?php

                                echo ceoCtrl($queryresult['ACCOUNT_ID']) == "verified" // Eğer Yetkisi yoksa Kaybolsun! 
                                    ? '<a href="memberedit.php?AdminEditUye=' . $queryresult['ACCOUNT_ID'] . '"><button class="btn btn-outline-secondary btn-xs jgt-note-btn" type="button"><i class="simple-icon-pencil"></i>Düzenle</button></a>'
                                    : '<button class="btn btn-outline-dark btn-xs jgt-note-btn" type="button"><i class="simple-icon-pencil"></i>Düzenle</button>';

                                ?>

                            <?php

                                if ($queryresult['ACCOUNT_BANCONTROL'] != NULL) {

                                    if (ceoCtrl($queryresult['ACCOUNT_ID']) == "verified") {

                                        echo "<button id='BanKaldirBt" . $queryresult['ACCOUNT_DBID'] . "' class='btn btn-outline-danger btn-xs' type='button'><i class='simple-icon-ban'></i>&nbsp; BANI KALDIR</button>";
                                    } else {

                                        echo "<button class='btn btn-outline-warning btn-xs' type='button'><i class='simple-icon-ban'></i>&nbsp; BANI KALDIR</button>";
                                    }
                                } else {

                                    if (ceoCtrl($queryresult['ACCOUNT_ID']) == "verified") {

                                        echo "<button id='BanlaBt" . $queryresult['ACCOUNT_DBID'] . "' class='btn btn-outline-danger btn-xs' type='button'><i class='simple-icon-ban'></i>&nbsp; BANLA</button>";
                                    } else {

                                        echo "<button class='btn btn-outline-dark btn-xs' type='button'><i class='simple-icon-ban'></i>&nbsp; BANLA</button>";
                                    }
                                }

                                ?>


                            <!-- BAN POST START -->
                            <script>
                                // BAN KALDIR > Tıklandığında
                                $('#BanKaldirBt<?php echo $queryresult['ACCOUNT_DBID'] ?>').click(function() {
                                    BanKaldirPost<?php echo $queryresult['ACCOUNT_DBID'] ?>()
                                })

                                // BAN KALDIR > Post Et
                                function BanKaldirPost<?php echo $queryresult['ACCOUNT_DBID'] ?>() {
                                    var data = "&banUye=<?php echo $queryresult['ACCOUNT_ID'] ?>&banUyeUN=<?php echo $queryresult['ACCOUNT_USERNAME'] ?>";
                                    $.ajax({
                                        url: "modules/adminprocess.php?process=BanKaldir",
                                        type: "POST",
                                        data: data,
                                        success: function(e) {
                                            e1 = e.substring(1, 999);
                                            e2 = e.substring(0, 1);
                                            if (e2 == "v") {
                                                membersDoneAlert2(e1)
                                            } else {
                                                membersErrorAlert(e1)
                                            }
                                        }
                                    });
                                }

                                // BANLA > Tıklandığında
                                $('#BanlaBt<?php echo $queryresult['ACCOUNT_DBID'] ?>').click(function() {
                                    BanlaPost<?php echo $queryresult['ACCOUNT_DBID'] ?>()
                                })

                                // BANLA > Post Et
                                function BanlaPost<?php echo $queryresult['ACCOUNT_DBID'] ?>() {
                                    var data = "&banUye=<?php echo $queryresult['ACCOUNT_ID'] ?>&banUyeUN=<?php echo $queryresult['ACCOUNT_USERNAME'] ?>";
                                    $.ajax({
                                        url: "modules/adminprocess.php?process=Banla",
                                        type: "POST",
                                        data: data,
                                        success: function(e) {
                                            e1 = e.substring(1, 999);
                                            e2 = e.substring(0, 1);
                                            if (e2 == "v") {
                                                membersDoneAlert1(e1)
                                            } else {
                                                membersErrorAlert(e1)
                                            }
                                        }
                                    });
                                }
                            </script>
                            <!-- BAN POST END -->

                        </div>
                    </div>
                </div>

            <?php  } // foreach döngü kapama 
            ?>
            <script>
                // !!!!!!!!!!!!!!!! ALERT SCRIPT !!!!!!!!!!!!!!!!
                // BANLA Alert > Başarılı
                function membersDoneAlert1(e) {
                    $("#membersAlert").html("<span style='color:orange;'>" + e + "</span>" + "<meta http-equiv='refresh' content='0;URL=" + "<?php echo $YonetimUyelerURL; ?>" + "'>").hide().fadeIn(100);
                    membersAlertTime()
                }

                // BAN KALDIR Alert > Başarılı
                function membersDoneAlert2(e) {
                    $("#membersAlert").html("<span style='color:orange;'>" + e + "</span>" + "<meta http-equiv='refresh' content='0;URL=" + "<?php echo $YonetimUyelerURL; ?>" + "'>").hide().fadeIn(100);
                    membersAlertTime()
                }

                // BAN Alert > Hata
                function membersErrorAlert(e) {
                    $("#membersAlert").html("<span style='color:red;'>" + e + "</span>").hide().fadeIn(100);
                    membersAlertTime()
                }


                // BAN Alert Zaman
                function membersAlertTime() {
                    var zaman;
                    clearTimeout(zaman);
                    $('#membersAlert').fadeIn(200);
                    zaman = setTimeout(function() {
                        $('#membersAlert').fadeOut(500);
                    }, 4000)
                }
            </script>



            <nav class="mt-4 mb-3">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item ">
                        <a class="page-link first" href="#">
                            <i class="simple-icon-control-start"></i>
                        </a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link prev" href="#">
                            <i class="simple-icon-arrow-left"></i>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link next" href="#" aria-label="Next">
                            <i class="simple-icon-arrow-right"></i>
                        </a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link last" href="#">
                            <i class="simple-icon-control-end"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        </div>
        </div>
    </main>

    <?php include "inc/footer.php"; ?>