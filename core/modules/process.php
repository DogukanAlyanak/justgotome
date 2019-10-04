<?php
// Gerekli Bağlantıları Çek
include "connectdb.php";
include "function.php";
include "session.php";
include "config.php";

// Adres Ekle işlem emri geldiğinde
if (g('process') == 'AdresEkle') {

    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        echo 'xMR Robot? Üzgünüm, sadece insanlara hizmet veriyoruz...';
    } else {

        $result = reCaptcha($_POST['g-recaptcha-response']);
        if ($result['success'] == 1) {

            // Değişkenleri tanımla
            $LongURL = p('longURL');
            $specialURL = specishort(p('specialURL'));
            $shortUserID = s('user_id');
            if (vipctrl(s('user_rank'))) {
                if (empty($specialURL)) {
                    $shortURL = p('shorturl');
                } else {
                    $shortURL = $specialURL;
                }
            } else {
                $shortURL = p('shorturl');
            }

            if (empty($LongURL)) {
                echo "xLütfen kısaltmak istediğiniz URL'yi girin!";
            } elseif (!filter_var($LongURL, FILTER_VALIDATE_URL) !== false) {
                echo ("xLütfen Geçerli bir Link Adresi giriniz!<br>ve Başında'http://' yazdığınızdan emin olunuz!");
            } else {
                $shortURLctr = $db->prepare(" SELECT * FROM adres_table WHERE DB_ADRES_KISA=? ");
                $shortURLctr->execute(array($shortURL));
                $stURLctr = $shortURLctr->fetchAll(PDO::FETCH_ASSOC);
                if ($stURLctr) {
                    $shortURL = $shortURL . rand(1, 100);
                    $shortURLEkle = $db->prepare("INSERT INTO adres_table SET DB_ADRES_UZUN=?, DB_ADRES_KISA=?, DB_ADRES_CREATOR=?, DB_ADRES_HIT=?");
                    $sserEkle = $shortURLEkle->execute(array($LongURL, $shortURL, $shortUserID, 0));
                    if ($sserEkle) {
                        ShortenerSayEkle();
                        echo $BuSiteURLname . "/" . $shortURL;
                    } else {
                        echo "xKayıt sırasında bi Hata oluştu! Lütfen Yetkililere durumu bildiriniz!";
                    }
                } else {
                    $shortURLEkle = $db->prepare("INSERT INTO adres_table SET DB_ADRES_UZUN=?, DB_ADRES_KISA=?, DB_ADRES_CREATOR=?, DB_ADRES_HIT=?");
                    $sserEkle = $shortURLEkle->execute(array($LongURL, $shortURL, $shortUserID, 0));
                    if ($sserEkle) {
                        ShortenerSayEkle();
                        echo "v" . $BuSiteURLname . "/" . $shortURL;
                    } else {
                        echo "xKayıt sırasında bi Hata oluştu! Lütfen Yetkililere durumu bildiriniz!";
                    }
                }
            }
        } else {
            echo 'xSen bi sayfayı yenile, Bozdun siteyi :)';
        }
    }
}

