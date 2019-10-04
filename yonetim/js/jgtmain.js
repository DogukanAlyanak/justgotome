//İlk Sayfa Yüklendiğinde Çalışacak Fonksiyonlar
$('#adminNoteSaveBt').hide()
$('#adminNoteForm').hide()
$("#adminNoteAlert").hide()


// Yönetim Paneli Not Düzenle Buton tıklandığında
$('#adminNoteEditBt').click(function() {

    let adminnote = $('#NotepadNote').html()
    adminnote = $.trim(adminnote)
    $('#adminPanelNoteInput').val(adminnote)
    $('#NotepadNote').hide()
    $('#adminNoteForm').show()
    $('#adminNoteEditBt').hide()
    $('#adminNoteSaveBt').show()
})

// Yönetim Paneli Not Kaydet Buton tıklandığında
$('#adminNoteSaveBt').click(function() {
    adminEditNotePost()
})

// Admin Panel Not düzenle Post Etme
function adminEditNotePost() {
    var data = $("#adminNoteForm").serialize();
    $.ajax({
        url: "modules/adminprocess.php?process=adminNoteEdit",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                editAdminNoteDoneAlert(e1)
            } else {
                editAdminNoteErrorAlert(e1)
            }
        }
    })
}


// Admin Panel Not düzenle > Başarılı
function editAdminNoteDoneAlert(e) {
    $('#NotepadNote').html(e);
    $('#NotepadNote').show();
    $('#adminNoteForm').hide()
    $('#adminNoteSaveBt').hide()
    $('#adminNoteEditBt').show()
}


// Admin Panel Not düzenle Alert > Hata
function editAdminNoteErrorAlert(e) {
    console.log(e);
    $("#adminNoteAlert").hide().fadeIn(100);
    editNoteAdminAlertTime();
}


//Admin Panel Not düzenle Alert Zaman
function editNoteAdminAlertTime() {
    var zaman;
    clearTimeout(zaman);
    $('#adminNoteAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#adminNoteAlert').fadeOut(500);
    }, 4000)
}

// !!!!!!!!!!!!! Member Edit Rütbe Dropdown !!!!!!!!!!!!!
$('#memberDDuser').click(function() {
    $('#rutbeDDTxt').html("Kullanıcı");
    $('#memberRutbeInput').val("user");
});

$('#memberDDvip').click(function() {
    $('#rutbeDDTxt').html("V.I.P");
    $('#memberRutbeInput').val("vip");
});

$('#memberDDpremium').click(function() {
    $('#rutbeDDTxt').html("Premium");
    $('#memberRutbeInput').val("premium");
});

$('#memberDDadmin').click(function() {
    $('#rutbeDDTxt').html("Yönetici");
    $('#memberRutbeInput').val("admin");
});

$('#memberDDowner').click(function() {
    $('#rutbeDDTxt').html("Sahip");
    $('#memberRutbeInput').val("owner");
});

// !!!!!!!!!!!!! Member Edit !!!!!!!!!!!!!
//  Member Edit Banla Area

// BANLA > Tıklandığında
$('#memEditBanla').click(function() {
    memEditBanla()
})

// BANLA > Post Et
function memEditBanla() {
    var data = "&banUye=" + $('#memEditUserID').html();
    $.ajax({
        url: "modules/adminprocess.php?process=Banla",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                BANmemEditDoneAlert(e1)
            } else {
                BANmemEditErrorAlert(e1)
            }
        }
    });
}


// BANLA > Alert > Başarılı
function BANmemEditDoneAlert(e) {
    var buSayfa = window.location.href;
    $("#membereditAlert").html("<span style='color:white;'>" + e + "</span>" + "<meta http-equiv='refresh' content='0;URL=" + buSayfa + "'>").hide().fadeIn(100);
    memEditAlerTime()
}


// BANLA > Alert > Hata
function BANmemEditErrorAlert(e) {
    $("#membereditAlert").html("<span style='color:orange;'>" + e + "</span>").hide().fadeIn(100);
    memEditAlerTime()
}


// Member Edit > Alert > Zaman
function memEditAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#membereditAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#membereditAlert').fadeOut(500);
    }, 4000)
}

//  !!!!!! Member Edit Ban Kaldır Area !!!!!!!

// BAN KALDIR > Tıklandığında
$('#memEditBanKaldir').click(function() {
    memEditBanKaldir()
})

// BAN KALDIR > Post Et
function memEditBanKaldir() {
    var data = "&banUye=" + $('#memEditUserID').html();
    $.ajax({
        url: "modules/adminprocess.php?process=BanKaldir",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                BANkaldirMemEditDoneAlert(e1)
            } else {
                BANkaldirMemEditErrorAlert(e1)
            }
        }
    });
}


