/**
 * Copyright (c) 2017 All rights reserved.
 * Christoph Stockinger
 * Bahnhofstraße 45
 * 94469 Deggendorf
 * hello@christophstockinger.de
 * www.christophstockinger.de
 * erstellt am 26.12.17 18:50
 **/

/**
 * Blackbox Javascript Funktionen
 * Version 1
 **/

console.log("Start!");
$(document).ready(
    function () {

        // Settings-Menü
        $('#settings-icon').click(
            function () {
                console.log("geklickt!");
                var navigation = $(this).attr('href');
                console.log(navigation);
                $(navigation).toggleClass('open');
            }
        )

        // First check beim laden
        cloudCheck();

        // Check beim Klick darauf
        $('#savecloud').click(
            function () {
                cloudCheck();
            }
        );

        // Ändert Input Feld von Text zu Password
        var pw = $('.password');
        if (pw != null) {
            pw.attr("type", "password");
        }
    }
);

console.log("Fertig!");


/**
 * Funktion zum Überprüfen, ob die Speicherung in der Cloud aktiviert ist
 */
function cloudCheck() {
    var checkbox = $('#savecloud:checked').length;

    var loc = $('#savelocationcloud');
    var user = $('#usernamecloud');
    var pass = $('#passwordcloud');
    var locl = $('#savelocationcloud-label');
    var userl = $('#usernamecloud-label');
    var passl = $('#passwordcloud-label');

    if (checkbox == 1) {
        loc.show();
        user.show();
        pass.show();
        locl.show();
        passl.show().addClass('half');
        userl.show().addClass('half');
        passl.show().addClass('half');
        loc.attr('requiered', '');
        user.attr('requiered', '');
        pass.attr('requiered', '');
    } else {
        loc.hide();
        user.hide();
        pass.hide();
        locl.hide();
        userl.hide();
        passl.hide();
        loc.removeAttr('requiered');
        user.removeAttr('requiered');
        pass.removeAttr('requiered');
    }

}