// Login-Giriş Emri geldiğinde
if (LgnG('process') == 'Giris') {

    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        echo 'xMR Robot? Üzgünüm, sadece insanlara hizmet veriyoruz...';
    } else {

        $result = reCaptcha($_POST['g-recaptcha-response']);
        if ($result['success'] == 1) {

            // Değişkenleri tanımla
            $LoginUsername = LgnP('LoginUsername');
            $LoginPw = LgnP('LoginPw');

            // Login Kontrol İşlemleri
            if (empty($LoginUsername)) {
                echo "xLütfen bir kullanıcı adı giriniz!";
            } elseif (empty($LoginPw)) {
                echo "xLütfen şifrenizi giriniz!";
            } else {
                // Login Kullanıcı Bilgilerini çek
                $LoginUser = $db->prepare("SELECT * FROM accounts_table WHERE ACCOUNT_USERNAME=? OR ACCOUNT_MAIL=? ");
                // Verileri diziye çek eşleştir
                $LoginUser->execute(array($LoginUsername, $LoginUsername));
                // Çekilmiş Verileri indislerinden ayır
                $LGUser = $LoginUser->fetchAll(PDO::FETCH_ASSOC);
                // Veriyi say (var mı? gibi)
                $say = $LoginUser->rowCount();
                // Kullanıcı Bilgilerini Çek
                foreach ($LGUser as $UserInfs);
                // Etkilenen Bir Satır Varsa

                if ($say) {
                    if ($UserInfs['ACCOUNT_BANCONTROL'] == NULL || $UserInfs['ACCOUNT_RANK'] == "owner") {
                        if (password_verify(/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/($LoginPw), $UserInfs['ACCOUNT_PASSWORD'])) {
                            if ($UserInfs['ACCOUNT_RANK'] == "premium" || "vip" || "owner" || "admin" || "user") {
                                echo "v<meta http-equiv='refresh' content='1;URL=" . $BuSiteURL . "'>";
                                echo "Giriş Başarılı!";
                                $_SESSION['user_id'] = $UserInfs['ACCOUNT_ID'];
                                $_SESSION['user_username'] = $UserInfs['ACCOUNT_USERNAME'];
                                $_SESSION['user_name'] = $UserInfs['ACCOUNT_NAME'];
                                $_SESSION['user_surname'] = $UserInfs['ACCOUNT_SURNAME'];
                                $_SESSION['user_nick'] = $UserInfs['ACCOUNT_NICKNAME'];
                                $_SESSION['user_rank'] = $UserInfs['ACCOUNT_RANK'];
                            } else {
                                echo "xKullanıcı adı veya şifre hatalı!";
                            }
                        } else {
                            echo "xKullanıcı adı veya şifre hatalı!";
                        }
                    } elseif ($UserInfs['ACCOUNT_BANCONTROL'] == "perma") {
                        echo "xHesabınız Sonsuz Süreyle Engellenmiştir!";
                    } else {
                        echo "xHesabınız " . DateRead2($UserInfs['ACCOUNT_BANCONTROL']) . " Tarihine Kadar Engellenmiştir!";
                    }
                } else {
                    echo "xKullanıcı adı veya şifre hatalı!";
                }
            }
        } else {
            echo 'xSen bi sayfayı yenile, Bozdun siteyi :)';
        }
    }
}

// Logout Çıkış Emri Gelidiğinde
if (LgnG('process') == 'Cikis') {
    session_destroy();
    git($BuSiteURL);
}

