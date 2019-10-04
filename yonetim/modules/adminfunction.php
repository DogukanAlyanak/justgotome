<?php
//include "adminsession.php";

// Veriyi Temizle Veritabanının gereksiz indislerinden Ayıran Fonksiyon
function temiz($text)
{
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
    $RCsiteKey = "";
    $RChideKey = "";
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

// Tarih okuma düzeltme Örnek: 25-01-2010
function DateRead3($e)
{
    $thisDate = explode("-", $e);
    $e = $thisDate[2] . "-" . $thisDate[1] . "-" . $thisDate[0];
    return $e;
}

// Tarih okuma düzeltme Örnek: 25-01-2010 - 12:17:32
function DateHourRead($e)
{
    $Date = explode(" ", $e);
    $thisDate = explode("-", $Date[0]);
    $e = $thisDate[2] . "-" . $thisDate[1] . "-" . $thisDate[0] . " - " . $Date[1];
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

// bu günün Ziyaretçi Sayısı
function todayVisitSay()
{
    include "adminconnectdb.php";
    date_default_timezone_set('Etc/GMT-3');
    $BugunTarih = date("Y-m-d");
    $query = $db->prepare("SELECT * FROM sayac_home_visits WHERE VISIT_DATE=? ");
    $query->execute(array($BugunTarih));
    $thisquery = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($thisquery as $queryresult);
    if (@$queryresult['VISIT_DATE'] == $BugunTarih) {
        return $queryresult['VISIT_COUNT'];
    } else {
        return "0";
    }
}

// Kullanıcı Sayısı
function userSay()
{
    include "adminconnectdb.php";

    $sayVisits = $db->query(" SELECT * FROM accounts_table ");
    if ($sayVisits->rowCount() == NULL) {
        return "0";
    } else {
        return  $sayVisits->rowCount();
    }
}

// kıslatılan linklerin sayısı
function linkSay()
{
    include "adminconnectdb.php";

    $sayVisits = $db->query(" SELECT * FROM adres_table ");
    if ($sayVisits->rowCount() == NULL) {
        return "0";
    } else {
        return  $sayVisits->rowCount();
    }
}


// toplam ziyaretçi sayısı SELECT SUM(kolonadı) FROM tabloadı
function toplamVisitSay()
{
    include "adminconnectdb.php";

    $query = $db->query("SELECT SUM(VISIT_COUNT) AS toplam FROM sayac_home_visits");
    $query = $query->fetch(PDO::FETCH_ASSOC);
    if ($query["toplam"] == NULL) {
        return "0";
    } else {
        return $query["toplam"];
    }
}

// Ziyaretçi Sayısı
function ogunVisitSay($e)
{
    include "adminconnectdb.php";
    $BugunTarih = $e;
    $query = $db->prepare("SELECT * FROM sayac_home_visits WHERE VISIT_DATE=? ");
    $query->execute(array($BugunTarih));
    $thisquery = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($thisquery as $queryresult);
    if (@$queryresult['VISIT_DATE'] == $BugunTarih) {
        return $queryresult['VISIT_COUNT'];
    } else {
        return "0";
    }
}

// Kısaltılmış Link Sayısı
function ogunShortenerSay($e)
{
    include "adminconnectdb.php";
    $BugunTarih = $e;
    $query = $db->prepare("SELECT * FROM sayac_home_shortenerlinks WHERE SHORTENER_DATE=? ");
    $query->execute(array($BugunTarih));
    $thisquery = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($thisquery as $queryresult);
    if (@$queryresult['SHORTENER_DATE'] == $BugunTarih) {
        return $queryresult['SHORTENER_COUNT'];
    } else {
        return "0";
    }
}

function bugun()
{
    date_default_timezone_set('Etc/GMT-3');
    return date("Y-m-d");
}

function dun()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('Y-m-d', strtotime("-1 day"));
}

function oncekigun()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('Y-m-d', strtotime("-2 day"));
}

function ucgunonce()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('Y-m-d', strtotime("-3 day"));
}

function dortgunonce()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('Y-m-d', strtotime("-4 day"));
}

function besgunonce()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('Y-m-d', strtotime("-5 day"));
}

