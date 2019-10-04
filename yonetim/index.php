<?php

include "modules/adminconfig.php";
include "modules/adminfunction.php";
include "modules/adminconnectdb.php";
include "modules/adminsession.php";
include "inc/header.php";

?>

<body id="app-container" class="menu-sub-hidden show-spinner">

    <?php echo yetki(s('user_rank')) == "verified" // Eğer Yetkisi yoksa Kaybolsun! 
        ? ""
        : git($GirisURL);
    ?>

    <?php
    include "inc/navbar.php";
    include "inc/sidebar.php";
    ?>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    
                    <h1>Yönetim Paneli</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo $YonetimURL; ?>">Yönetim</a>
                            </li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">

                    <!-- Website Visits - Web Site Ziyaretçileri START -->
                    <div class="col-md-6 col-sm-12 mb-4">
                        <div class="card dashboard-filled-line-chart">
                            <div class="card-body ">
                                <div class="float-left float-none-xs">
                                    <div class="d-inline-block">
                                        <h5 class="d-inline">Haftalık Site Ziyaretleri</h5>
                                        <span class="text-muted text-small d-block">Son 7 Günün Ziyaretçi Sayısı</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chart card-body pt-0">
                                <canvas id="visitChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Website Visits - Web Site Ziyaretçileri END -->


                    <!-- Sayaçlar START -->
                    <div class="col-lg-12 col-xl-6">

                        <div class="icon-cards-row">
                            <div class="owl-container">
                                <div class="owl-carousel dashboard-numbers">

                                    <a href="#" class="card">
                                        <div class="card-body text-center jgt-boxes">
                                            <i class="iconsmind-Eye"></i>
                                            <p class="card-text mb-0">Toplam Site Ziyareti</p>
                                            <span class="lead text-center"><?php echo toplamVisitSay(); ?></span>
                                        </div>
                                    </a>

                                    <a href="#" class="card">
                                        <div class="card-body text-center jgt-boxes">
                                            <i class="simple-icon-link"></i>
                                            <p class="card-text mb-0">Toplam Kısaltılmış Link</p>
                                            <span class="lead text-center"><?php echo linkSay(); ?></span>
                                        </div>
                                    </a>

                                    <a href="#" class="card">
                                        <div class="card-body text-center jgt-boxes">
                                            <i class="simple-icon-people"></i>
                                            <p class="card-text mb-0">Toplam Üye</p>
                                            <span class="lead text-center"><?php echo userSay(); ?></span>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sayaçlar END -->


                </div>

                <div class="row">

                    <!-- Website Visits - Web Site Ziyaretçileri START -->
                    <div class="col-md-6 col-sm-12 mb-4">
                        <div class="card dashboard-filled-line-chart">
                            <div class="card-body ">
                                <div class="float-left float-none-xs">
                                    <div class="d-inline-block">
                                        <h5 class="d-inline">Haftalık Kısaltılan Linkler</h5>
                                        <span class="text-muted text-small d-block">Son 7 Günün Kısaltılan Linkleri</span>
                                    </div>
                                </div>
                                <div class="btn-group float-right mt-2 float-none-xs">            
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Last Week</a>
                                        <a class="dropdown-item" href="#">This Month</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chart card-body pt-0">
                                <canvas id="conversionChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Website Visits - Web Site Ziyaretçileri END -->


                    <!-- Logs - Loglar START -->
                    <div class="col-md-3 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Loglar</h5>

                                <div class="scroll dashboard-logs">

                                    <table class="table table-sm table-borderless">

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="log-indicator border-theme-1 align-middle"></span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-medium">New user registiration</span>
                                                </td>
                                                <td class="text-right">
                                                    <span class="text-muted">14:12</span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Logs - Loglar END -->


                    <?php
                    $anotedbp = $db->prepare("SELECT * FROM yonetim_note_table WHERE WHITCH_NOTE='THAT_NOTE' ");
                    $anotedbp->execute(array());
                    $andbp = $anotedbp->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($andbp as $andbpNOTE)  ?>


                    <!-- Notes - Notlar START -->
                    <div class="col-md-3 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <i class="iconsmind-Danger" id="adminNoteAlert"></i>
                                <button id="adminNoteEditBt" class="btn btn-outline-secondary btn-xs jgt-note-btn" type="button">
                                    <i class="simple-icon-pencil"></i>
                                    Düzenle
                                </button>
                                <button id="adminNoteSaveBt" class="btn btn-outline-secondary btn-xs jgt-note-btn" type="button">
                                    <i class="iconsmind-Disk"></i>
                                    Kaydet
                                </button>
                                <h5 class="card-title">Notlar</h5>
                                <div class="scroll jgt-Notepad">
                                    <p id="NotepadNote"><?php echo $andbpNOTE['NOTE'] ?></p>
                                    <form class="form-inline jgt-note-edit" id="adminNoteForm">

                                        <div class="input-group">
                                            <textarea id="adminPanelNoteInput" name="adminPanelNoteInput" class="form-control" placeholder="Notunuzu Buraya Yazınız..."></textarea>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Notes - Notlar END -->

                </div>
            </div>
        </div>
        
    </main>

    <?php include "inc/footer.php"; ?>