// Signup Emri Geldiğinde
if (LgnG('process') == 'Signup') {

    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        echo 'xMR Robot? Üzgünüm, sadece insanlara hizmet veriyoruz...';
    } else {

        $result = reCaptcha($_POST['g-recaptcha-response']);
        if ($result['success'] == 1) {

            // Değişkenleri tanımla
            $SignupUserID = LgnP('SignupUserID');
            $SignupUsername = LgnP('SignupUsername');
            $SignupPassword = LgnP('SignupPassword');
            $SignupPasswordConfirm = LgnP('SignupPasswordConfirm');
            $SignupNickname = LgnP('SignupNickname');
            $SignupName = LgnP('SignupName');
            $SignupSurname = LgnP('SignupSurname');
            $SignupMail = LgnP('SignupMail');
            $SignupBirthday = LgnP('SignupBirthday');
            $SignupRank = "user";

            // Signup Kontrol İşlemleri
            if (empty($SignupUsername)) {
                echo "xLütfen bir Kullanıcı Adı giriniz!";
            } elseif (strlen($SignupUsername) <= 3 || strlen($SignupUsername) >= 19) {
                echo "xKullanıcı Adı en az 4, en fazla 18 karakter olmalı!";
            } elseif (ctype_alnum($SignupUsername) == false) {
                echo "xKullanıcı Adı sadece harf(A-Z) ve numaralardan(0-9) oluşmalıdır!<br> ve boşluk olmamalıdır!";
            } else {
                $Accounts = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_USERNAME=? ");
                $Accounts->execute(array($SignupUsername));
                $Account = $Accounts->fetchAll(PDO::FETCH_ASSOC);

                $MAccounts = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_MAIL=? ");
                $MAccounts->execute(array($SignupMail));
                $MAccount = $MAccounts->fetchAll(PDO::FETCH_ASSOC);
                if ($Account) {
                    echo "xBu Kullanıcı Adı zaten kullanılıyor!";
                } elseif ($MAccount) {
                    echo "xBu Mail Adresi zaten kayıtlı! Lütfen başka bir Mail Adresi giriniz!";
                } else {
                    if (empty($SignupPassword)) {
                        echo "xLütfen bir şifre giriniz!";
                    } elseif (strlen($SignupPassword) <= 7 || strlen($SignupPassword) >= 19) {
                        echo "xŞifreniz en az 8, en fazla 18 karakter olmalı!";
                    } elseif (empty($SignupPasswordConfirm)) {
                        echo "xLütfen bir bir önceki alana girdiğiniz şifrenin aynısını giriniz!";
                    } elseif ($SignupPassword != $SignupPasswordConfirm) {
                        echo "xLütfen bir bir önceki alana girdiğiniz şifrenin aynısını giriniz!";
                    } elseif (empty($SignupNickname)) {
                        echo "xLütfen bir Takma Ad giriniz!";
                    } elseif (empty($SignupName)) {
                        echo "xLütfen İsminizi giriniz!";
                    } elseif (empty($SignupSurname)) {
                        echo "xLütfen Soyisminizi giriniz!";
                    } elseif (empty($SignupMail)) {
                        echo "xLütfen geçerli bir Mail adresi giriniz!";
                    } elseif (filter_var($SignupMail, FILTER_VALIDATE_EMAIL)) {
                        if (empty($SignupBirthday)) {

                            echo "xLütfen Doğum Tarihinizi giriniz!";
                        } else {
                            //explode the date to get month, day and year
                            $birthDate = explode("/", $SignupBirthday);
                            //get age from date or birthdate
                            @$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
                            if ($age <= 17) {
                                echo "xOops.. Üye olmak için 18 yaşından büyük olmanız gerekmektedir...";
                            } else {
                                $AccountsAydi = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
                                $AccountsAydi->execute(array($SignupUserID));
                                $AccAydi = $AccountsAydi->fetchAll(PDO::FETCH_ASSOC);
                                if ($AccAydi) {
                                    echo "xMilyonda bir ihtimali tutturdun gerçekten tebrikler :) Bir daha bas bakayım şu Üye ol tuşuna hele :)";
                                } else {

                                    // şifreleme
                                    $zzSfre = password_hash(md5($SignupPasswordConfirm), PASSWORD_DEFAULT);

                                    // Küçük harf
                                    $SignupUsername = strtolower($SignupUsername);
                                    $SignupMail = strtolower($SignupMail);

                                    // büyük harf
                                    $SignupSurname = strtoupper($SignupSurname);

                                    // ilk harfler büyük
                                    $SignupName = mb_convert_case(mb_strtolower($SignupName), MB_CASE_TITLE, "UTF-8");

                                    $AccountEkle = $db->prepare("INSERT INTO accounts_table SET ACCOUNT_ID=?, ACCOUNT_USERNAME=?, ACCOUNT_PASSWORD=?, ACCOUNT_RANK=?, ACCOUNT_NICKNAME=?, ACCOUNT_NAME=?, ACCOUNT_SURNAME=?, ACCOUNT_BIRTHDAY=?, ACCOUNT_MAIL=?");
                                    $AccEkle = $AccountEkle->execute(array($SignupUserID, $SignupUsername, $zzSfre, $SignupRank, $SignupNickname, $SignupName, $SignupSurname, $SignupBirthday, $SignupMail));
                                    if ($AccEkle) {
                                        echo " Kayıt Başarılı! <meta http-equiv='refresh' content='0;URL=" . $BuSiteURL . "'>";
                                        $_SESSION['user_id'] = $SignupUserID;
                                        $_SESSION['user_username'] = $SignupUsername;
                                        $_SESSION['user_name'] = $SignupName;
                                        $_SESSION['user_surname'] = $SignupSurname;
                                        $_SESSION['user_nick'] = $SignupNickname;
                                        $_SESSION['user_rank'] = $SignupRank;
                                        echo "Hoşgeldin " . s("user_name");
                                    } else {
                                        echo "xKayıt sırasında bi hata oluştu! Lütfen Yetkililere durumu bildiriniz!";
                                    }
                                }
                            }
                        }
                    } else {
                        echo "xLütfen geçerli bir Mail adresi giriniz!";
                    }
                }
            }
        } else {
            echo 'xSen bi sayfayı yenile, Bozdun siteyi :)';
        }
    }
}

