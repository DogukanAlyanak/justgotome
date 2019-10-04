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
                                <div id="LinksAlert" class="member-alert"></div>
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

            <!-- Tablo Start -->
            <div class="row">
                <div class="col">
                    <div class="jgt-card">


                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Kısa Link</th>
                                    <th scope="col">Uzun Link</th>
                                    <th scope="col">Tıklanma Sayısı</th>
                                    <th scope="col">Oluşturan</th>
                                    <th scope="col">Oluşturma Tarihi</th>
                                    <th scope="col">Güncelleme Tarihi</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                // Değişkenker


                                // Seçili Verinin Bilgilerini Çekme
                                $query = $db->prepare(" SELECT * FROM adres_table ");
                                $query->execute(array());
                                $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

                                // Seçili Verileri Dizme
                                foreach ($thequery as $queryresult) {

                                    ?>

                                    <tr>
                                        <form id="LinksForm" action="linksedit.php" method="post">
                                            <input name="dbid" type="hidden" value="<?php echo $queryresult['DB_ADRES_ID']; ?>">
                                            <td>
                                                <?php echo $queryresult['DB_ADRES_KISA']; ?>
                                                <input name="kisaAdres" type="hidden" value="<?php echo $queryresult['DB_ADRES_KISA']; ?>">
                                            </td>
                                            <td>
                                                <?php echo $queryresult['DB_ADRES_UZUN']; ?>
                                                <input name="uzunAdres" type="hidden" value="<?php echo $queryresult['DB_ADRES_UZUN']; ?>">
                                            </td>
                                            <td>
                                                <?php echo $queryresult['DB_ADRES_HIT']; ?>
                                                <input name="hit" type="hidden" value="<?php echo $queryresult['DB_ADRES_HIT']; ?>">
                                            </td>
                                            <td>
                                                <?php echo idtousername($queryresult['DB_ADRES_CREATOR']); ?>
                                                <input name="linkOwner" type="hidden" value="<?php echo $queryresult['DB_ADRES_CREATOR']; ?>">
                                            </td>
                                            <td>
                                                <?php echo DateHourRead($queryresult['DB_ADRES_CREATE_DATE']); ?>
                                                <input name="cDate" type="hidden" value="<?php echo $queryresult['DB_ADRES_CREATE_DATE']; ?>">
                                            </td>
                                            <td>
                                                <?php echo DateHourRead($queryresult['DB_ADRES_UPDATE_DATE']); ?>
                                                <input name="uDate" type="hidden" value="<?php echo $queryresult['DB_ADRES_UPDATE_DATE']; ?>">
                                            </td>

                                            <td>
                                                <button type="submit" class="btn btn-outline-primary btn-xs" type="button"><i class="simple-icon-pencil"></i>&nbsp; Düzenle</button>
                                            </td>
                                        </form>

                                        <td><button class='btn btn-outline-danger btn-xs' type='button' data-toggle='modal' data-target='#delLinkModal<?php echo $queryresult['DB_ADRES_ID']; ?>'><i class='simple-icon-trash'></i>&nbsp; Sil</button></td>

                                        <!-- Link Sil Modal START -->
                                        <div class="modal fade" id="delLinkModal<?php echo $queryresult['DB_ADRES_ID']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Linki Sil</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Kısa Link: <h5><?php echo $queryresult['DB_ADRES_KISA']; ?> ,</h5> Uzun Link: <h5><?php echo $queryresult['DB_ADRES_UZUN']; ?></h5>
                                                        <br> Linkini Silmek istediğinizden Emin misiniz?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="jbt bt-admin-outline-light bt-sm2" data-dismiss="modal">Vazgeç</button>
                                                        <button id='LinkSilBt<?php echo $queryresult['DB_ADRES_ID']; ?>' type="button" class="jbt bt-admin-primary bt-sm2">Onayla</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Link Sil Modal END -->





                                        <!-- Link Sil javascript START -->

                                        <script>
                                            // !!!!!!!!!!!!! Admin Links Delete - Admin Linkler Sil Area !!!!!!!!!!!!!!!!!

                                            //Admin Links Edit Delete - Admin Linkler Sil > Sil Buton Tıklandığında
                                            $('#LinkSilBt<?php echo $queryresult['DB_ADRES_ID']; ?>').click(function() {
                                                LinksDeletPost<?php echo $queryresult['DB_ADRES_ID']; ?>()
                                            })

                                            // Admin Links Delete - Admin Linkler Sil > Post Et
                                            function LinksDeletPost<?php echo $queryresult['DB_ADRES_ID']; ?>() {
                                                var data = "&dbid=<?php echo $queryresult['DB_ADRES_ID']; ?>"
                                                $.ajax({
                                                    url: "modules/adminprocess.php?process=AdminLinkDelete",
                                                    type: "POST",
                                                    data: data,
                                                    success: function(e) {
                                                        e1 = e.substring(1, 999);
                                                        e2 = e.substring(0, 1);
                                                        if (e2 == "v") {
                                                            LinksDeletDoneAlert(e1)
                                                        } else {
                                                            LinksDeletErrorAlert(e1)
                                                        }
                                                    }
                                                });
                                            }
                                        </script>

                                        <!-- Link Sil javascript END -->




                                    </tr>

                                <?php  } // foreach döngü kapama 
                                ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


            <!-- Tablo END -->

            <!-- Link Sil javascript 2 START -->
            <script>
                // Admin Links Delete - Admin Linkler Sil Alert > Başarılı
                function LinksDeletDoneAlert(e) {
                    var buSayfa = window.location.href;
                    buSayfa = buSayfa.split("ttp:/")
                    buSayfa = buSayfa[0] + "ttps:/" + buSayfa[1]
                    buSayfa = buSayfa.split("links")
                    var links = buSayfa[0] + "links"
                    $("#LinksAlert").html(e + "<meta http-equiv='refresh' content='0;URL=" + links + "'>").hide().fadeIn(100);
                    LinksDeletAlerTime()
                }


                // Admin Links Delete - Admin Linkler Sil Alert > Hata
                function LinksDeletErrorAlert(e) {
                    $("#LinksAlert").html(e).hide().fadeIn(100);
                    LinksDeletAlerTime()
                }


                // Admin Links Delete - Admin Linkler Sil Alert Zaman
                function LinksDeletAlerTime() {
                    var zaman;
                    clearTimeout(zaman);
                    $('#LinksAlert').fadeIn(200);
                    zaman = setTimeout(function() {
                        $('#LinksAlert').fadeOut(500);
                    }, 4000)
                }
            </script>
            <!-- Link Sil javascript 2 END -->


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