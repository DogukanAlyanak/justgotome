<?php
include "session.php";

// Veriyi Temizle Veritabanının gereksiz indislerinden Ayıran Fonksiyon
function temiz($text)
    $text = preg_replace('/&nbsp;/', '', $text);
    return $text;
}


// Get İşlemini Gerçekleştiren Fonksiyon
function g($par)
{
    $par = temiz(@$_GET[$par]);
    return $par;
}

// Post İşlemini Gerçekleştiren Fonksiyon
function p($par)
{
    $par = addslashes(trim($_POST[$par]));
    return $par;
}

// Yönlendiren Fonksiyon
function git($par)
{
    header("Location:{$par}");
}

// Login Veriyi Temizle Veritabanının gereksiz indislerinden Ayıran Fonksiyon
function temizLogin($text)
{
    $text = strip_tags($text);
    $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
    $text = preg_replace('/<!--.+?-->/', '', $text);
    $text = preg_replace('/{.+?}/', '', $text);
    $text = preg_replace('/&nbsp;/', '', $text);
    $text = preg_replace('/&amp;/', '', $text);
    $text = preg_replace('/&quot;/', '', $text);
    $text = htmlspecialchars($text);
    $text = addslashes($text);
    return $text;
}

// Login Get İşlemini Gerçekleştiren Fonksiyon
function LgnG($par)
{
    $par = temizLogin(@$_GET[$par]);
    return $par;
}

// LoginPost İşlemini Gerçekleştiren Fonksiyon
function LgnP($par)
{
    $par = htmlspecialchars(addslashes(trim($_POST[$par])));
    return $par;
}

// Session Fonksiyon
function s($par)
{
    if (empty($par)) {
        echo "";
    } else {
        @$session = $_SESSION[$par];
        return $session;
    }
}


// reCaptcha Fonksiyon
function reCaptcha($response)
{
    $BuSiteURLname = $_SERVER['HTTP_HOST'];
    $RCsiteKey = "/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!";
    $RChideKey = "/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!";
    $fields = [
        'secret' => strval($RChideKey),
        'response' => $response
    ];

    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($fields),
        CURLOPT_RETURNTRANSFER => true
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}



// Tarih okuma düzeltme Örnek: 25/01/2010
function DateRead($e)
{
    $thisDate = explode("-", $e);
    $e = $thisDate[2] . "/" . $thisDate[1] . "/" . $thisDate[0];
    return $e;
}

// Tarih okuma Yazılı düzeltme Örnek: 25 Ocak 2010
function DateRead2($e)
{
    $thisDate = explode("-", $e);

    if ($thisDate[1] == "01") {
        $thisDate[1] = "Ocak";
    } elseif ($thisDate[1] == "02") {
        $thisDate[1] = "Şubat";
    } elseif ($thisDate[1] == "03") {
        $thisDate[1] = "Mart";
    } elseif ($thisDate[1] == "04") {
        $thisDate[1] = "Nisan";
    } elseif ($thisDate[1] == "05") {
        $thisDate[1] = "Mayıs";
    } elseif ($thisDate[1] == "06") {
        $thisDate[1] = "Haziran";
    } elseif ($thisDate[1] == "07") {
        $thisDate[1] = "Temmuz";
    } elseif ($thisDate[1] == "08") {
        $thisDate[1] = "Ağustos";
    } elseif ($thisDate[1] == "09") {
        $thisDate[1] = "Eylül";
    } elseif ($thisDate[1] == "10") {
        $thisDate[1] = "Ekim";
    } elseif ($thisDate[1] == "11") {
        $thisDate[1] = "Kasım";
    } elseif ($thisDate[1] == "12") {
        $thisDate[1] = "Aralık";
    }

    $e = $thisDate[2] . " " . $thisDate[1] . " " . $thisDate[0];
    return $e;
}

// Kayıt Tarihi Okuma Düzeltme Örnek: 31 Temmuz 2019 - 13:18
function KayitDR($e)
{
    $TarihSaat = explode(" ", $e);
    $Tarih = DateRead2($TarihSaat[0]);
    $Saat = explode(":",  $TarihSaat[1]);
    $Saat = $Saat[0] . ":" . $Saat[1];
    $e = $Tarih . " - " . $Saat;
    return $e;
}


// Bu kullanıcı Adıyla biri var mı?
function haveAnotherUser($db, $EditpUserID, $EditpUsername)
{

    // Girilen Kullanıcı Adını Veritabanında Kontrol Etme Bilgilerini Çekme
    $AccsUC = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_USERNAME=? ");
    $AccsUC->execute(array($EditpUsername));
    $tAccUC = $AccsUC->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tAccUC as $tAccfUC)

        if ($tAccfUC['ACCOUNT_ID']) {
            if ($EditpUserID == $tAccfUC['ACCOUNT_ID']) {
                return false; // sıkıntı yok kardeş böyle bi kullanıcı adı var ama o zaten sensin bebek. ;)
            } else {
                return true;
            }
        } else {
            return false; // Bu kullanıcı adı boşta devamm...
        }
}