// Link Silme İşlemi Kontrol Fonksiyonu
if (g('process') == 'LinkSil') {
    $LinkSil = $db->prepare("DELETE FROM adres_table WHERE DB_ADRES_KISA=?");
    $LSilme = $LinkSil->execute(array(g('kisaURL')));
    if ($LSilme) {
        echo git($ListemURL);
        echo "<script>alert('Sildi!')</script>";
    } else {
        echo git($ListemURL);
        echo "<script>alert('Silinemedi!')</script>";
    }
}

// Veri Günceller İşlemi Kontrol Fonksiyonu
if (g('process') == 'LinkGuncelle') {
    $shortURLadresSon = p('UzunLink');
    $EditLinkKA = s('sonkisa_link');
    $Editor = s('user_id');
    if (vipctrl(s('user_rank'))) {
        if (empty(specishort(p('EditSpecialURL')))) {
            $newShorURL = s('sonkisa_link');
        } else {
            $newShorURL = specishort(p('EditSpecialURL'));
        }
    } else {
        $newShorURL = s('sonkisa_link');
    }

    if (empty($shortURLadresSon)) {
        echo "xDeğiştireceğiniz linke geçerli bir adres girmelisiniz!";
    } elseif (empty($EditLinkKA)) {
        echo "xHata! Lütfen tekrar deneyiniz yada bir yetkiliyle görüşünüz!";
    } elseif (!filter_var($shortURLadresSon, FILTER_VALIDATE_URL) !== false) {
        echo ("xLütfen Geçerli bir Link Adresi giriniz!<br>ve Başında'http://' yazdığınızdan emin olunuz!");
    } else {
        $Linkguncelle = $db->prepare("UPDATE adres_table SET DB_ADRES_UZUN=?, DB_ADRES_KISA=? WHERE DB_ADRES_KISA='$EditLinkKA' AND DB_ADRES_CREATOR='$Editor' ");
        $Lnkgnc = $Linkguncelle->execute(array($shortURLadresSon, $newShorURL));
        if ($Lnkgnc) {
            echo "vLink Güncellendi!";
            echo "<meta http-equiv='refresh' content='2;URL=" . $ListemURL . "'>";
        } else {
            echo "xHata! Lütfen tekrar deneyiniz yada bir yetkiliyle görüşünüz!";
        }
    }
}

