/** Coockies */

function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}

function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function PonerCookie() {
    setCookie('vzenix-es-cookie', '1', 365);
	if (!document.getElementById("barraaceptacioncookie")) {
		return;
	}

    document.getElementById("barraaceptacioncookie").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function (event) {
	if (!document.getElementById("barraaceptacioncookie")) {
		return;
	}

    console.log("DOM fully loaded and parsed");
    console.log(getCookie('vzenix-es-cookie'));
    if (getCookie('vzenix-es-cookie') != "1") {
        document.getElementById("barraaceptacioncookie").style.display = "block";
    } else {
        document.getElementById("barraaceptacioncookie").style.display = "none";
    }
});

/** Create Posts */

function ShowForm() {
    if (document.getElementById('postForm').classList.contains('hide')) {
        document.getElementById('postForm').classList.remove('hide');
    } else {
        document.getElementById('postForm').classList.add('hide')
    }
}

function GoToHome() {
    document.location.href = '/';
}