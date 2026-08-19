# Symfony Docker Projekt

Tento projekt obsahuje Symfony aplikaci připravenou pro nasazení v Dockeru s PHP 8.3 a MySQL. Frontend je spravován pomocí Webpack Encore a Bootstrapu.

## Požadavky

- Docker
- Docker Compose (plugin pro `docker compose`)
- Node.js a npm (vyžadováno uvnitř PHP kontejneru pro správu frontend závislostí a sestavování assetů)

## Předpoklady pro hostitelský systém

Pro bezproblémový vývoj a spouštění projektu na vašem hostitelském systému (např. Ubuntu ve WSL) se doporučují následující verze nástrojů:

-   **Operační systém:** Ubuntu 22.04 LTS nebo novější (nebo jiný kompatibilní Linux/macOS/Windows s WSL2).
-   **Docker:** Verze 24.x.x nebo novější.
-   **Docker Compose:** Verze v2.x.x nebo novější.
-   **Node.js:** Verze 20.10.0 nebo novější (doporučena nejnovější LTS verze). *Tato verze je klíčová pro správné fungování `npm` příkazů, zejména pokud je omylem spustíte na hostiteli, nebo pro jiné projekty.*
-   **npm:** Verze 10.x.x nebo novější.

## Nastavení projektu

Po naklonování repozitáře postupujte podle těchto kroků:

### 1. Sestavení a spuštění kontejnerů

Tento příkaz sestaví Docker obrazy (pokud je to poprvé nebo pokud se změnily soubory `Dockerfile`) a spustí kontejnery na pozadí.

**Důležité:** Pokud jste provedli změny v `Dockerfile` (např. přidali `nodejs` a `npm`), je nutné obraz znovu sestavit. Pro zajištění čistého sestavení a spuštění nového kontejneru doporučujeme následující postup:

```bash
# 1. Zastavte a odstraňte existující PHP kontejner (pokud běží)
docker compose stop php
docker compose rm -f php

# 2. Znovu sestavte obraz služby PHP s vynuceným sestavením (bez cache)
docker compose build --no-cache php

# 3. Spusťte všechny služby
docker compose up -d
```

Pokud jste neprovedli změny v `Dockerfile` a projekt pouze spouštíte poprvé, nebo po zastavení, jednoduše:
```bash
docker compose up -d --build
```

### 2. Instalace Composer závislostí

Spusťte Composer uvnitř PHP kontejneru pro instalaci všech potřebných knihoven definovaných v `composer.lock`.
```bash
docker compose exec php composer install
```

### 3. Instalace frontend závislostí (Node.js)

Po instalaci Composer závislostí je potřeba nainstalovat frontend závislosti (např. Bootstrap) pomocí npm. **Tento příkaz se provádí uvnitř PHP kontejneru.**
```bash
docker compose exec php npm install
```

### 4. Sestavení frontend assetů (Webpack Encore)

Použijte Webpack Encore k sestavení CSS a JavaScript souborů (včetně Bootstrapu). **Tyto příkazy se provádějí uvnitř PHP kontejneru.**

```bash
# Pro vývoj (s režimem sledování, který automaticky znovu sestavuje při změnách souborů).
# Spusťte tento příkaz jednou na začátku vývojové relace v samostatném terminálu a nechte ho běžet.
docker compose exec php npm run dev

# Pro produkci (optimalizované a minifikované soubory).
# Spusťte tento příkaz jednou při přípravě na nasazení.
# docker compose exec php npm run build
```

### 5. Spuštění Doctrine migrací

Před spuštěním migrací je nutné vytvořit databázi:
```bash
docker compose exec php php bin/console doctrine:database:create
```

Pokud je databáze prázdná nebo potřebuje aktualizace schématu, spusťte migrace.
```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

### 6. Vymazání Symfony cache

Pro jistotu vymažte Symfony cache.
```bash
docker compose exec php php bin/console cache:clear
```

### 7. Spuštění Symfony webového serveru (pouze pro vývoj)

Spusťte vestavěný Symfony webový server uvnitř PHP kontejneru. Parametr `--allow-all-ip` je klíčový pro to, aby byl server přístupný zvenčí kontejneru.
**Varování:** Tento vestavěný server je určen **pouze pro vývojové účely** a není vhodný pro produkční prostředí. Pro produkci byste měli použít robustní webový server jako Nginx nebo Apache s PHP-FPM.
```bash
docker compose exec php symfony server:start --allow-all-ip
```

Aplikace by nyní měla být přístupná na **http://localhost:8000/en/mediaitem** (pro angličtinu) nebo **http://localhost:8000/cs/mediaitem** (pro češtinu).

---

## Běžné příkazy

### Spuštění kontejnerů
```bash
docker compose up -d
```

### Zastavení kontejnerů
```bash
docker compose down
```
**Varování:** Příkaz `docker compose down -v` také odstraní databázové svazky, čímž smaže všechna data v databázi. Pokud si přejete data zachovat, použijte pouze `docker compose down` nebo `docker compose stop`/`start`.

### Spouštění příkazů v kontejneru

Pro spuštění jakéhokoli příkazu (např. `php bin/console`) uvnitř PHP kontejneru použijte `docker compose exec php ...`:
```bash
# Příklad: Vymazání cache
docker compose exec php php bin/console cache:clear

# Příklad: Spuštění migrací
docker compose exec php php bin/console doctrine:migrations:migrate

# Příklad: Sestavení frontend assetů
docker compose exec php npm run dev

# Příklad: Spuštění Symfony webového serveru
docker compose exec php symfony server:start --allow-all-ip
```