// Edit Profil - Profil Düzenle Kaydet İşlemi
if (g('process') == 'profilEdit') {

    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        echo 'xMR Robot? Üzgünüm, sadece insanlara hizmet veriyoruz...';
    } else {

        $result = reCaptcha($_POST['g-recaptcha-response']);
        if ($result['success'] == 1) {

            // Değişkenleri tanımla
            $EditpUserID = s('user_id');
            $EditpPassword = LgnP('editProfilPassword');
            $EditpUsername = LgnP('editProfilUsername');
            $EditpNickname = LgnP('editProfilNickname');
            $EditpName = LgnP('editProfilName');
            $EditpSurname = LgnP('editProfilSurname');
            $EditpMail = LgnP('editProfilMail');
            $EditpBirthday = LgnP('editProfilBirthday');

            // Önceki Kullanıcı Bilgilerini Çekme
            $Accs = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
            $Accs->execute(array($EditpUserID));
            $tAcc = $Accs->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tAcc as $tAccf)




                // Boş input Kontrolü
                if (empty($EditpPassword)) {
                    echo "xLütfen Şifrenizi Giriniz!";
                } elseif (password_verify(md5($EditpPassword), $tAccf['ACCOUNT_PASSWORD'])) {
                    if (empty($EditpUsername)) {
                        echo "xLütfen bir Kullanıcı Adı giriniz!";
                    } elseif (strlen($EditpUsername) <= 3 || strlen($EditpUsername) >= 19) {
                        echo "xKullanıcı Adı en az 4, en fazla 18 karakter olmalı!";
                    } elseif (ctype_alnum($EditpUsername) == false) {
                        echo "xKullanıcı Adı sadece harf(A-Z) ve numaralardan(0-9) oluşmalıdır!<br> Ve boşluk olmamalıdır!";
                    } elseif (haveAnotherUser($db, $EditpUserID, $EditpUsername) == 1) {
                        echo "x' " . $EditpUsername . " ' Kullanıcı Adı başkası tarafından kullanılıyor.<br>Lütfen başka bir Kullanıcı Adı giriniz!";
                    } elseif (empty($EditpNickname)) {
                        echo "xLütfen bir Takma Ad giriniz!";
                    } elseif (empty($EditpName)) {
                        echo "xLütfen Adınızı giriniz!";
                    } elseif (empty($EditpSurname)) {
                        echo "xLütfen Soyadınızı giriniz!";
                    } elseif (empty($EditpMail)) {
                        echo "xLütfen geçerli bir Mail adresi giriniz!";
                    } elseif (emailcontrol($EditpMail) == NULL) {
                        echo "xLütfen geçerli bir Mail adresi giriniz!";
                    } elseif (empty($EditpBirthday)) {
                        echo "xLütfen Doğum Tarihinizi giriniz!";
                    } elseif (yascontrol($EditpBirthday) == NULL) {
                        echo "xOops.. 18 yaşından büyük olmanız gerekmektedir...";
                    } else {

                        // Küçük harf
                        $EditpUsername = strtolower($EditpUsername);
                        $EditpMail = strtolower($EditpMail);

                        // büyük harf
                        $EditpSurname = strtoupper($EditpSurname);

                        // ilk harfler büyük
                        $EditpName = mb_convert_case(mb_strtolower($EditpName), MB_CASE_TITLE, "UTF-8");

                        $profilGuncelle = $db->prepare(" UPDATE accounts_table SET ACCOUNT_USERNAME=?, ACCOUNT_NICKNAME=?, ACCOUNT_NAME=?, ACCOUNT_SURNAME=?, ACCOUNT_BIRTHDAY=?, ACCOUNT_MAIL=?  WHERE ACCOUNT_ID='$EditpUserID' ");
                        $profGnc = $profilGuncelle->execute(array($EditpUsername, $EditpNickname, $EditpName, $EditpSurname, $EditpBirthday, $EditpMail));

                        if ($profGnc) {
                            echo "vProfil Güncellendi!";
                            echo "<meta http-equiv='refresh' content='2;URL=" . $ProfilURL . "'>";
                        } else {
                            echo "xHata! Lütfen tekrar deneyiniz yada bir yetkiliyle görüşünüz!";
                        }
                    }
                } else {
                    echo "xHatalı Şifre Girdiniz!";
                }
        } else {
            echo 'xSen bi sayfayı yenile, Bozdun siteyi :)';
        }
    }
}

