<?php

// Gerekli Dosyalar
include "adminfunction.php";


// Çıktı
echo "prodata=Ziyaretci" . GUNengTOtr(bugunGUN()) . "=" . ogunVisitSay(bugun()) . "&" . GUNengTOtr(dunGUN()) . "=" . ogunVisitSay(dun()) . "&" . GUNengTOtr(oncekigunGUN()) . "=" . ogunVisitSay(oncekigun()) . "&" . GUNengTOtr(ucgunonceGUN()) . "=" . ogunVisitSay(ucgunonce()) . "&" . GUNengTOtr(dortgunonceGUN()) . "=" . ogunVisitSay(dortgunonce()) . "&" . GUNengTOtr(besgunonceGUN()) . "=" . ogunVisitSay(besgunonce()) . "&" . GUNengTOtr(altigunonceGUN()) . "=" . ogunVisitSay(altigunonce());
echo "prodata=KisaltilanLink" . GUNengTOtr(bugunGUN()) . "=" . ogunShortenerSay(bugun()) . "&" . GUNengTOtr(dunGUN()) . "=" . ogunShortenerSay(dun()) . "&" . GUNengTOtr(oncekigunGUN()) . "=" . ogunShortenerSay(oncekigun()) . "&" . GUNengTOtr(ucgunonceGUN()) . "=" . ogunShortenerSay(ucgunonce()) . "&" . GUNengTOtr(dortgunonceGUN()) . "=" . ogunShortenerSay(dortgunonce()) . "&" . GUNengTOtr(besgunonceGUN()) . "=" . ogunShortenerSay(besgunonce()) . "&" . GUNengTOtr(altigunonceGUN()) . "=" . ogunShortenerSay(altigunonce());
