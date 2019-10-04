//İlk Sayfa Yüklendiğinde Çalışacak Fonksiyonlar
$("#yeniBt").hide()
$("#copyBt").hide()
$("#longURL").val("")
$("#longURL").focus()

// Genel Değişlenler
let LongUrlReadonly = false // enter tuşu için gerekli oldu

// kisaltBt - Kısalt Buton Tıklandığında
$("#kisaltBt").on("click", function() {
    gonderProc()
});

// Veri Ekle AJAX POST ETME
function gonderProc() {
    var suData = $("#AdresEkleForm").serialize();
    suData = suData + "&shorturl=" + shorturlGen()
    $.ajax({
        url: "core/modules/process.php?process=AdresEkle",
        type: "POST",
        data: suData,
        success: function(par) {
            par1 = par.substring(1, 999);
            par2 = par.substring(0, 1);
            if (par2 == "v") {
                shortDoneAlert(par1)
            } else {
                shortErrorAlert(par1)
            }
        }
    });
}

// İşlem Başarılı Alert
function shortDoneAlert(par) {
    $("#homeAlert").html("Yeni link adresi oluşturuldu!").hide().fadeIn(100);
    homeAlerTime()
    $("#kisaltBt").hide()
    $("#yeniBt").show()
    $("#copyBt").show()
    $("#specialURLarea").hide()
    $("#longURL").val(par)
    $("#longURL").attr('readonly', true)
    $("#g-recaptcha").hide().fadeOut(75);
    LongUrlReadonly = true
}

// Hata Alert
function shortErrorAlert(par) {
    $("#homeAlert").html(par).hide().fadeIn(100);
    homeAlerTime()
    $("#longURL").val("")
    grecaptcha.reset();
}

// Link Kopyala Butonuna Tıklandığında
$('#copyBt').click(function() {
    $("#homeAlert").html($("#longURL").val() + " Kopyalandı!").hide().fadeIn(100);
    homeAlerTime()
})

//Alert Zaman
// setTimeout(function(){alert()}, 1)
var zaman;

function homeAlerTime() {
    clearTimeout(zaman);
    $('#homeAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#homeAlert').fadeOut(500);
    }, 4000)
}


//Rastgele kısa URL Generator
function shorturlGen() {
    var d = new Date().getTime();

    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now();
    }

    var uuid = '/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random() * /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/) % /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | 0;
        d = Math.floor(d / /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
        return (c == '/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/' ? r : (r & /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/)).toString(/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
    });

    return uuid;
}


//Copy to Clipboard Çağır
$("#copyBt").click(function() {
    copycc()
});


//Copy To Clipboard
function copycc() {
    var copyText = $("#longURL").val()
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(copyText).select();
    document.execCommand("copy");
    $temp.remove();
    $("#veriKaydetAlert").fadeIn(300);
    $("#veriKaydetAlert").html($("#KisaUrl").val() + "&nbsp;&nbsp; Kopyalandı!");
    alertArea()
};

// Enter Key
$('#longURL').keypress(function(e) {
    var key = e.which;
    if (key == 13) // the enter key code
    {
        if (LongUrlReadonly == false) {
            gonderProc()
        }
        return false;
    }
});

// Navbar Scrolling Fonksiyon
$("#active-nav").hide()
window.onscroll = function() { myFunction() };

function myFunction() {
    if (window.pageYOffset >= 95) {
        $("#passive-nav").hide()
        $("#active-nav").show()
    } else {
        $("#passive-nav").show()
        $("#active-nav").hide()
    }
}

// typejs
$('.typed').typed({
    strings: [
        "Youtuberlar",
        "Yayıncılar",
        "Developerlar",
        "Tasarımcılar",
        "Fenomenler"
    ],
    loop: true,
    startDelay: 1000,
    backDelay: 1000,
    typeSpeed: 30,
    showCursor: false,
    cursorChar: '|',
    autoInsertCss: true
});


// LoginGirisBt - Login-Giriş Buton Tıklandığında
$("#LoginGirisBt").on("click", function() {
    //link olup olmadığını kontorol eder o fonksiyona gider
    LoginGiris();
});


// Login Giriş Fonksiyonu çalışır
function LoginGiris() {
    var LoginDatas = $("#LoginForm").serialize();
    $.ajax({
        url: "core/modules/process.php?process=Giris",
        type: "POST",
        data: LoginDatas,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                loginDoneAlert(e1)
            } else {
                loginErrorAlert(e1)
            }
        }
    });
}