// Profili Sil 
if (g('process') == 'profilDelete') {

    // Değişkenler
    $userid = s('user_id');

    // İşlemler
    $query = $db->prepare(" DELETE FROM adres_table WHERE DB_ADRES_CREATOR=? ");
    $query = $query->execute(array($userid));
    $query = $db->prepare(" DELETE FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query = $query->execute(array($userid));

    if ($query) {
        session_destroy();
        git($BuSiteURL);
    } else {
        alert("Bir hata oluştu lütfen tekrar deneyiniz yada yetkiliye bildiriniz...");
    }
}


// Şifre Sıfırla -  Reset Password
if (g('process') == 'ResetPassword') {

    /* recaptcha area 1 START */

    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        echo 'xMR Robot? Üzgünüm, sadece insanlara hizmet veriyoruz...';
    } else {

        $result = reCaptcha($_POST['g-recaptcha-response']);
        if ($result['success'] == 1) {
            /* recaptcha area 1 END */

            // Değişkenleri Tanımla
            $ResetpwUsername = p('ResetPwUsername');
            $rpwNewPw = p('rpwNewPw');

            // İşlem

            if (empty($ResetpwUsername)) {
                echo "xLütfen Kullanıcı Adınızı veya E-Mailinizi Giriniz!";
            } else {

                // Kontrol işlemleri
                $query = $db->prepare("SELECT * FROM accounts_table WHERE ACCOUNT_USERNAME=? OR ACCOUNT_MAIL=? ");
                $query->execute(array($ResetpwUsername, $ResetpwUsername));
                $thisquery = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($thisquery as $queryresult);
                if ($thisquery) {

                    // Mail Değişkenleri
                    $rpwMail = $queryresult['ACCOUNT_MAIL'];
                    $rpwUser = $queryresult['ACCOUNT_USERNAME'];
                    $rpwNick = $queryresult['ACCOUNT_NICKNAME'];
                    $rpwKonu = $BuSiteName . " - Şifre Sıfırlama";
                    $rpwMesaj = '<div style="background-color:#eee;background-image:none;background-repeat:repeat;background-position:top left;color:#333;font-family:Helvetica,Arial,sans-serif;line-height:1.25"><table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" class="m_216102612644868404body-table"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="20" cellspacing="0" width="600" class="m_216102612644868404outer-email-container"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="m_216102612644868404inner-email-container" style="background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" height="90" width="100%" class="m_216102612644868404email-logo" style="background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left"><tbody><tr><td align="center" valign="middle"> <br><h1> <img src="' . $emailLogoURL . '" height="34" alt="' . $BuSiteName . '" class="CToWUd"> ' . $BuSiteName . '</h1></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" height="1" width="100%" class="m_216102612644868404email-divider"><tbody><tr><td align="center" valign="middle" style="background-color:#eeeeee" width="249"></td><td align="center" valign="middle" style="background-color:#0099ff" width="102"></td><td align="center" valign="middle" style="background-color:#eeeeee" width="249"></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="40" cellspacing="0" height="0" width="100%" class="m_216102612644868404email-header"><tbody><tr><td align="center" valign="middle"> Merhaba ' . $rpwNick . ', Şifreniz Sıfırlanmıştır!</td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" height="0" width="100%" class="m_216102612644868404email-content"><tbody><tr><td align="center" valign="middle"><div class="m_216102612644868404message" style="text-align:left;padding:0 20px 20px;font-size:14px;line-height:1.5;width:80%"><p> Kullanıcı Adınız: ' . $rpwUser . '<br> Yeni Şifreniz: ' . $rpwNewPw . '<br> <br> Eğer şifre sıfırlanması talebinde bulunmadıysanız, <a href="' . $DestekURL . '" target="_blank">Destekle iletişime</a> geçebilirsiniz.</p></div></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="30" cellspacing="0" height="0" width="100%" class="m_216102612644868404email-action" style="border-top-width:1px;border-top-style:solid;border-top-color:#eee"><tbody><tr><td align="center" valign="middle"><div> <a href="' . $GirisURL . '" style="background-color:#0099ff;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:14px;line-height:40px;margin-bottom:10px;text-align:center;text-decoration:none;width:200px" target="_blank"> Giriş </a> <br> <small class="m_216102612644868404alternate-link" style="color:#999;font-size:11px;margin-top:4px;margin-bottom:4px;margin-right:4px;margin-left:4px"> Veya şu bağlantıyı tıklayın: <a href="' . $GirisURL . '" style="color:#999" target="_blank" data-saferedirecturl="' . $GirisURL . '">' . $GirisURL . '</a> </small></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="m_216102612644868404email-footer" style="color:#7f7f7f;font-size:12px"><tbody><tr><td align="center" valign="top"> © 2019 JustGoTo.me Tüm Hakları Saklıdır.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div></div>';



                    // Mail Gönderme İşlemi
                    require("class.phpmailer.php");
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPDebug = 1; // Hata ayıklama değişkeni: 1 = hata ve mesaj gösterir, 2 = sadece mesaj gösterir
                    $mail->SMTPAuth = true; //SMTP doğrulama olmalı ve bu değer değişmemeli
                    $mail->SMTPSecure = 'ssl'; // Normal bağlantı için boş bırakın veya tls yazın, güvenli bağlantı kullanmak için ssl yazın
                    $mail->Host = "mail.justgoto.me"; // Mail sunucusunun adresi (IP de olabilir)
                    $mail->Port = 465; // Normal bağlantı için 587, güvenli bağlantı için 465 yazın
                    $mail->IsHTML(true);
                    $mail->SetLanguage("tr", "phpmailer/language");
                    $mail->CharSet  = "utf-8";
                    $mail->Username = "/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!"; // Gönderici adresiniz (e-posta adresiniz)
                    $mail->Password = "/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!"; // Mail adresimizin sifresi
                    $mail->SetFrom("/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!", "JustGoToMe"); // Mail atıldığında gorulecek isim ve email
                    $mail->AddAddress($rpwMail); // Mailin gönderileceği alıcı adres
                    $mail->Subject = $rpwKonu; // Email konu başlığı
                    $mail->Body = $rpwMesaj; // Mailin içeriği
                    if (!$mail->Send()) {
                        echo "xGönderimde bir hata oluştu! Lütfen Desteğe başvurunuz. Hata Bilgisi: " . $mail->ErrorInfo;
                    } else {
                        // şifreleme
                        $rpwNewPwCrypt = password_hash(/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/($rpwNewPw), PASSWORD_DEFAULT);

                        $query = $db->prepare("UPDATE accounts_table SET ACCOUNT_PASSWORD=? WHERE ACCOUNT_USERNAME=?");
                        $thequery = $query->execute(array($rpwNewPwCrypt, $rpwUser));
                        if ($thequery) {
                            echo "v<meta http-equiv='refresh' content='1;URL=" . $GirisURL . "'>";
                            echo "Şifre Sıfırlandı! Mail adresinizi kontrol ediniz!";
                        } else {
                            "xYeni şifreniz işlenirken bir Hata oluştu! Lütfen gönderilen maili dikkate almayınız! İsterseniz Destek Ekibiyle iletişime geçebilirsiniz.";
                        }
                    }
                } else {
                    echo "xBu bilgilere ait bir kullanıcı yok! Lütfen Doğru bilgileri giriniz!";
                }
            }


            /* recaptcha area 2 START */
        } else {
            echo 'xSen bi sayfayı yenile, Bozdun siteyi :)';
        }
    }
    /* recaptcha area 2 END */
}

