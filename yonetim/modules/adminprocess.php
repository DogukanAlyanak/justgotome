<?php

include "adminconfig.php";
include "adminfunction.php";
include "adminconnectdb.php";
include "adminsession.php";

// Yönetim Logout Çıkış Emri Gelidiğinde
if (LgnG('process') == 'Cikis') {
    session_destroy();
    git($BuSiteURL);
}

// Yönetim Paneli Notlar Edit Emri Geldiğinde
if (g('process') == 'adminNoteEdit') {

    // Değişkenleri Tanımla
    $adminNoteData = p('adminPanelNoteInput');

    // VeriTabanında Veri Varmı Kontrol Et!
    $adminNoteCTRdbp = $db->prepare(" SELECT * FROM yonetim_note_table WHERE WHITCH_NOTE=? ");
    $adminNoteCTRdbp->execute(array("THAT_NOTE"));
    $anctrdbp = $adminNoteCTRdbp->fetchAll(PDO::FETCH_ASSOC);
    // Varsa ...
    if ($anctrdbp) {
        $aNoteUpdateDB = $db->prepare("UPDATE yonetim_note_table SET NOTE=? WHERE WHITCH_NOTE='THAT_NOTE' ");
        $anudb = $aNoteUpdateDB->execute(array($adminNoteData));
        if ($anudb) {
            echo "v" . $adminNoteData;
        } else {
            echo "xHata! Lütfen tekrar deneyiniz yada IT Ekibine Haber Veriniz!";
        }
    } else {
        $adminNoteEkledbp = $db->prepare("INSERT INTO yonetim_note_table SET NOTE=?, WHITCH_NOTE='THAT_NOTE' ");
        $anEdbp = $adminNoteEkledbp->execute(array($adminNoteData));
        if ($anEdbp) {
            echo "v" . $adminNoteData;
        } else {
            echo "xHata! Lütfen tekrar deneyiniz yada IT Ekibine Haber Veriniz!";
        }
    }
}

// Banla
if (g('process') == 'Banla') {


    // Değişkenleri Tanımla
    $banUye = p('banUye');

    // Kotrol
    // Seçili Verinin Bilgilerini Çekme
    $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query->execute(array($banUye));
    $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

    // Seçili Verileri Dizme
    foreach ($thequery as $queryresult)

        // Değişkenleri Tanımla
        $banUyeUN = $queryresult['ACCOUNT_USERNAME'];

    if ($thequery) {
        if (s('user_rank') == "owner") {
            //İşlem
            $query = $db->prepare(" UPDATE accounts_table SET ACCOUNT_BANCONTROL=?  WHERE ACCOUNT_ID=? ");
            $thequery = $query->execute(array("perma", $banUye));

            if ($thequery) {
                echo "v" . $banUyeUN . " Kullanıcı Adlı Uye Banlandı!";
            } else {
                echo "xBir Hata oluştu lütfen sayfayı yenileyip tekrar deneyiniz...";
            }
        } else {
            if ($queryresult['ACCOUNT_RANK'] == "owner") {
                echo "xPatronu da, Banlamazssınn yaa :/";
            } else {
                //İşlem
                $query = $db->prepare(" UPDATE accounts_table SET ACCOUNT_BANCONTROL=?  WHERE ACCOUNT_ID=? ");
                $thequery = $query->execute(array("perma", $banUye));

                if ($thequery) {
                    echo "v" . $banUyeUN . " Kullanıcı Adlı Uye Banlandı!";
                } else {
                    echo "xBir Hata oluştu lütfen sayfayı yenileyip tekrar deneyiniz...";
                }
            }
        }
    } else {
        echo "xBöyle Bir Kullanıcıya ulaşılamadı. Lütfen sayfayı yenileyip tekrar deneyiniz yada IT Ekibiyle irtibata geçiniz...";
    }
}

