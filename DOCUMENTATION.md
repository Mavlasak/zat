# Dokumentace aplikace: Evidence knih a mediálních nosičů

## Obsah
1.  [Úvod](#1-úvod)
2.  [Funkcionality](#2-funkcionality)
3.  [Použité technologie](#3-použité-technologie)
4.  [Architektura a systémový design](#4-architektura-a-systémový-design)
5.  [Databázové schéma](#5-databázové-schéma)
6.  [Instalace a spuštění](#6-instalace-a-spuštění)
7.  [Použití aplikace](#7-použití-aplikace)
8.  [Vývojové postupy](#8-vývojové-postupy)
9.  [Budoucí rozšíření](#9-budoucí-rozšíření)

---

## 1. Úvod

Tato aplikace slouží k domácí evidenci osobní sbírky mediálních nosičů, konkrétně knih, CD a DVD. Jejím hlavním cílem je poskytnout uživateli přehledný nástroj pro správu těchto položek, včetně sledování jejich zápůjček. Aplikace je vyvinuta s důrazem na jednoduchost použití a efektivní správu dat.

## 2. Funkcionality

Aplikace poskytuje následující klíčové funkcionality:

*   **Zobrazení seznamu všech položek:** Uživatel může prohlížet kompletní seznam všech evidovaných knih, CD a DVD na jednom místě.
*   **Filtrování položek:** Možnost filtrovat zobrazené položky podle jejich typu (pouze knihy, pouze CD, pouze DVD) pro lepší přehlednost a rychlou orientaci ve sbírce.
*   **CRUD operace pro položky:**
    *   **Zakládání nových položek:** Přidávání nových záznamů pro knihy, CD nebo DVD s vyplněním základních a specifických informací.
    *   **Úprava detailů položek:** Možnost editovat existující záznamy.
    *   **Odstranění záznamů:** Mazání položek ze sbírky.
*   **Evidence základních informací:** Pro každou položku jsou evidovány společné atributy jako název, popis a datum pořízení.
*   **Evidence specifických informací:**
    *   Pro **Knihy**: Autor.
    *   Pro **CD**: Umělec.
    *   Pro **DVD**: Režisér.
*   **Evidence zápůjček:** Možnost zaznamenat, komu byla položka zapůjčena (jméno půjčujícího).
*   **Zobrazení zapůjčených položek:** Speciální filtr nebo sekce pro rychlý přehled všech aktuálně zapůjčených mediálních nosičů.

## 3. Použité technologie

Aplikace je postavena na moderním webovém stacku s využitím následujících technologií:

*   **Backend:**
    *   **PHP 8.3:** Programovací jazyk.
    *   **Symfony 7.4:** Robustní PHP framework pro vývoj webových aplikací.
    *   **Doctrine ORM 3.6+:** Objektově-relační mapper pro interakci s databází.
    *   **Doctrine Migrations:** Nástroj pro správu databázového schématu.
*   **Frontend:**
    *   **HTML5, CSS3:** Základní stavební kameny webového rozhraní.
    *   **Bootstrap 5:** CSS framework pro responzivní a moderní design uživatelského rozhraní.
    *   **Čistý JavaScript (Vanilla JS):** Pro dynamické a interaktivní prvky na straně klienta.
    *   **Twig:** Šablonovací systém pro generování HTML.
    *   **Webpack Encore:** Nástroj pro správu a kompilaci frontendových assetů (JavaScript, CSS).
*   **Databáze:**
    *   **MySQL 8.0:** Relační databáze pro ukládání všech dat aplikace.
*   **Vývojové a deployment nástroje:**
    *   **Docker & Docker Compose:** Pro kontejnerizaci a správu vývojového prostředí.
    *   **Git:** Systém pro správu verzí zdrojového kódu.
    *   **Composer:** Správce závislostí pro PHP.
    *   **npm:** Správce balíčků pro Node.js (používán uvnitř Docker kontejneru pro frontendové závislosti).

## 4. Architektura a systémový design

Aplikace je navržena s využitím **MVC (Model-View-Controller) architektury**, která je přirozeně implementována v rámci Symfony frameworku.

*   **Model:** Zahrnuje Doctrine entity (`MediaItem`, `Book`, `Cd`, `Dvd`) a jejich repozitáře. `MediaItem` slouží jako základní entita pro všechny typy nosičů a využívá **Single Table Inheritance (STI)** pro rozlišení specifických typů (Kniha, CD, DVD) v rámci jedné databázové tabulky.
*   **View:** Je tvořeno Twig šablonami, které generují HTML výstup. Pro stylování a responzivitu je použit Bootstrap.
*   **Controller:** Zpracovává HTTP požadavky, komunikuje s modely pro manipulaci s daty a předává je do View k vykreslení.

**Tok dat:** Uživatel interaguje s webovým rozhraním. Požadavek je směrován na Controller, který volá příslušné metody Modelu (Doctrine ORM) pro získání nebo uložení dat do MySQL databáze. Model vrací data Controlleru, který je následně předá Twig šablonám k vykreslení uživateli.

## 5. Databázové schéma

Aplikace využívá relační databázi MySQL. Klíčové entity a jejich vztahy jsou následující:

*   **`MediaItem` (hlavní tabulka pro všechny nosiče):**
    *   `id` (PRIMARY KEY)
    *   `title` (Název položky)
    *   `description` (Popis)
    *   `acquisitionDate` (Datum pořízení)
    *   `borrowedTo` (Jméno půjčujícího, pokud je položka zapůjčena)
    *   `type` (Diskriminátorový sloupec pro STI: 'book', 'cd', 'dvd', 'media')
    *   `author` (Specifické pro Knihu)
    *   `artist` (Specifické pro CD)
    *   `director` (Specifické pro DVD)
    *   *(Poznámka: Díky Single Table Inheritance jsou specifická pole jako `author`, `artist`, `director` uložena ve stejné tabulce `media_item` a jsou vyplněna pouze pro relevantní typy. Pole `borrowedTo` je přímo součástí této entity a slouží k evidenci aktuální zápůjčky.)*

## 6. Instalace a spuštění

Podrobné pokyny pro instalaci a spuštění projektu naleznete v souboru `README.md` (nebo `README_EN.md` pro anglickou verzi) v kořenovém adresáři projektu. Zahrnuje kroky pro:
*   Instalaci Dockeru a Docker Compose.
*   Sestavení a spuštění Docker kontejnerů.
*   Instalaci PHP a frontendových závislostí.
*   Sestavení frontendových assetů pomocí Webpack Encore.
*   Spuštění Doctrine migrací.
*   Spuštění Symfony webového serveru.

## 7. Použití aplikace

Po úspěšném spuštění aplikace (viz `README.md`) můžete přistupovat k webovému rozhraní.

*   **Navigace:** Aplikace poskytuje jednoduché navigační prvky pro přístup k seznamu položek, formulářům pro přidání/úpravu a detailům položek.
*   **Přidání nové položky:** Pomocí formuláře "Create New Item" můžete přidat knihu, CD nebo DVD. Formulář dynamicky zobrazuje relevantní pole (autor, umělec, režisér) na základě vybraného typu média.
*   **Prohlížení a filtrování:** Na stránce se seznamem položek můžete prohlížet všechny záznamy a používat filtry pro zobrazení pouze knih, CD nebo DVD.
*   **Detail položky:** Kliknutím na položku v seznamu zobrazíte její detail, včetně typu média a specifických atributů.
*   **Úprava a mazání:** Na stránce detailu položky jsou k dispozici tlačítka pro úpravu nebo smazání záznamu.
*   **Evidence zápůjček:** Pole "Borrowed To" umožňuje zaznamenat jméno osoby, které byla položka zapůjčena.

## 8. Vývojové postupy

Při vývoji byly dodržovány následující postupy:

*   **Verzování kódu:** Pro správu zdrojového kódu byl použit **Git**, což umožnilo efektivní sledování změn a udržování historie projektu.
*   **Využití AI asistence:** Jednotlivé části kódu byly generovány a refaktorovány s pomocí nástrojů umělé inteligence, což pomohlo urychlit vývoj a optimalizovat kód.
*   **Vývojové prostředí:** Kontejnerizace pomocí **Dockeru a Docker Compose** zajistila konzistentní a izolované vývojové prostředí.
*   **Iterativní přístup:** Vývoj probíhal iterativně, s postupnou implementací a testováním jednotlivých funkcionalit.
*   **Testování:** Funkčnost aplikace byla ověřována **manuálním testováním** každé implementované části.

## 9. Budoucí rozšíření

Potenciální budoucí rozšíření aplikace mohou zahrnovat:

*   **Uživatelské účty a autentizace:** Pro správu více sbírek nebo pro sdílení sbírky s více uživateli.
*   **Historie zápůjček:** Rozšíření funkcionality zápůjček o sledování data zapůjčení, data vrácení a historie všech zápůjček.
*   **Vyhledávání:** Implementace fulltextového vyhledávání v rámci sbírky.
*   **Kategorie/Tagy:** Možnost kategorizovat položky pro lepší organizaci.
*   **Obaly/Obrázky:** Přidání možnosti nahrávat obaly knih/CD/DVD.
*   **API:** Vytvoření REST API pro integraci s jinými systémy nebo mobilními aplikacemi.
*   **Automatizované testy:** Implementace unit a integračních testů pro zvýšení robustnosti a spolehlivosti aplikace.
*   **Vylepšení uživatelského rozhraní:** Další optimalizace UX/UI, například pomocí modernějšího JavaScript frameworku.