// Şifre Değiştir - Edit Password
if (g('process') == 'EditPassword') {

    /* recaptcha area 1 START */

    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        echo 'xMR Robot? Üzgünüm, sadece insanlara hizmet veriyoruz...';
    } else {

        $result = reCaptcha($_POST['g-recaptcha-response']);
        if ($result['success'] == 1) {
            /* recaptcha area 1 END */

            // Değişkenleri Tanımlama
            $OLDpw = LgnP('passeOldPw');
            $NewPw1 = LgnP('passeNewPw1');
            $NewPw2 = LgnP('passeNewPw2');
            $userid = s('user_id');

            // İşlem
            if (empty($OLDpw)) {
                echo "xLütfen Eski Şifrenizi giriniz!";
            } elseif (empty($NewPw1)) {
                echo "xLütfen Yeni bir şifre giriniz!";
            } elseif (empty($NewPw2)) {
                echo "xLütfen Yeni şifrenin aynısını 2. alana yeniden giriniz!";
            } elseif ($NewPw1 != $NewPw2) {
                echo "xLütfen Yeni şifrenin aynısını 2. alana yeniden giriniz!";
            } else {
                $query = $db->prepare("SELECT * FROM accounts_table WHERE ACCOUNT_ID=? "); // Kullanıcı Bilgilerini çek
                $query->execute(array($userid)); // Verileri diziye çek eşleştir
                $thequery = $query->fetchAll(PDO::FETCH_ASSOC); // Çekilmiş Verileri indislerinden ayır
                $say = $query->rowCount(); // Veriyi say (var mı? gibi)
                foreach ($thequery as $queryresult); // Kullanıcı Bilgilerini Çek
                if ($say) { // Etkilenen Bir Satır Varsa
                    if (password_verify(/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/($OLDpw), $queryresult['ACCOUNT_PASSWORD'])) {

                        // şifreleme
                        $NewPw1crypt = password_hash(md5($NewPw1), PASSWORD_DEFAULT);

                        $query = $db->prepare("UPDATE accounts_table SET ACCOUNT_PASSWORD=? WHERE ACCOUNT_ID=?");
                        $thequery = $query->execute(array($NewPw1crypt, $userid));
                        if ($thequery) {
                            echo "vŞifreniz Değiştirildi!";
                            echo "<meta http-equiv='refresh' content='1;URL=" . $ProfilURL . "'>";
                        } else {
                            "xYeni şifreniz işlenirken bir Hata oluştu! İsterseniz Destek Ekibiyle iletişime geçebilirsiniz.";
                        }
                    } else {
                        echo "xEski Şifre Hatalı!";
                    }
                }
            }


            /* recaptcha area 2 START */
        } else {
            echo 'xSen bi sayfayı yenile, Bozdun siteyi :)';
        }
    }
    /* recaptcha area 2 END */
}