function altigunonce()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('Y-m-d', strtotime("-6 day"));
}

function bugunGUN()
{
    date_default_timezone_set('Etc/GMT-3');
    return date("l");
}

function dunGUN()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('l', strtotime("-1 day"));
}

function oncekigunGUN()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('l', strtotime("-2 day"));
}

function ucgunonceGUN()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('l', strtotime("-3 day"));
}

function dortgunonceGUN()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('l', strtotime("-4 day"));
}

function besgunonceGUN()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('l', strtotime("-5 day"));
}

function altigunonceGUN()
{
    date_default_timezone_set('Etc/GMT-3');
    return date('l', strtotime("-6 day"));
}

function GUNengTOtr($e)
{
    if ($e == "Monday") {
        return "Pazartesi";
    } elseif ($e == "Tuesday") {
        return "Salı";
    } elseif ($e == "Wednesday") {
        return "Çarşamba";
    } elseif ($e == "Thursday") {
        return "Perşembe";
    } elseif ($e == "Friday") {
        return "Cuma";
    } elseif ($e == "Saturday") {
        return "Cumartesi";
    } elseif ($e == "Sunday") {
        return "Pazar";
    } else {
        return $e;
    }
}

// Rütbe Yeniden Yazma exm: user --> KULLANICI
function rutbeText($e)
{
    if ($e == "user") {
        return "KULLANICI";
    } elseif ($e == "admin") {
        return "YÖNETİCİ";
    } elseif ($e == "owner") {
        return "SAHİP";
    } elseif ($e == "vip") {
        return "V.I.P";
    }
}

// Ban Yeniden Yazma exm: "" --> "BAN YOK", "perma" --> "SONSUZ"
function banText($e)
{
    if ($e == NULL) {
        return "BAN YOK";
    } elseif ($e == "perma") {
        return "<span style='color:red;'>" .
            "SONSUZ" . "<span>";
    } else {
        return "<span style='color:orange;'>" .
            $e . "<span>";
    }
}

function ceoCtrl($e)
{

    include "adminsession.php";
    include "adminconnectdb.php";

    $meID = s('user_id');

    // Kendimi Veritabanında Bi arat hele
    $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query->execute(array($meID));
    $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

    // Seçili Verileri Dizme
    foreach ($thequery as $queryresult)

        // gelen kişiyi Veritabanında Bi arat hele
        $query2 = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
    $query2->execute(array($e));
    $thequery2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    // Seçili Verileri Dizme
    foreach ($thequery2 as $queryresult2)

        if ($thequery) {
            if ($thequery2) {
                // Bak hele RANKına
                $meRank = $queryresult['ACCOUNT_RANK'];
                $eRank = $queryresult2['ACCOUNT_RANK'];

                // Rütbesini Sorgula 
                if ($meRank == "owner") {
                    return "verified";
                } elseif ($e == $meID) {
                    return "verified";
                } elseif ($eRank == "owner") {
                    return false;
                } elseif ($eRank == "admin") {
                    return false;
                } elseif ($eRank == "premium") {
                    return "verified";
                } elseif ($eRank == "vip") {
                    return "verified";
                } elseif ($eRank == "user") {
                    return "verified";
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
}

function idtousername($e)
{
    include "adminconnectdb.php";

    if (empty($e)) {
        return false;
    } else {
        // gelen kişiyi Veritabanında Bi arat hele
        $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_ID=? ");
        $query->execute(array($e));
        $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

        // Seçili Verileri Dizme
        foreach ($thequery as $queryresult)

            if ($thequery) {
                $username = $queryresult['ACCOUNT_USERNAME'];
                return $username;
            } else {
                return false;
            }
    }
}

function usernametoid($e)
{
    include "adminconnectdb.php";

    if (empty($e)) {
        return false;
    } else {
        // gelen kişiyi Veritabanında Bi arat hele
        $query = $db->prepare(" SELECT * FROM accounts_table WHERE ACCOUNT_USERNAME=? ");
        $query->execute(array($e));
        $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

        // Seçili Verileri Dizme
        foreach ($thequery as $queryresult)

            if ($thequery) {
                $username = $queryresult['ACCOUNT_ID'];
                return $username;
            } else {
                return false;
            }
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