// Ban Kaldır
if (g('process') == 'BanKaldir') {


    // Değişkenleri Tanımla
    $banUye = p('banUye');

    // Kotrol
    // Seçili Verinin Bilgilerini Çekme
    $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query->execute(array($banUye));
    $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

    // Seçili Verileri Dizme
    foreach ($thequery as $queryresult)

        // Değişkenleri Tanımla
        $banUyeUN = $queryresult['ACCOUNT_USERNAME'];

    if ($thequery) {
        if (s('user_rank') == "owner") {

            //İşlem
            $query = $db->prepare(" UPDATE accounts_table SET ACCOUNT_BANCONTROL=?  WHERE ACCOUNT_ID=? ");
            $thequery = $query->execute(array("", $banUye));

            if ($thequery) {
                echo "v" . $banUyeUN . " Kullanıcı Adlı Uyenin Banı Kaldırıldı!";
            } else {
                echo "xBir Hata oluştu lütfen sayfayı yenileyip tekrar deneyiniz...";
            }
        } else {
            if ($queryresult['ACCOUNT_RANK'] == "owner") {
                echo "xPatronu da, Banlamazssınn yaa :/";
            } else {
                //İşlem
                $query = $db->prepare(" UPDATE accounts_table SET ACCOUNT_BANCONTROL=?  WHERE ACCOUNT_ID=? ");
                $thequery = $query->execute(array("", $banUye));

                if ($thequery) {
                    echo "v" . $banUyeUN . " Kullanıcı Adlı Uyenin Banı Kaldırıldı!";
                } else {
                    echo "xBir Hata oluştu lütfen sayfayı yenileyip tekrar deneyiniz...";
                }
            }
        }
    } else {
        echo "xBöyle Bir Kullanıcıya ulaşılamadı. Lütfen sayfayı yenileyip tekrar deneyiniz yada IT Ekibiyle irtibata geçiniz...";
    }
}

