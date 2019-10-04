<?php
include 'core/modules/connectdb.php';
include 'core/modules/function.php';
include "core/modules/session.php";


if (!isset($_GET['sayfa'])) { // eğer boşsa anasayfa varsayalım.
    $sayfa = 'anasayfa';
} else {
    $sayfa = $_GET['sayfa'];
}

switch ($sayfa) {
    case 'anasayfa':
        //START

        $kisa_adres = $_SERVER['REQUEST_URI'];
        $kisa_adres = ltrim($kisa_adres, "/");

        // Seçili Verinin Bilgilerini Çekme
        $veri = $db->prepare(" SELECT * FROM adres_table WHERE DB_ADRES_KISA='$kisa_adres' ");
        $veri->execute(array());
        $v = $veri->fetchAll(PDO::FETCH_ASSOC);
        $BuSite = $_SERVER['SERVER_NAME'];

        if ($v == NULL) {
            // Sayfa bulunulamadı ana sayfaya git.
            echo "<meta http-equiv='refresh' content='0;URL=http://" . $BuSite . "'>";
        } else {
            foreach ($v as $EditVeri);

            if ($EditVeri['DB_ADRES_CREATOR'] != NULL) {

                // Değişkenleri Ata
                $LinkOwnerID = $EditVeri['DB_ADRES_CREATOR'];

                // Linkin Sahibini Bul
                $query = $db->prepare(" SELECT * FROM accounts_table ");
                $query->execute(array());
                $thequery = $query->fetchAll(PDO::FETCH_ASSOC);

                // Seçili Verileri Dizme
                foreach ($thequery as $queryresult)

                    if ($queryresult['ACCOUNT_BANCONTROL'] == NULL) {

                        // Gidilecek Adres Verisini, Veritabanındaki çekilmiş satırdan çekme 
                        $GidilcekAdres = $EditVeri['DB_ADRES_UZUN'];

                        // Ziyaret Sayısı için Gereken Veriler
                        $adres_hit_sayisi = $EditVeri['DB_ADRES_HIT'];
                        $adres_hit_sayisi = $adres_hit_sayisi + 1;

                        // Ziyaret Sayısını arttırma fonksiyonu
                        $guncelle = $db->prepare("UPDATE adres_table SET DB_ADRES_HIT=? WHERE DB_ADRES_KISA='$kisa_adres'");
                        $guncelleme = $guncelle->execute(array($adres_hit_sayisi));

                        // Yönlendirilecek Adrese Yönlendirme
                        echo "<meta http-equiv='refresh' content='0;URL=" . $GidilcekAdres . "'>";
                    } else {
                        // Kullanıcı Banlı ana sayfaya git.
                        echo "<meta http-equiv='refresh' content='0;URL=http://" . $BuSite . "'>";
                    }
            } else {
                // Gidilecek Adres Verisini, Veritabanındaki çekilmiş satırdan çekme 
                $GidilcekAdres = $EditVeri['DB_ADRES_UZUN'];

                // Ziyaret Sayısı için Gereken Veriler
                $adres_hit_sayisi = $EditVeri['DB_ADRES_HIT'];
                $adres_hit_sayisi = $adres_hit_sayisi + 1;

                // Ziyaret Sayısını arttırma fonksiyonu
                $guncelle = $db->prepare("UPDATE adres_table SET DB_ADRES_HIT=? WHERE DB_ADRES_KISA='$kisa_adres'");
                $guncelleme = $guncelle->execute(array($adres_hit_sayisi));

                // Yönlendirilecek Adrese Yönlendirme
                echo "<meta http-equiv='refresh' content='0;URL=" . $GidilcekAdres . "'>";
            }
        }
        //END
        break;

    default: // hiç birisi değilse 404 varsayalim
        echo "<meta http-equiv='refresh' content='0;URL=" . $BuSite . "'>";
}
