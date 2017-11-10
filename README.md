![vMCShop](https://host.verlikylos.pro/images/vMCShop-Basic-Github-Logo.png)

Aktualna wersja: **1.0.0**

[Instrukcja aktualizacji skryptu do najnowszej wersji](https://github.com/Verlikylos/vMCShop/wiki/Instrukcja-aktualizacji-skryptu-do-najnowszej-wersji)

<br>

<hr>

Demo: [Klik](https://basic.vmcshop.pro/)

Demo ACP: [Klik](https://basic.vmcshop.pro/admin)

Login: **Admin**

Hasło: **password**

<hr>

<br>

### Ogłoszenia

Zapraszam do polubienia [FanPage](https://www.facebook.com/verlikylos), dzięki temu będę mial lepszy kontakt z Wami oraz szybciej dowiecie się o nowych aktualizacjach.

**Zanim zaczniesz korzystać z płatności PayPal, przeczytaj [ten poradnik](https://github.com/Verlikylos/vMCShop-Basic/wiki/Jak-skonfigurowa%C4%87-konto-PayPal,-aby-dzia%C5%82a%C5%82o-ze-sklepem%3F).**

<br>

### Kontakt

W razie jakichkolwiek pytań/wątpliwosci/problemów/błędów zapraszam do kontaktu [mailowego](mailto:kontakt@verlikylos.pro), przez mój [FanPage](https://www.facebook.com/verlikylos), Discord (Verlikylos#5640) lub przy pomocy komunikatora [Telegram](https://t.me/Verlikylos).

**Zanim napiszesz do mnie w związku z jakimś błędem, sprawdź czy [tutaj](https://github.com/Verlikylos/vMCShop/wiki/Znane-b%C5%82%C4%99dy-i-sposoby-ich-rozwi%C4%85zywania) nie ma opisu jak go rozwiazać!**

<br><br>

### Funkcje
- Strona główna dostosowywuje się do ilości posiadanych serwerów. Jeżeli do sklepu mamy podłączony więcej niż jeden serwer, jako stronę główną zobaczymy panel wyboru serwera. Jeżeli posiadamy tylko jeden serwer, zostaniemy od razu przeniesieni do sklepu.
- Strona sklepu zawiera listę usług, status serwera oraz listę ostatnich klientów. Można zmienić jej układ w panelu administratora.
- W panelu administratora w chwilę możemy zmienić kolorystykę strony wybierając jeden z 21 motywów.
- Panel administratora znajdziemy m.in. dashboard z podsumowaniem naszej sprzedaży, zarządzanie użytkownikami, zarządzanie serwerami, zarządzanie usługami, zarządzanie voucherami, konfigurację własnych stron, historię zakupów, logi, konsole dla każdego serwera, ustawienia konta, ustawienia płatności oraz ustawienia strony.
- Przy zakupie usługi lub realizacji vouchera sprawdzane jest czy serwer, do któego przypisana jest usługa jest online.
- Przy każdym odwiedzeniu dashboardu sprawdzane jest czy nie jest dostępna nowa wersja skryptu, jeśli tak to zostanie wyświetlone stosowne powiadomienie

Resztę można zobaczyć w demie ;)

<br>

### Dostępne metody płatności
- PayPal
- SMS Premium

<br>

### Obsługiwani operatorzy płatności SMS
- MicroSMS.pl
- Homepay.pl
- LvlUp.pro
- Pukawka.pl

<br>

### Wymagania
 - PHP 5.6
 - MySQL
 - Aktywne mod_rewrite
 
 1. Wgraj pliki na serwer www.
 2. Importuj plik ```database.sql``` do swojej bazy danych MySQL.
 3. Edytuj plik ```application/config/config.php```. Zmienną ```$config['base_url']``` ustaw na adres do swojej witryny. Przykład ```$config['base_url'] = 'https://vmcshop.pro/'```.
 4. Edytuj plik ```application/config/database.php```. Zmienne ```'hostname' => 'adres bazy danych'```, ```'username' => 'nazwa użytkownika bazy danych'```, ```'password' => 'hasło do bazy danych'```, ```'database' => 'nazwa bazy danych'``` ustaw na wartosci odpowiadające Twojej bazie danych.
 5. Przejdź do witryny ```twojadomena.com/admin``` i zaloguj się używając domyslnych danych. (Login: Admin, Hasło: password).
 6. Sklep jest gotowy do użycia.
 
 <br>
 
 ### Changelog
 #### Wersja 1.0.0
 - Pierwsze wydanie skryptu
 
 <br>
 
 ### Licencja: **GNU GPLv3**
 
 <br>
 
 [![Donate with PayPal](https://host.verlikylos.pro/images/paypal-donate.png)](https://www.paypal.me/Verlikylos)