// BAN KALDIR > Alert > Başarılı
function BANkaldirMemEditDoneAlert(e) {
    var buSayfa = window.location.href;
    $("#membereditAlert").html("<span style='color:white;'>" + e + "</span>" + "<meta http-equiv='refresh' content='0;URL=" + buSayfa + "'>").hide().fadeIn(100);
    memEditAlerTime()
}


// BAN KALDIR > Alert > Hata
function BANkaldirMemEditErrorAlert(e) {
    $("#membereditAlert").html("<span style='color:orange;'>" + e + "</span>").hide().fadeIn(100);
    memEditAlerTime()
}

// !!!!!!!!!!!!! Admin > User Şifre Sıfırla Area !!!!!!!!!!!!!!!!!

// Admin > User Şifre Sıfırla > Kaydet Buton Tıklandığında
$('#AdminUserResetPWonayBt').click(function() {
    aurPWPost()
})

// Admin > User Şifre Sıfırla > Post Et
function aurPWPost() {
    var data = "&userid=" + $("#memEditUserID").html() + "&rpwNewPw=" + rpwGenAdmin();
    $.ajax({
        url: "modules/adminprocess.php?process=userResetPW",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                aurPWDoneAlert(e1)
            } else {
                aurPWErrorAlert(e1)
            }
        }
    });
}


// Admin > User Şifre Sıfırla Alert > Başarılı
function aurPWDoneAlert(e) {
    $("#membereditAlert").html(e).hide().fadeIn(100);
    aurPWAlerTime()
    $('#AdminUserResetPWvazgecBt').click()
}


// Admin > User Şifre Sıfırla Alert > Hata
function aurPWErrorAlert(e) {
    $("#membereditAlert").html(e).hide().fadeIn(100);
    aurPWAlerTime()
    $('#AdminUserResetPWvazgecBt').click()
}


// Admin > User Şifre Sıfırla Alert Zaman
function aurPWAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#membereditAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#membereditAlert').fadeOut(500);
    }, 4000)
}

//Rastgele Password Generator
function rpwGenAdmin() {
    var d = new Date().getTime();

    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now();
    }
            /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/
    var uuid = 'GÜVENLİK AÇISINDAN GİZİLİ'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random() * 9999999) % 999999999 | 0;
        d = Math.floor(d / 999999999999);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(9999999999);
    });

    return uuid;
}

// !!!!!!!!!!!!! Member Edit Save - Üye Düzenle Kaydet > Area !!!!!!!!!!!!!!!!!

// Member Edit Save - Üye Düzenle Kaydet > > Kaydet Buton Tıklandığında
$('#memberEditKaydetBt').click(function() {
    memEditSavePost()
})

// Member Edit Save - Üye Düzenle Kaydet > > Post Et
function memEditSavePost() {
    var data = $('#memEditSaveForm').serialize();
    $.ajax({
        url: "modules/adminprocess.php?process=memEditSave",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                memEditSaveDoneAlert(e1)
            } else {
                memEditSaveErrorAlert(e1)
            }
        }
    });
}


// Member Edit Save - Üye Düzenle Kaydet > Alert > Başarılı
function memEditSaveDoneAlert(e) {
    $("#membereditAlert").html(e).hide().fadeIn(100);
    memEditSaveAlerTime()
}


// Member Edit Save - Üye Düzenle Kaydet > Alert > Hata
function memEditSaveErrorAlert(e) {
    $("#membereditAlert").html(e).hide().fadeIn(100);
    memEditSaveAlerTime()
}


// Member Edit Save - Üye Düzenle Kaydet > Alert Zaman
function memEditSaveAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#membereditAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#membereditAlert').fadeOut(500);
    }, 4000)
}

// !!!!!!!!!!!!! Member Edit Member Delete - Admin > Üye > Sil Area !!!!!!!!!!!!!!!!!

// Member Edit Member Delete - Admin > Üye > Sil > Kaydet Buton Tıklandığında
$('#memEditKisiyiSilBt').click(function() {
    memDelPost()
})

// Member Edit Member Delete - Admin > Üye > Sil > Post Et
function memDelPost() {
    var data = $("#memEditSaveForm").serialize();
    $.ajax({
        url: "modules/adminprocess.php?process=MemberDelete",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                memDelDoneAlert(e1)
            } else {
                memDelErrorAlert(e1)
            }
        }
    });
}


