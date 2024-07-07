<h1>Form app</h1>
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

Implementcaja Vue:

Pliki aplikacji vue znajdują w folderze "assets". W pliku app.js zostały dodane biblioteki bootstrap.

![image](https://github.com/Mydlyk/form_app/assets/65900710/7e29d559-e238-4a1a-a3f1-6a509fe424aa)

W pliku App.vue został stworzony formularz. Została wyłączone walidacja poprzez przeglądarkę oraz dodane zostało wywołanie funkcji submitForm po wysłaniu formularza. Wszystkie pola formularza są wymagane oraz wartości pól zostały powiązane z obiektem formData poprzez "v-model".

![image](https://github.com/Mydlyk/form_app/assets/65900710/9e9af3a1-5cc2-4773-8d04-e4d1e45f89bc)

Funkcja submitForm wywołuje w instrukcji warunkowej funkcję validateForm która odpowiada za walidację danych z formularza. Gdy dane są nie poprawne zwraca fałsz.

![image](https://github.com/Mydlyk/form_app/assets/65900710/1a82fa22-a7b8-44d6-b492-bb7ce7deb6cd)

Funkcja validateForm sprawdza w instrukcjach warunkowych czy pola nie są puste,czy nie składją się z spacji (Trim()) i czy email jest poprawny za pomocą funkcji validator.isEmail(). Jeśli zostanie wykryty jakiś bład zostanie on przypisany do obiektu errors.

![image](https://github.com/Mydlyk/form_app/assets/65900710/2f36b49b-2d89-4f5d-8e1a-1a71382d1fdc)

Jeśli obiekt errors nie jest pusty zostanie wywołany Komponent FormErros i zostaną wyświetlone błedy.

![image](https://github.com/Mydlyk/form_app/assets/65900710/f07d219b-0ee4-4217-a392-ccac98de2ff2)

Jeśli nie będzie żadnych błędów w funkcji submitForm zostanie wywołana funkcja axios oraz zapytanie POST. Jeśli serwer zwróci jakieś błędy zostana one złapane w bloku try catch oraz podobnie jak błędy z formularza zostaną wyświetlone na stronie.

![image](https://github.com/Mydlyk/form_app/assets/65900710/246febaa-c355-4a1a-8464-1bc9f665f4f7)

Przez to że wyświetlanie błędów od strony klienta i serwera jest bardzo podobne został stworzony odzielny komponent FormErrors który może być wielokrotnie używany do wyświetlania błędów.

![image](https://github.com/Mydlyk/form_app/assets/65900710/3d3f1e25-f03e-4cd2-9c30-8cb7bfd6a8a7)

Jeśli serwer nie zwróci żadnych błędów funkcja submitForm odczyta dane i przypisze je do obiektu submittedData, a następnie na stronie zostaną one wypisane w postaci tabelki. 
![image](https://github.com/Mydlyk/form_app/assets/65900710/888b8087-7199-4a5d-be0e-9f7d11fc047d)

Działanie aplikacji:

![image](https://github.com/Mydlyk/form_app/assets/65900710/f0da9c74-31ac-41a0-a841-25b15e518815)

![image](https://github.com/Mydlyk/form_app/assets/65900710/1de8afdb-1240-4158-b8b1-a8f45fbe0e54)


![image](https://github.com/Mydlyk/form_app/assets/65900710/fe8227bd-fbe1-4944-a380-e2cf94503bdf)

W tym przykładzie zostało usunięte sprawdzanie po stronie klienty by przetestować czy poprawnie zostanie odczytany błąd od serwera.

![image](https://github.com/Mydlyk/form_app/assets/65900710/7e603391-8667-4d12-b7c7-87f731a4f07e)