// Admin > Kullanıcı > Şifresini Sıfırla
if (g('process') == 'userResetPW') {

    // Değişkenleri Tanımla
    $userid = p('userid');
    $rpwNewPw = p('rpwNewPw');

    // Kontrol
    // Seçili Verinin Bilgilerini Çekme
    $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query->execute(array($userid));
    $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

    // Seçili Verileri Dizme
    foreach ($thequery as $queryresult)

        if (@$thequery) {

            // Mail Değişkenleri
            $rpwMail = $queryresult['ACCOUNT_MAIL'];
            $rpwUser = $queryresult['ACCOUNT_USERNAME'];
            $rpwUserID = $queryresult['ACCOUNT_ID'];
            $rpwNick = $queryresult['ACCOUNT_NICKNAME'];
            $rpwKonu = $BuSiteName . " - Şifre Sıfırlama";
            $rpwMesaj = '<div style="background-color:#eee;background-image:none;background-repeat:repeat;background-position:top left;color:#333;font-family:Helvetica,Arial,sans-serif;line-height:1.25"><table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" class="m_216102612644868404body-table"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="20" cellspacing="0" width="600" class="m_216102612644868404outer-email-container"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="m_216102612644868404inner-email-container" style="background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" height="90" width="100%" class="m_216102612644868404email-logo" style="background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left"><tbody><tr><td align="center" valign="middle"> <br><h1> <img src="' . $emailLogoURL . '" height="34" alt="' . $BuSiteName . '" class="CToWUd"> ' . $BuSiteName . '</h1></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" height="1" width="100%" class="m_216102612644868404email-divider"><tbody><tr><td align="center" valign="middle" style="background-color:#eeeeee" width="249"></td><td align="center" valign="middle" style="background-color:#0099ff" width="102"></td><td align="center" valign="middle" style="background-color:#eeeeee" width="249"></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="40" cellspacing="0" height="0" width="100%" class="m_216102612644868404email-header"><tbody><tr><td align="center" valign="middle"> Merhaba ' . $rpwNick . ', Şifreniz Sıfırlanmıştır!</td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" height="0" width="100%" class="m_216102612644868404email-content"><tbody><tr><td align="center" valign="middle"><div class="m_216102612644868404message" style="text-align:left;padding:0 20px 20px;font-size:14px;line-height:1.5;width:80%"><p> Kullanıcı Adınız: ' . $rpwUser . '<br> Yeni Şifreniz: ' . $rpwNewPw . '<br> <br> Eğer şifre sıfırlanması talebinde bulunmadıysanız, <a href="' . $DestekURL . '" target="_blank">Destekle iletişime</a> geçebilirsiniz.</p></div></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="30" cellspacing="0" height="0" width="100%" class="m_216102612644868404email-action" style="border-top-width:1px;border-top-style:solid;border-top-color:#eee"><tbody><tr><td align="center" valign="middle"><div> <a href="' . $GirisURL . '" style="background-color:#0099ff;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:14px;line-height:40px;margin-bottom:10px;text-align:center;text-decoration:none;width:200px" target="_blank"> Giriş </a> <br> <small class="m_216102612644868404alternate-link" style="color:#999;font-size:11px;margin-top:4px;margin-bottom:4px;margin-right:4px;margin-left:4px"> Veya şu bağlantıyı tıklayın: <a href="' . $GirisURL . '" style="color:#999" target="_blank" data-saferedirecturl="' . $GirisURL . '">' . $GirisURL . '</a> </small></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="m_216102612644868404email-footer" style="color:#7f7f7f;font-size:12px"><tbody><tr><td align="center" valign="top"> © 2019 JustGoTo.me Tüm Hakları Saklıdır.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div></div>';



            // Mail Gönderme İşlemi
            require("class.phpmailer.php");
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = ...; // Hata ayıklama değişkeni: 1 = hata ve mesaj gösterir, 2 = sadece mesaj gösterir
            $mail->SMTPAuth = true; //SMTP doğrulama olmalı ve bu değer değişmemeli
            $mail->SMTPSecure = 'ssl'; // Normal bağlantı için boş bırakın veya tls yazın, güvenli bağlantı kullanmak için ssl yazın
            $mail->Host = "............"; // Mail sunucusunun adresi (IP de olabilir)
            $mail->Port = ...; // Normal bağlantı için 587, güvenli bağlantı için 465 yazın
            $mail->IsHTML(true);
            $mail->SetLanguage("tr", "phpmailer/language");
            $mail->CharSet  = "utf-8";
            $mail->Username = "..."; // Gönderici adresiniz (e-posta adresiniz)
            $mail->Password = "..."; // Mail adresimizin sifresi
            $mail->SetFrom("...", "JustGoToMe"); // Mail atıldığında gorulecek isim ve email
            $mail->AddAddress($rpwMail); // Mailin gönderileceği alıcı adres
            $mail->Subject = $rpwKonu; // Email konu başlığı
            $mail->Body = $rpwMesaj; // Mailin içeriği
            if (!$mail->Send()) {
                echo "xGönderimde bir hata oluştu! Lütfen IT Ekibine başvurunuz. Hata Bilgisi: " . $mail->ErrorInfo;
            } else {
                // şifreleme
                $rpwNewPwCrypt = password_hash(md5($rpwNewPw), PASSWORD_DEFAULT);

                $query = $db->prepare("UPDATE accounts_table SET ACCOUNT_PASSWORD=? WHERE ACCOUNT_ID=?");
                $thisquery = $query->execute(array($rpwNewPwCrypt, $rpwUserID));
                if ($thisquery) {
                    echo "vŞifre Sıfırlandı! Kullanıcı Mail adresini kontrol etmesi Gerekli!";
                } else {
                    "xKullanıcının Yeni şifresi işlenirken bir Hata oluştu! Lütfen Kullanıcı gönderilen maili dikkate almasın! İsterseniz IT Ekibiyle iletişime geçebilirsiniz.";
                }
            }
        } else {
            echo "xBu bilgilere ait bir kullanıcı yok! Lütfen Doğru bilgileri giriniz!";
        }
}