// login Alert - Başarılı
function loginDoneAlert(e) {
    $("#LoginAlert").html(e).hide().fadeIn(100);
    loginAlerTime()
    $("#g-recaptcha").hide().fadeOut(75);
}


// Login Alert - Hata
function loginErrorAlert(e) {
    $("#LoginAlert").html(e).hide().fadeIn(100);
    loginAlerTime()
    grecaptcha.reset();
}


//Login Alert Zaman
function loginAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#LoginAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#LoginAlert').fadeOut(500);
    }, 4000)
}


//Rastgele Key Generator
function AccountIdGen() {
    var d = new Date().getTime();

    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now();
    }

    var uuid = '/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random() * /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/) % /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | 0;
        d = Math.floor(d / /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
        return (c == '/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/' ? r : (r & /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/)).toString(/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
    });

    return uuid;
}

// Signup Uye Ol Buton Tıklandığında
$('#SignupUyeOlBt').click(function() {
    signupPost()
})

// Signup Post Et
function signupPost() {
    var signuppack = $("#SignupForm").serialize();
    signuppack = signuppack + "&SignupUserID=" + AccountIdGen()
    $.ajax({
        url: "core/modules/process.php?process=Signup",
        type: "POST",
        data: signuppack,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                signUpDoneAlert(e1)
            } else {
                signUpErrorAlert(e1)
            }
        }
    });
}


// SignUp Alert - Başarılı
function signUpDoneAlert(e) {
    $("#SignupAlert").html("Kayıt Başarılı!").hide().fadeIn(100);
    signUpAlerTime()
    $("#g-recaptcha").hide().fadeOut(75);
}


// SignUp Alert - Hata
function signUpErrorAlert(e) {
    $("#SignupAlert").html(e).hide().fadeIn(100);
    signUpAlerTime()
    grecaptcha.reset();
}


//SignUp Alert Zaman
function signUpAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#SignupAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#SignupAlert').fadeOut(500);
    }, 4000)
}


// Link Düzenle Kaydet Button
$('#EditLinkKaydet').click(function() {
    linkEditSave()
})


// Link Adresi Düzenleden Kaydet Post Et
function linkEditSave() {
    var editLonglink = $("#LinkEditForm").serialize();
    $.ajax({
        url: "core/modules/process.php?process=LinkGuncelle",
        type: "POST",
        data: editLonglink,
        success: function(par) {
            par1 = par.substring(1, 999);
            par2 = par.substring(0, 1);
            if (par2 == "v") {
                $("#EditLinkAlert").html(par1)
                $("#EditLinkVazgec").hide()
                $("#EditLinkKaydet").hide()
                $("#UzunLink").attr('readonly', true)
            } else {
                $("#EditLinkAlert").html(par1)
            }
        }
    });
}



// !!!!!!!!!!!!! Profil Düzenle Edit Profil Area !!!!!!!!!!!!!!!!!

// Profil Düzenle > Kaydet Buton Tıklandığında
$('#editProfilKaydet').click(function() {
    editProfilPost()
})

// Profil Düzenle > Post Et
function editProfilPost() {
    var epppack = $("#editProfilForm").serialize();
    $.ajax({
        url: "core/modules/process.php?process=profilEdit",
        type: "POST",
        data: epppack,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                editProfilDoneAlert(e1)
            } else {
                editProfilErrorAlert(e1)
            }
        }
    });
}


// Profil Düzenle Alert > Başarılı
function editProfilDoneAlert(e) {
    $("#editProfilAlert").html(e).hide().fadeIn(100);
    editProfilAlerTime()
    $("#g-recaptcha").hide().fadeOut(75);
}


// Profil Düzenle Alert > Hata
function editProfilErrorAlert(e) {
    $("#editProfilAlert").html(e).hide().fadeIn(100);
    editProfilAlerTime()
    grecaptcha.reset();
}


//Profil Düzenle Alert Zaman
function editProfilAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#editProfilAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#editProfilAlert').fadeOut(500);
    }, 4000)
}



// !!!!!!!!!!!!! Şifre Sıfırla -  Reset Password Area !!!!!!!!!!!!!!!!!

//Rastgele Password Generator
function rpwGen() {
    var d = new Date().getTime();

    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now();
    }

    var uuid = '/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random() * /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/) % /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/;
        d = Math.floor(d / /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
        return (c == '/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/' ? r : (r & /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/ | /* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/)).toString(/* !!!! Site Güvenliği Açısından Değiştirildi! !!!!!!!!!*/);
    });

    return uuid;
}

