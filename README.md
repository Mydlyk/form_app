Form app
Form_app wykorzystuje Symfony 7 oraz vue 3. Backend oraz Frontend są ze sobą zintegrowane jako jedna aplikacja za pomocą mechanizmu szablonów Twig. Dane w forularzach są walidowane za pomcą Symfony Validator, prostych instrukcji warunkowych i biblioteki vue validator. Dane są przechowywane w bazie danych, a operacje na nich są zarządzane przez Doctrine ORM. Aplikacja obsługuje i wyświetla błedy serwera oraz klienta.

Wykorzystane biblioteki Symfony(Composer):
orm-pack - pakiet zawierający zależności potrzebne do używania ORM
encore – służy do konfiguracji Webpack’a
twig - szablonowy język skryptowy  pozwalający na tworzenie dynamicznych stron internetowych
validator - umożliwia walidację danych w aplikacji.
webpack-encore - Pozwala na konfigurację zależności frontend’owych

Wykorzystane biblioteki Vue(npm):
Bootstrap- framework CSS wykorzystywane do do stylizowania komponentów
Validator- biblioteka JavaScript służąca do walidacji danych.
Axios- biblioteka służąca do wykonywania zapytań HTTP w aplikacjach JavaScript.

Implementcaja Symfony:
Na początku w pliku webpacp.config.js zostało dodane wywołannie funkcji ".enableVueLoader()" która odpowiada za ustawiene Webpacka na używania vue-loader'a służącego do przetwarzania plików vue. 

![image](https://github.com/Mydlyk/form_app/assets/65900710/b27222a9-9797-4b0e-a545-c028507ee2b3)

Następnie w pliku index.html.twig dodany został głuwny komponent aplikacji vue.
![image](https://github.com/Mydlyk/form_app/assets/65900710/dbe0a274-775d-4835-a147-e1767d27dc68)

Następnie została stworzone encja ContactForm("php bin/console make:entity ContactForm") służąca do przechowywania wiadomości. Następnie została wykonana migracja(php bin/console make:migration) oraz wykonanie migracji w bazie danych(php bin/console make:migration). W projekcje została wykorzystana baza MySQL. Jako iż został wykorzystany Doctorine ORM możliwe jest wykorzystanie innej bazy danych np. PostgreSQL wystarczy zmienić zmienną DATABASE_URL w pliku .env. 

![image](https://github.com/Mydlyk/form_app/assets/65900710/4b051629-5c3c-4696-b6a3-0c5c36127a78)

 Następnie została stworzona klasa kontrolera(MainController). Posiada ona dwie zmienne oraz konstruktor odpowiedzialny za walidację danych otrzymanych od klienta i zapisanie ich w bazie danych.

![image](https://github.com/Mydlyk/form_app/assets/65900710/e664180f-950b-4da9-aafc-a8689bbb62ad)

Funkjca submit odpowiada za wykonanie HTTP POST. Otrzymane dane są ustawiane w nowym obiekcie klasy ContactForm.

![image](https://github.com/Mydlyk/form_app/assets/65900710/98c85b6e-f0c5-4ad9-91b7-84869a6c9bd4)

Dane przechodzą przez funkcję trim w celu usunięcia spacji z początku i końca ciągu znaków. Również blokuje to możliwość dodania paru spacji jako wartości.

Następnie dane są validowane i jeśli występują jakieś błędy funkcja zwraca błąd 400(BadRequest) oraz listę błędów.

![image](https://github.com/Mydlyk/form_app/assets/65900710/92cfd806-1f2b-4cc0-b265-1d5438a7c163)

![image](https://github.com/Mydlyk/form_app/assets/65900710/880f22cd-b0fb-4e49-ad06-25ad89580a66)

Ustawienie walidacji odbywa się w pliku entity/ContactForm. Dane muszą nie mogą być puste, nullem oraz mieć maksymalnie 255 znaków. Dodatkow email musi posiadać poprawną składnię. Dzięki wcześniejszemu użyciu funkcji trim spacje są wykrywane jako pusty ciąg. 

Jeśli dane są poprawne następuje ich zapisanie do bazy danych oraz zwrócenie ich.

![image](https://github.com/Mydlyk/form_app/assets/65900710/49b46ab9-e2e0-4797-9c2e-44be92526e24)

![image](https://github.com/Mydlyk/form_app/assets/65900710/6fc1a2ad-7d04-43a2-b0ec-71bec2c0016e)