// Member Edit Save - Üye Düzenle Kaydet >
if (g('process') == 'memEditSave') {


    // Değişkenleri tanımla
    $memUserID = LgnP('memUserid');
    $memUsername = LgnP('memUsername');
    $memRank = LgnP('memRank');
    $memNickname = LgnP('memNickname');
    $memName = LgnP('memName');
    $memSurname = LgnP('memSurname');
    $memMail = LgnP('memMail');
    $memBirthday = LgnP('memBirthday');


    // Önceki Kullanıcı Bilgilerini Çekme
    $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query->execute(array($memUserID));
    $thequery = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($thequery as $queryresult)
        if (@$thequery) {


            // Boş input Kontrolü
            if (empty($memUsername)) {
                echo "xLütfen bir Kullanıcı Adı giriniz!";
            } elseif (strlen($memUsername) <= 3 || strlen($memUsername) >= 19) {
                echo "xKullanıcı Adı en az 4, en fazla 18 karakter olmalı!";
            } elseif (ctype_alnum($memUsername) == false) {
                echo "xKullanıcı Adı sadece harf(A-Z) ve numaralardan(0-9) oluşmalıdır!<br> Ve boşluk olmamalıdır!";
            } elseif (haveAnotherUser($db, $memUserID, $memUsername) == 1) {
                echo "x' " . $memUsername . " ' Kullanıcı Adı başkası tarafından kullanılıyor.<br>Lütfen başka bir Kullanıcı Adı giriniz!";
            } elseif (empty($memRank)) {
                echo "xLütfen Rütbesini Seçiniz!";
            } elseif (empty($memNickname)) {
                echo "xLütfen bir Takma Ad giriniz!";
            } elseif (empty($memName)) {
                echo "xLütfen Kullanıcının Adını giriniz!";
            } elseif (empty($memSurname)) {
                echo "xLütfen Kullanıcının Soyadını giriniz!";
            } elseif (empty($memMail)) {
                echo "xLütfen geçerli bir Mail adresi giriniz!";
            } elseif (emailcontrol($memMail) == NULL) {
                echo "xLütfen geçerli bir Mail adresi giriniz!";
            } elseif (empty($memBirthday)) {
                echo "xLütfen Kullanıcının Doğum Tarihini giriniz!";
            } elseif (yascontrol($memBirthday) == NULL) {
                echo "xOops.. Kullanıcının 18 yaşından büyük olması gerekmektedir...";
            } else {

                // Küçük harf
                $memUsername = strtolower($memUsername);
                $memMail = strtolower($memMail);

                // büyük harf
                $memSurname = strtoupper($memSurname);

                // ilk harfler büyük
                $memName = mb_convert_case(mb_strtolower($memName), MB_CASE_TITLE, "UTF-8");

                $query = $db->prepare(" UPDATE accounts_table SET ACCOUNT_USERNAME=?, ACCOUNT_NICKNAME=?, ACCOUNT_NAME=?, ACCOUNT_SURNAME=?, ACCOUNT_BIRTHDAY=?, ACCOUNT_MAIL=?, ACCOUNT_RANK=?  WHERE ACCOUNT_ID='$memUserID' ");
                $thisquery = $query->execute(array($memUsername, $memNickname, $memName, $memSurname, $memBirthday, $memMail, $memRank));

                if ($thisquery) {
                    echo "vProfil Güncellendi!";
                } else {
                    echo "xHata! Lütfen Sayfayı yenileyip tekrar deneyiniz yada IT Ekibiyle görüşünüz!";
                }
            }
        } else {
            echo "xBu bilgilere ait bir kullanıcı yok! Lütfen Doğru bilgileri giriniz!";
        }
}