// Member Edit Member Delete - Admin > Üye > Sil Alert > Başarılı
function memDelDoneAlert(e) {
    var buSayfa = window.location.href;
    buSayfa = buSayfa.split("ttp:/")
    buSayfa = buSayfa[0] + "ttps:/" + buSayfa[1]
    buSayfa = buSayfa.split("memberedit")
    var members = buSayfa[0] + "members"
    $("#membereditAlert").html(e + "<meta http-equiv='refresh' content='2;URL=" + members + "'>").hide().fadeIn(100);
    memDelAlerTime()
    $('#delModalvazgecBt').click()
}


// Member Edit Member Delete - Admin > Üye > Sil Alert > Hata
function memDelErrorAlert(e) {
    $("#membereditAlert").html(e).hide().fadeIn(100);
    memDelAlerTime()
    $('#delModalvazgecBt').click()
}


// Member Edit Member Delete - Admin > Üye > Sil Alert Zaman
function memDelAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#membereditAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#membereditAlert').fadeOut(500);
    }, 4000)
}

// !!!!!!!!!!!!!Admin Links Save - Admin Linkler Kaydet Area !!!!!!!!!!!!!!!!!

//Admin Links Save - Admin Linkler Kaydet > Kaydet Buton Tıklandığında
$('#LinkEditKaydetBt').click(function() {
    LinksSavePost()
})

//Admin Links Save - Admin Linkler Kaydet > Post Et
function LinksSavePost() {
    var data = $("#LinksEditSaveForm").serialize();
    data = data + "&randomKey=" + shorturlGen();
    $.ajax({
        url: "modules/adminprocess.php?process=AdminLinkSave",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                LinksSaveDoneAlert(e1)
            } else {
                LinksSaveErrorAlert(e1)
            }
        }
    });
}


//Admin Links Save - Admin Linkler Kaydet Alert > Başarılı
function LinksSaveDoneAlert(e) {
    $("#LinkEditAlert").html(e).hide().fadeIn(100);
    LinksSaveAlerTime()
}


//Admin Links Save - Admin Linkler Kaydet Alert > Hata
function LinksSaveErrorAlert(e) {
    $("#LinkEditAlert").html(e).hide().fadeIn(100);
    LinksSaveAlerTime()
}


//Admin Links Save - Admin Linkler Kaydet Alert Zaman
function LinksSaveAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#LinkEditAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#LinkEditAlert').fadeOut(500);
    }, 4000)
}

/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/
function shorturlGen() {
    var d = new Date().getTime();

    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now();
    }

    var uuid = '/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random() * /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/) % /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | 0;
        d = Math.floor(d / /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
        return (c == 'x' ? r : (r & /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/)).toString(/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
    });

    return uuid;
}

// !!!!!!!!!!!!!Admin Links Edit Delete - Admin Linkler Düzenle Sil Area !!!!!!!!!!!!!!!!!

//Admin Links Edit Delete - Admin Linkler Sil > Sil Buton Tıklandığında
$('#LinkEditSilBt').click(function() {
    LinksEditDeletePost()
})

// Admin Links Edit Delete - Admin Linkler Düzenle Sil > Post Et
function LinksEditDeletePost() {
    var data = $("#LinksEditSaveForm").serialize();
    $.ajax({
        url: "modules/adminprocess.php?process=AdminLinkDelete",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                LinksEditDeleteDoneAlert(e1)
            } else {
                LinksEditDeleteErrorAlert(e1)
            }
        }
    });
}


// Admin Links Edit Delete - Admin Linkler Düzenle Sil Alert > Başarılı
function LinksEditDeleteDoneAlert(e) {
    var buSayfa = window.location.href;
    buSayfa = buSayfa.split("ttp:/")
    buSayfa = buSayfa[0] + "ttps:/" + buSayfa[1]
    buSayfa = buSayfa.split("linksedit")
    var links = buSayfa[0] + "links"
    $("#LinkEditAlert").html(e + "<meta http-equiv='refresh' content='0;URL=" + links + "'>").hide().fadeIn(100);
    LinksEditDeleteAlerTime()
}


// Admin Links Edit Delete - Admin Linkler Düzenle Sil Alert > Hata
function LinksEditDeleteErrorAlert(e) {
    $("#LinkEditAlert").html(e).hide().fadeIn(100);
    LinksEditDeleteAlerTime()
}


// Admin Links Edit Delete - Admin Linkler Düzenle Sil Alert Zaman
function LinksEditDeleteAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#LinkEditAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#LinkEditAlert').fadeOut(500);
    }, 4000)
}