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
                            <span class="glyphicon glyphicon-link"></span>
                        </a>
                    </div>
                    <h1 class="jm-slider-h1-baslik">
                        Link Listem
                    </h1>
                </div>
                <!-- Başlık ve Link icon Area END -->
                <br>
                <div class="container">
                    <div class="row">
                        <div class="LinkTablo-area">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Uzun Link</th>
                                        <th scope="col"></th>
                                        <th scope="col">Kısa Link</th>
                                        <th scope="col">Tıklanma</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- Verileri Veritabanından çekme işlemleri START-->
                                    <?php
                                    $usrid = $_SESSION['user_id'];
                                    $mylinks = $db->prepare("SELECT * FROM adres_table WHERE DB_ADRES_CREATOR='$usrid' ORDER BY DB_ADRES_ID ASC");
                                    $mylinks->execute(array());
                                    $mylink = $mylinks->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($mylink as $mylkelements) {
                                        ?>
                                        <!-- Verileri Veritabanından çekme işlemleri END-->
                                        <tr>

                                            <td><a title="Düzenle" href="<?php echo $BuSiteURL ?>linkedit.php?shortURLadress=<?php echo $mylkelements['DB_ADRES_KISA'] ?>" class="btn bt-span1">
                                            <span class="glyphicon glyphicon-edit"></span>
                                                </a></td>

                                            <td class="list-uzun-td"><?php echo $mylkelements['DB_ADRES_UZUN'] ?></td>

                                            <td><a title="Kopyala" class="btn bt-span1" id="ListCopy<?php echo $mylkelements['DB_ADRES_ID'] ?>">
                                                    <span class="glyphicon glyphicon-copy"></span>
                                                </a></td>

                                            <td id="ListSURL<?php echo $mylkelements['DB_ADRES_ID'] ?>"><?php echo $BuSiteURLname ?>/<?php echo $mylkelements['DB_ADRES_KISA'] ?></td>

                                            <td class="text-center"><?php echo $mylkelements['DB_ADRES_HIT'] ?></td>

                                            <td><a title="Sil" class="btn bt-spantrash" data-toggle="modal" data-target="#myModal<?php echo $mylkelements['DB_ADRES_ID'] ?>">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a></td>

                                            <!-- Kopyala buton Scriptisi START -->
                                            <script>
                                                //Copy to Clipboard Çağır
                                                $("#ListCopy<?php echo $mylkelements['DB_ADRES_ID'] ?>").click(function() {
                                                    ListCopycc<?php echo $mylkelements['DB_ADRES_ID'] ?>()
                                                });

                                                //Copy To Clipboard
                                                function ListCopycc<?php echo $mylkelements['DB_ADRES_ID'] ?>() {
                                                    var copyText = $("#ListSURL<?php echo $mylkelements['DB_ADRES_ID'] ?>").html();
                                                    var $temp = $("<input>");
                                                    $("body").append($temp);
                                                    $temp.val(copyText).select();
                                                    document.execCommand("copy");
                                                    $temp.remove();
                                                    $("#ListAlert").fadeIn(300);
                                                    $("#ListAlert").html(copyText + "&nbsp;&nbsp; Kopyalandı!");
                                                };
                                            </script>
                                            <!-- Kopyala buton Scriptisi END -->

                                            <!-- SİL MODAL START -->
                                            <div class="modal fade" id="myModal<?php echo $mylkelements['DB_ADRES_ID'] ?>">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>Veriyi Sil</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                        <?php echo $BuSiteURLname ?>/<?php echo $mylkelements['DB_ADRES_KISA'] ?> Linkine ait veriler silinecektir. Onaylıyor musunuz?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="core/modules/process.php?process=LinkSil&kisaURL=<?php echo $mylkelements['DB_ADRES_KISA'] ?>" class="btn btn-primary">Onayla</a>
                                                            <button class="btn btn-light" data-toggle="modal" data-target="#myModal<?php echo $mylkelements['DB_ADRES_ID'] ?>">Vazgeç</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- SİL MODAL END -->

                                        </tr>
                                    <?php  } // foreach döngü kapama 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                </form>
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
<?php echo @s('user_name') == NULL ? "<meta http-equiv='refresh' content='0;URL=" . $GirisURL . "'>" : "" ?>


<?php include "core/inc/footer.php"; ?>