// Member Delete - Üye Sil >
if (g('process') == 'MemberDelete') {


    // Değişkenler
    $memUserid = LgnP('memUserid');


    $query = $db->prepare(" DELETE FROM adres_table WHERE DB_ADRES_CREATOR=? ");
    $query = $query->execute(array($memUserid));
    $query = $db->prepare(" DELETE FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query = $query->execute(array($memUserid));

    if ($query) {
        echo "vKullanıcı Silindi!";
    } else {
        echo "xKişi Silinemedi! Lütfen Sayfayı yenileyip tekrar deneyiniz yada IT Ekibine bildiriniz...";
    }
}

// Admin Links Save - Admin Linkler Kaydet >
if (g('process') == 'AdminLinkSave') {

    // Değişkenleri Ata
    $dbid = p('dbid');
    $kisaAdres = specishort(p('kisaAdres'));
    $randomKey = p('randomKey');
    $uzunAdres = p('uzunAdres');
    $linkOwnerUsername = p('linkOwner');

    // İşlem

    // Linkin Sahibi ID Bulma
    $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_USERNAME=? ");
    $query->execute(array($linkOwnerUsername));
    $thisquery = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($thisquery as $queryresult);

    if ($thisquery || empty($linkOwnerUsername)) { 
        // Kullanıcı ID'si
        $linkOwnerID = $queryresult['ACCOUNT_ID'];
        
        // uzun adres girilmediyse
        if (empty($uzunAdres)) {
            echo "xLütfen kısaltmak istediğiniz uzun adresi giriniz";
        } elseif (!filter_var($uzunAdres, FILTER_VALIDATE_URL) !== false) {
            echo ("xLütfen Geçerli bir Link Adresi giriniz!<br>ve Başında'http://' yazdığınızdan emin olunuz!");
        } elseif(empty($kisaAdres)) {

            // bu kısa adres varmı kontrolü yap!
            $query2 = $db->prepare("SELECT * FROM adres_table WHERE DB_ADRES_KISA=?");
            $query2->execute(array($randomKey));
            $thisquery2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            foreach ($thisquery2 as $queryresult2);

            if ($thisquery2) {
                $randomKey = $randomKey . rand(0, 999);

                // bu kısa adres varmı kontrolü yap!
                $query3 = $db->prepare("SELECT * FROM adres_table WHERE DB_ADRES_KISA=?");
                $query3->execute(array($randomKey));
                $thisquery3 = $query3->fetchAll(PDO::FETCH_ASSOC);
                foreach ($thisquery3 as $queryresult3);
                if ($thisquery3) {
                    echo "xBir hata oluştu lütfen sayfayı yenileyip tekrar deneyiniz!";
                } else { // Güncelle
                    echo AdminLinkGuncelle($dbid, $uzunAdres, $randomKey, $linkOwnerID);
                }
            } else { // Güncelle
                echo AdminLinkGuncelle($dbid, $uzunAdres, $randomKey, $linkOwnerID);
            }
        } else { // Güncelle
            echo AdminLinkGuncelle($dbid, $uzunAdres, $kisaAdres, $linkOwnerID);
        }

    } else {
        echo "xBöyle bir kullanıcı yok! (kullanıcı adı olmalı!)<br>Eğer kullanıcı seçmek istemiyorsanız boş bırakabilirsiniz!";
    }
}

// Güncelle Fonksiyonu
function AdminLinkGuncelle($e, $e1, $e2, $e3)
{
    include "adminconnectdb.php";
    $query = $db->prepare("UPDATE adres_table SET DB_ADRES_UZUN=?, DB_ADRES_KISA=?, DB_ADRES_CREATOR=? WHERE DB_ADRES_ID ='$e' ");
    $thequery = $query->execute(array($e1, $e2, $e3));
    if ($thequery) {
        return "vLink başarıyla güncellendi!";
    } else {
        return "xLink güncellenirken bir hata oluştu!";
    }
}

// Link Delete - Link Sil >
if (g('process') == 'AdminLinkDelete') {

    // Değişkenler
    $dbid = p('dbid');

    $query = $db->prepare(" DELETE FROM adres_table WHERE DB_ADRES_ID=? ");
    $query = $query->execute(array($dbid));

    if ($query) {
        echo "vLink Silindi!";
    } else {
        echo "xLink Silinemedi! Lütfen Sayfayı yenileyip tekrar deneyiniz yada IT Ekibine bildiriniz...";
    }
}