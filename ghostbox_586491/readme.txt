****************************************************************
ACHTUNG
Bitte folgende Anweisungen bis zum Ende lesen
und befolgen!
****************************************************************

1.
Kopieren Sie die entpackte Version 'SUPERAPP' in ihr
htdocs-Verzeichnis

2.
Legen Sie über PHPMyAdmin eine neue MySQL-Dastenbank
mit dem Namen 'superdb' (ohne Anführungszeichen) an

3.
Legen Sie über PHPMyAdmin einen neuen MySQL-Datenbank-Benutzer
an mit folgenden Angaben:
Benutzername:		superdev
Host:				localhost (NICHT %, wie voreingestellt!!!)
Passwort:			superpas

Weiter unten 'Globale Rechte - alle auswählen' markieren

Unten rechts auf 'OK' klicken und Benutzer anlegen

4.
Wählen Sie nun ihre Datenbank 'superdb' aus (wichtig!)
Gehen Sie auf 'Importieren' und wählen Sie die Datei
'SUPERAPP\superdb.superdb.sql' aus.

(Weitere Einstellungen belassen)

Klicken Sie unten auf 'OK', um die Tabellen und Datensätze zu
importieren.

5.
Legen Sie eine (weitere) URL in der Windows-Host-Datei an, z. B.
dev.superapp.com
(Siehe ZEND-Installationsanweisung)

6.
Legen Sie einen (weiteren) virtuellen Host in der Apache Konfigurationsdatei
'httpd-vhosts.conf' an und beziehen Sie ihre neue URL auf das
neue Verzeichnis 'SUPPERAPP\public'
(Siehe ZEND-Installationsanweisung)

7.
Starten Sie ihren Webserver neu.

8.
Testen Sie mit ihrer neuen URL (dev.superapp.com) im Browser

****************************************************************
****************************************************************