//E-Mail Kontrol
function emailcontrol($e)
{
    if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

// Yaş kontrol
function yascontrol($e)
{
    $birthDate = explode("/", $e);
    @$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
    if ($age <= 17) {
        return false;
    } else {
        return true;
    }
}

// Yetki Kontrol
function yetki($e)
{
    if ($e == "owner" || $e == "admin") {
        return "verified";
    } else {
        return false;
    }
}

// User Kontrol
function userKontrol($e)
{
    if ($e == "user" || $e == "premium" || $e == "vip" || $e == "owner" || $e == "admin") {
        return "verified";
    } else {
        return false;
    }
}

// VIP Kontrol
function vipKontrol($e)
{
    if ($e == "premium" || $e == "vip" || $e == "owner" || $e == "admin") {
        return "verified";
    } else {
        return false;
    }
}

// Special Url Kontorol
function specialurl($e1, $e2)
{
    if ($e1 == "premium" || $e1 == "vip" || $e1 == "owner" || $e1 == "admin") {
        return '<div id="specialURLarea" class="input-group mb-3"> <div class="input-area"> <span class="glyphicon glyphicon-link"></span> <span>' . $e2 . '/</span> <input href="#" class="text" id="specialURL" class="form-control" aria-describedby="basic-addon3" placeholder="OzelUzanti" name="specialURL"> </div></div>';
    } else {
        return false;
    }
}

// Special Url Edit Kontorol
function specialurlEdit($e1, $e2, $e3)
{
    if ($e1 == "premium" || $e1 == "vip" || $e1 == "owner" || $e1 == "admin") {
        return '<div id="specialURLarea" class="input-group mb-3"> <div class="input-area"> <span class="glyphicon glyphicon-link"></span> <span>' . $e2 . '/</span> <input value="' . $e3 . '" href="#" class="text" id="EditSpecialURL" class="form-control" aria-describedby="basic-addon3" placeholder="OzelUzanti" name="EditSpecialURL"> </div></div>';
    } else {
        return false;
    }
}

//VIP - PREMIUM Kontrol
function vipctrl($e)
{
    if ($e == "premium" || $e == "vip" || $e == "owner" || $e == "admin") {
        return "verified";
    } else {
        return false;
    }
}

// Sadece Kelime ve Numaraya Çevir
function justwordnum($e)
{
    return preg_replace("/[^a-zA-Z0-9\s+]+/", "", $e);
}

// Türkçe harfleri ve İngilizce harflere Çevir
function wordtrtoeng($e)
{
    $e = trim($e);
    $search = array('Ç', 'ç', 'Ğ', 'ğ', 'I', 'ı', 'İ', 'i', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' ');
    $replace = array('C', 'c', 'G', 'g', 'I', 'i', 'I', 'i', 'O', 'o', 'S', 's', 'U', 'u', '-');
    return str_replace($search, $replace, $e);
}

// kabul edilebilir bir uzantı oluştur
function specishort($e)
{
    $e = wordtrtoeng($e);
    $e = justwordnum($e);
    if ($e) {
        if (

            $e == "yonetim" ||
            $e == "test" ||
            $e == "kiler" ||
            $e == "core" ||
            $e == ".well-known" ||
            $e == ".htaccess" ||
            $e == "editprofile" ||
            $e == "go" ||
            $e == "index" ||
            $e == "linkedit" ||
            $e == "list" ||
            $e == "login" ||
            $e == "profile" ||
            $e == "editpassword" ||
            $e == "resetpass" ||
            $e == "support" ||
            $e == "signup"

        ) {
            return false;
        } else {
            return $e;
        }
    } else {
        return false;
    }
}

// Ziyaretçi Sayısı arttır
function visitSayEkle()
{

    include "core/modules/connectdb.php";

    date_default_timezone_set('Etc/GMT-3');
    $BugunTarih = date("Y-m-d");
    $query = $db->prepare("SELECT * FROM sayac_home_visits WHERE VISIT_DATE=? ");
    $query->execute(array($BugunTarih));
    $thisquery = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($thisquery as $queryresult);
    if (@$queryresult['VISIT_DATE'] == $BugunTarih) {
        $Sayac = intval($queryresult['VISIT_COUNT']);
        $Sayac = ++$Sayac;
        $query = $db->prepare("UPDATE sayac_home_visits SET VISIT_COUNT=? WHERE VISIT_DATE=? ");
        $thisquery = $query->execute(array($Sayac, $BugunTarih));
    } else {
        $query = $db->prepare("INSERT INTO sayac_home_visits SET VISIT_DATE=?, VISIT_COUNT=? ");
        $thisquery = $query->execute(array($BugunTarih, 1));
    }
    return;
}

// Shortoner Link - Kısaltılmış link Sayacı Sayısı arttır
function ShortenerSayEkle()
{

    include "connectdb.php";

    date_default_timezone_set('Etc/GMT-3');
    $BugunTarih = date("Y-m-d");
    $query = $db->prepare("SELECT * FROM sayac_home_shortenerlinks WHERE SHORTENER_DATE=? ");
    $query->execute(array($BugunTarih));
    $thisquery = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($thisquery as $queryresult);
    if (@$queryresult['SHORTENER_DATE'] == $BugunTarih) {
        $Sayac = intval($queryresult['SHORTENER_COUNT']);
        $Sayac = ++$Sayac;
        $query = $db->prepare("UPDATE sayac_home_shortenerlinks SET SHORTENER_COUNT=? WHERE SHORTENER_DATE=? ");
        $thisquery = $query->execute(array($Sayac, $BugunTarih));
    } else {
        $query = $db->prepare("INSERT INTO sayac_home_shortenerlinks SET SHORTENER_DATE=?, SHORTENER_COUNT=? ");
        $thisquery = $query->execute(array($BugunTarih, 1));
    }
    return;
}