// Support Message Send - Destek Mesaj Gönder
if (g('process') == 'SupportMessage') {

    /* recaptcha area 1 START */

    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        echo 'xMR Robot? Üzgünüm, sadece insanlara hizmet veriyoruz...';
    } else {

        $result = reCaptcha($_POST['g-recaptcha-response']);
        if ($result['success'] == 1) {
            /* recaptcha area 1 END */


            // Değişkenleri Tanımlama
            $SMusername = LgnP('SMusername');
            $SMmail = LgnP('SMmail');
            $SMSendMail = "/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!";
            $SMkonu = substr(LgnP('SMkonu'), 0, 70);
            $SMmessage = LgnP('SMmessage');

            // Kontrol // filter_var($SMmail, FILTER_VALIDATE_EMAIL)
            if (empty($SMmail)) {
                echo "xLütfen geçerli bir E-Mail adresi giriniz!";
            } elseif (empty($SMkonu)) {
                echo "xLütfen bir Konu Başlığı giriniz!";
            } elseif (empty($SMmessage)) {
                echo "xLütfen Mesajınızı giriniz!";
            } else {
                if (filter_var($SMmail, FILTER_VALIDATE_EMAIL)) {

                    // Mail Gönderme İşlemi
                    require("class.phpmailer.php");
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPDebug = 1; // Hata ayıklama değişkeni: 1 = hata ve mesaj gösterir, 2 = sadece mesaj gösterir
                    $mail->SMTPAuth = true; //SMTP doğrulama olmalı ve bu değer değişmemeli
                    $mail->SMTPSecure = 'ssl'; // Normal bağlantı için boş bırakın veya tls yazın, güvenli bağlantı kullanmak için ssl yazın
                    $mail->Host = "mail.justgoto.me"; // Mail sunucusunun adresi (IP de olabilir)
                    $mail->Port = 465; // Normal bağlantı için 587, güvenli bağlantı için 465 yazın
                    $mail->IsHTML(true);
                    $mail->SetLanguage("tr", "phpmailer/language");
                    $mail->CharSet  = "utf-8";
                    $mail->Username = "/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!"; // Gönderici adresiniz (e-posta adresiniz)
                    $mail->Password = "/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!"; // Mail adresimizin sifresi
                    $mail->SetFrom("/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!", "JustGoToMe"); // Mail atıldığında gorulecek isim ve email
                    $mail->AddAddress($SMSendMail); // Mailin gönderileceği alıcı adres
                    $mail->addCC($SMmail); //maile CC veya BCC özellikleri katabilirsiniz.
                    $mail->Subject = $SMkonu; // Email konu başlığı
                    $mail->Body = $SMmessage; // Mailin içeriği
                    if (!$mail->Send()) {
                        echo "xGönderimde bir hata oluştu! mail yoluyla iletişime geçebilirsiniz: /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | Hata Bilgisi: " . $mail->ErrorInfo;
                    } else {
                        echo "v<meta http-equiv='refresh' content='6;URL=" . $BuSiteURL . "'>";
                        echo "Destek Talebiniz Oluşturuldu! Destek Ekibimiz en yakın sürede sizinle mail yoluyla iletişime geçecektir.";
                    }
                } else {
                    echo "xLütfen geçerli bir E-Mail adresi giriniz!";
                }
            }


            /* recaptcha area 2 START */
        } else {
            echo 'xSen bi sayfayı yenile, Bozdun siteyi :)';
        }
    }
    /* recaptcha area 2 END */
}