// Şifre Sıfırla -  Reset Password > Kaydet Buton Tıklandığında
$('#ResetPassBt').click(function() {
    ResPassPost()
})

// Şifre Sıfırla -  Reset Password > Post Et
function ResPassPost() {
    var data = $("#ResetPassForm").serialize();
    data = data + "&rpwNewPw=" + rpwGen();
    $.ajax({
        url: "core/modules/process.php?process=ResetPassword",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                ResPassDoneAlert(e1)
            } else {
                ResPassErrorAlert(e1)
            }
        }
    });
}


// Şifre Sıfırla -  Reset Password Alert > Başarılı
function ResPassDoneAlert(e) {
    $("#ResetPwAlert").html(e).hide().fadeIn(100);
    ResPassAlerTime()
    $("#g-recaptcha").hide().fadeOut(75);
    $("#ResetPassBt").hide().fadeOut(75);
}


// Şifre Sıfırla -  Reset Password Alert > Hata
function ResPassErrorAlert(e) {
    $("#ResetPwAlert").html(e).hide().fadeIn(100);
    ResPassAlerTime()
    grecaptcha.reset();
}


//Şifre Sıfırla -  Reset Password Alert Zaman
function ResPassAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#ResetPwAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#ResetPwAlert').fadeOut(500);
    }, 4000)
}

// !!!!!!!!!!!!! Şifre Değiştir - Edit Password Area !!!!!!!!!!!!!!!!!

// Şifre Değiştir - Edit Password > Kaydet Buton Tıklandığında
$('#editPwKaydet').click(function() {
    editPassPost()
})

// Şifre Değiştir - Edit Password > Post Et
function editPassPost() {
    var data = $("#editPwForm").serialize();
    $.ajax({
        url: "core/modules/process.php?process=EditPassword",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                editPassDoneAlert(e1)
            } else {
                editPassErrorAlert(e1)
            }
        }
    });
}


// Şifre Değiştir - Edit Password Alert > Başarılı
function editPassDoneAlert(e) {
    $("#editPwAlert").html(e).hide().fadeIn(100);
    editPassAlerTime()
    $("#g-recaptcha").hide().fadeOut(75);
    $("#ResetPassBt").hide().fadeOut(75);
}


// Şifre Değiştir - Edit Password Alert > Hata
function editPassErrorAlert(e) {
    $("#editPwAlert").html(e).hide().fadeIn(100);
    editPassAlerTime()
    grecaptcha.reset();
}


//Şifre Değiştir - Edit Password Alert Zaman
function editPassAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#editPwAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#editPwAlert').fadeOut(500);
    }, 4000)
}


// !!!!!!!!!!!!! Support Message Send - Destek Mesaj Gönder Area !!!!!!!!!!!!!!!!!

// Support Message Send - Destek Mesaj Gönder > Kaydet Buton Tıklandığında
$('#SupportGonderBt').click(function() {
    supportMessagePost()
})

// Support Message Send - Destek Mesaj Gönder > Post Et
function supportMessagePost() {
    var data = $("#supportMessageForm").serialize();
    $.ajax({
        url: "core/modules/process.php?process=SupportMessage",
        type: "POST",
        data: data,
        success: function(e) {
            e1 = e.substring(1, 999);
            e2 = e.substring(0, 1);
            if (e2 == "v") {
                supportMessageDoneAlert(e1)
            } else {
                supportMessageErrorAlert(e1)
            }
        }
    });
}


// Support Message Send - Destek Mesaj Gönder Alert > Başarılı
function supportMessageDoneAlert(e) {
    $("#supportMessageAlert").html(e).hide().fadeIn(100);
    supportMessageAlerTime()
    $("#g-recaptcha").hide().fadeOut(75);
    $("#SupportGonderBt").hide().fadeOut(75);
}


// Support Message Send - Destek Mesaj Gönder Alert > Hata
function supportMessageErrorAlert(e) {
    $("#supportMessageAlert").html(e).hide().fadeIn(100);
    supportMessageAlerTime()
    grecaptcha.reset();
}


// Support Message Send - Destek Mesaj Gönder Alert Zaman
function supportMessageAlerTime() {
    var zaman;
    clearTimeout(zaman);
    $('#supportMessageAlert').fadeIn(200);
    zaman = setTimeout(function() {
        $('#supportMessageAlert').fadeOut(500);
    }, 4000)
}