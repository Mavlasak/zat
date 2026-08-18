Vážení,

rád bych vám představil/a a obhájil/a svou práci na aplikaci pro domácí evidenci knih a mediálních nosičů. Tato aplikace řeší potřebu přehledné správy osobní sbírky knih, CD a DVD, včetně sledování jejich zápůjček.

Pojďme se podívat na jednotlivé aspekty mého řešení:

---

### 1. Návrh systémového designu aplikace

Moje aplikace je navržena s využitím **MVC (Model-View-Controller) architektury**, která je přirozeně implementována v rámci zvoleného **Symfony frameworku**.

*   **Model:** Pro práci s daty jsem využil/a **Doctrine ORM**, které mi umožnilo definovat entity jako `MediaItem` (základ pro všechny nosiče), `Book`, `CD`, `DVD` (pro specifické atributy) a `Loan` (pro zápůjčky). Tyto entity a jejich repozitáře zajišťují veškerou interakci s databází.
*   **View:** Uživatelské rozhraní je generováno pomocí šablonovacího enginu **Twig**. Pro zajištění moderního a responzivního vzhledu jsem použil/a **Bootstrap CSS framework**.
*   **Controller:** Kontrolery zpracovávají HTTP požadavky od uživatele, komunikují s modely pro získání nebo uložení dat a následně předávají data do Twig šablon k vykreslení.

**Tok dat** v aplikaci probíhá standardně: uživatel interaguje s frontendem (HTML formuláře, odkazy, interaktivní prvky s čistým JavaScriptem), požadavek je směrován na Controller, ten komunikuje s Modelem (Doctrine ORM) pro získání/uložení dat z/do **MySQL databáze**. Model vrací data Controlleru, který je předá View (Twig) k vykreslení.

**Důvody volby:** Symfony jsem zvolil/a, protože poskytuje robustní, škálovatelnou a udržovatelnou platformu s bohatou sadou komponent a osvědčenými postupy, což je ideální pro tento typ datově orientované aplikace. MVC architektura mi pomohla oddělit jednotlivé starosti (separation of concerns), což výrazně usnadnilo vývoj, testování a budoucí údržbu. Bootstrap mi pak umožnil rychle a efektivně vytvořit konzistentní a responzivní uživatelské rozhraní.

---

### 2. Postupy použité při vývoji

Při vývoji jsem se držel/a následujících postupů:

*   **Verzování kódu:** Pro správu zdrojového kódu jsem aktivně používal/a **Git**. To mi umožnilo efektivně sledovat všechny změny, snadno se vracet k předchozím verzím a udržovat přehlednou historii projektu.
*   **Využití AI asistence:** Pro zefektivnění vývoje jsem **jednotlivé části kódu generoval/a a refaktoroval/a s pomocí nástrojů umělé inteligence**. To mi pomohlo urychlit proces psaní boilerplate kódu a prozkoumat různé možnosti refaktoringu pro čistší a efektivnější řešení.
*   **Vývojové prostředí:** Pro zajištění konzistentního a izolovaného vývojového prostředí jsem využil/a **Docker a Docker Compose**. Díky tomu mám jistotu, že mé lokální prostředí (PHP, MySQL, webový server) přesně odpovídá produkčnímu nastavení, což eliminuje problémy typu "u mě to funguje".
*   **Iterativní přístup:** Vývoj probíhal iterativně. Nejprve jsem implementoval/a základní funkcionality jako zobrazení seznamu, poté jsem postupně přidával/a CRUD operace a nakonec jsem se zaměřil/a na správu zápůjček a filtrování.
*   **Testování:** V rámci tohoto projektu jsem **nepsal/a automatizované testy**. Funkčnost aplikace jsem ověřoval/a **manuálním testováním** každé implementované části, abych zajistil/a její správné chování.

---

### 3. Kroky, kterými uchazeč prošel při realizaci

Realizace projektu probíhala v několika klíčových fázích:

1.  **Inicializace projektu:** Začal/a jsem založením nového Symfony projektu a konfigurací **Docker Compose** pro spuštění PHP aplikace a **MySQL** databáze.
2.  **Návrh databáze:** Následoval návrh databázového schématu. Definoval/a jsem Doctrine entity (`MediaItem`, `Book`, `CD`, `DVD`, `Loan`) a jejich vzájemné vztahy. Poté jsem vygeneroval/a a aplikoval/a migrace pro vytvoření databázového schématu v **MySQL**.
3.  **Implementace základního CRUD:** V této fázi jsem vytvořil/a kontrolery, formuláře a Twig šablony, které umožňují základní operace (vytvoření, čtení, úpravu a mazání) pro mediální položky. **Při tvorbě těchto částí jsem aktivně využíval/a AI pro generování počátečních struktur a refaktoring.**
4.  **Rozšíření o specifické typy:** Dále jsem implementoval/a logiku pro rozlišení knih, CD a DVD, včetně přidání specifických polí pro každý typ a možnosti filtrování.
5.  **Implementace správy zápůjček:** Klíčovým krokem bylo přidání funkcionality pro evidenci jména půjčujícího a vytvoření přehledu všech aktuálně zapůjčených položek.
6.  **Frontendové úpravy:** Pro vylepšení uživatelského rozhraní jsem aplikoval/a styly z **Bootstrapu** a přidal/a interaktivní prvky pomocí **čistého JavaScriptu**, vše s využitím **Webpack Encore** pro správu assetů. **I zde mi AI pomohla s návrhem a implementací některých komponent.**
7.  **Refaktoring a optimalizace:** Průběžně jsem prováděl/a refaktoring kódu, zajišťoval/a bezpečnostní aspekty (např. CSRF ochranu, validaci dat) a optimalizoval/a výkon aplikace.

---

### 4. Znalost použitých technologií

Během vývoje jsem prokázal/a znalost a schopnost pracovat s následujícími technologiemi:

*   **PHP 8.2+:** Mám zkušenosti s moderními vlastnostmi PHP, což mi umožnilo psát čistý, efektivní a udržovatelný kód.
*   **Symfony 7.4:** Rozumím komponentám frameworku (Routing, Controller, Form, Validator, Security, Twig, DoctrineBundle), principům service containeru a osvědčeným postupům pro vývoj webových aplikací v Symfony.
*   **Doctrine ORM 3.6+:** Ovládám objektově-relační mapování, práci s entitami, repozitáři, DQL (Doctrine Query Language) a správu databázového schématu pomocí migrací.
*   **MySQL 8.0:** Mám znalosti relačních databází, SQL dotazů, databázového designu a optimalizace pro efektivní ukládání a načítání dat.
*   **Twig:** Znám šablonovací jazyk Twig a umím ho efektivně využívat pro tvorbu bezpečného a dynamického uživatelského rozhraní.
*   **Bootstrap:** Mám praktické zkušenosti s CSS frameworkem Bootstrap pro rychlou a responzivní tvorbu uživatelského rozhraní.
*   **Čistý JavaScript:** Umím implementovat dynamické a interaktivní prvky na frontendu pomocí Vanilla JS, bez závislosti na těžkých frameworkech.
*   **Webpack Encore:** Rozumím, jak spravovat a kompilovat frontendové assety (JavaScript, CSS) pro optimalizované načítání v prohlížeči.
*   **Docker/Docker Compose:** Mám zkušenosti s kontejnerizací pro nastavení a správu vývojového prostředí.
*   **Git:** Ovládám základní Git příkazy a workflow pro efektivní verzování kódu.

---

### 5. Vyvinuté funkcionality

Aplikace poskytuje následující klíčové funkcionality:

*   **Komplexní správa položek:** Uživatelé mohou snadno přidávat, prohlížet, upravovat a mazat záznamy pro knihy, CD a DVD.
*   **Detailní evidence:** Pro každou položku jsou evidovány relevantní informace, jako je název, autor/režisér, datum pořízení a popis.
*   **Filtrování a přehled:** Implementoval/a jsem možnost filtrovat seznam položek podle jejich typu (jen knihy, jen CD, jen DVD), což výrazně zlepšuje přehlednost sbírky.
*   **Správa zápůjček:** Klíčovou funkcionalitou je sledování, kdo si co půjčil. Uživatel může evidovat jméno půjčujícího a následně si zobrazit přehled všech aktuálně zapůjčených položek.
*   **Uživatelsky přívětivé rozhraní:** Díky použití **Bootstrapu** a **čistého JavaScriptu** je rozhraní přehledné, responzivní a intuitivní, což zajišťuje příjemnou a efektivní práci s evidencí.

---

### 6. Uložiště dat

Pro ukládání dat jsem zvolil/a **relační databázi MySQL**, jejíž konfigurace připojení je řešena pomocí proměnných prostředí v souboru `.env`.

**Důvod volby:** Relační databáze je ideální pro strukturovaná data s jasnými vztahy, jako jsou mediální položky a jejich zápůjčky. Zajišťuje datovou integritu, konzistenci a efektivní dotazování.

**Návrh schématu:**

*   Mám základní tabulku `MediaItem`, která obsahuje společné atributy pro všechny typy nosičů (např. název, popis, datum pořízení, typ nosiče).
*   Specifické atributy pro knihy, CD a DVD jsou řešeny (zde upřesněte: např. "pomocí Single Table Inheritance v Doctrine, kde všechny typy sdílí jednu tabulku a jsou rozlišeny sloupcem 'discr'" nebo "pomocí Mapped Superclass, kde každá entita má svou tabulku, ale sdílí společné mapování").
*   Tabulka `Loan` obsahuje informace o zápůjčce (jméno půjčujícího, datum zápůjčky) a odkazuje na `MediaItem`, který byl zapůjčen.

**Přístup k datům:** Veškerá interakce s databází probíhá prostřednictvím **Doctrine ORM**, což mi umožňuje pracovat s daty jako s PHP objekty a abstrahuje složité SQL dotazy.

---

### 7. Vypracovaná dokumentace (i v kódu)

V rámci projektu jsem se zaměřil/a i na dokumentaci:

*   **Dokumentace v kódu:** Kód je opatřen komentáři (PHPDoc) pro vysvětlení složitějších částí, účelu tříd, metod a parametrů. Používám srozumitelné názvy proměnných a funkcí pro zvýšení čitelnosti a udržovatelnosti kódu.
*   **README.md:** V kořenovém adresáři projektu se nachází soubor `README.md`, který poskytuje základní informace o aplikaci, návod na spuštění (včetně Dockeru), popis hlavních funkcionalit a případné požadavky.
*   **Doctrine Migrations:** Samotné migrace slouží jako cenná dokumentace změn databázového schématu v průběhu vývoje projektu.
*   **Konfigurace:** Konfigurační soubory (např. `config/packages/*.yaml`, `.env`) jsou dobře strukturované a opatřené komentáři, což usnadňuje pochopení nastavení aplikace.

---

### 8. Celková realizace výsledné aplikace

Jsem přesvědčen/a, že výsledná aplikace představuje robustní a funkční řešení pro domácí evidenci mediálních nosičů.

*   **Splnění požadavků:** Aplikace plně implementuje všechny požadované funkcionality, včetně komplexních CRUD operací a správy zápůjček.
*   **Stabilita a spolehlivost:** Díky použití osvědčeného frameworku Symfony a Doctrine ORM je aplikace stabilní a spolehlivá v práci s daty.
*   **Udržovatelnost:** Kód je strukturovaný, modulární a dodržuje standardy Symfony, což usnadňuje budoucí údržbu a případné rozšiřování o nové funkcionality.
*   **Uživatelská zkušenost:** Díky použití **Bootstrapu** a **čistého JavaScriptu** je uživatelské rozhraní moderní, responzivní a intuitivní, což zajišťuje příjemnou a efektivní práci s evidencí.
*   **Připravenost k nasazení:** Kontejnerizace pomocí Dockeru výrazně zjednodušuje proces nasazení aplikace na server.

---

Děkuji za pozornost a jsem připraven/a zodpovědět vaše dotazy.
