# Symfony Docker Project

Tento projekt obsahuje Symfony aplikaci připravenou pro spuštění v Dockeru s PHP 8.3, MySQL a PostgreSQL. Frontend je spravován pomocí Webpack Encore a Bootstrapu.

## Požadavky

- Docker
- Docker Compose (plugin pro `docker compose`)
- Node.js a npm (jsou vyžadovány uvnitř PHP kontejneru pro správu frontendových závislostí a sestavení assetů)

## Předpoklady pro hostitelský systém

Pro bezproblémový vývoj a spouštění projektu na vašem hostitelském systému (např. Ubuntu ve WSL) se doporučují následující verze nástrojů:

-   **Operační systém:** Ubuntu 22.04 LTS nebo novější (nebo jiný kompatibilní Linux/macOS/Windows s WSL2).
-   **Docker:** Verze 24.x.x nebo novější.
-   **Docker Compose:** Verze v2.x.x nebo novější.
-   **Node.js:** Verze 20.10.0 nebo novější (doporučena nejnovější LTS verze). *Tato verze je klíčová pro správné fungování `npm` příkazů, pokud byste je omylem spustili na hostu, nebo pro jiné projekty.*
-   **npm:** Verze 10.x.x nebo novější.

## Spuštění projektu

Po naklonování repozitáře postupujte následovně:

### 1. Sestavení a spuštění kontejnerů

Tento příkaz sestaví Docker obrazy (pokud je to poprvé) a spustí kontejnery na pozadí.
```bash
docker compose up -d --build
```

### 2. Instalace Composer závislostí

Spusťte Composer uvnitř PHP kontejneru, aby se nainstalovaly všechny potřebné knihovny definované v `composer.lock`.
```bash
docker compose exec php composer install
```

### 3. Instalace frontendových závislostí (Node.js)

Po instalaci Composer závislostí je potřeba nainstalovat i frontendové závislosti (např. Bootstrap) pomocí npm. **Tento příkaz se spouští uvnitř PHP kontejneru.**
```bash
docker compose exec php npm install
```

### 4. Sestavení frontendových assetů (Webpack Encore)

Pro sestavení CSS a JavaScript souborů (včetně Bootstrapu) použijte Webpack Encore. **Tyto příkazy se spouští uvnitř PHP kontejneru.**

```bash
# Pro vývoj (s watch režimem, který automaticky přebudovává při změnách souborů).
# Spusťte tento příkaz jednou na začátku vaší vývojové relace v samostatném terminálu a nechte ho běžet.
docker compose exec php npm run dev

# Pro produkci (optimalizované a minifikované soubory).
# Spusťte tento příkaz jednou při přípravě na nasazení.
# docker compose exec php npm run build
```

### 5. Spuštění Doctrine migrací

Pokud je databáze prázdná nebo potřebuje aktualizovat schéma, spusťte migrace.
```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

### 6. Vyčištění cache Symfony

Pro jistotu vyčistěte cache Symfony.
```bash
docker compose exec php php bin/console cache:clear
```

### 7. Spuštění Symfony webového serveru (pouze pro vývoj)

Spusťte vestavěný webový server Symfony uvnitř PHP kontejneru. Parametr `--allow-all-ip` je klíčový, aby byl server dostupný zvenčí kontejneru.
**Upozornění:** Tento vestavěný server je určen **pouze pro vývojové účely** a není vhodný pro produkční prostředí. Pro produkci byste měli použít robustní webový server jako Nginx nebo Apache s PHP-FPM.
```bash
docker compose exec php symfony server:start --allow-all-ip
```

Aplikace by nyní měla být dostupná na adrese **http://localhost:8000/en/mediaitem** (pro angličtinu) nebo **http://localhost:8000/cs/mediaitem** (pro češtinu).

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
**Upozornění:** Příkaz `docker compose down -v` odstraní i databázové svazky a tím smaže všechna data v databázi. Pokud si přejete zachovat data, používejte pouze `docker compose down` nebo `docker compose stop`/`start`.

### Spuštění příkazů v kontejneru

Pro spuštění jakéhokoliv příkazu (např. `php bin/console`) uvnitř PHP kontejneru použijte `docker compose exec php ...`:
```bash
# Příklad: Vyčištění cache
docker compose exec php php bin/console cache:clear

# Příklad: Spuštění migrací
docker compose exec php php bin/console doctrine:migrations:migrate

# Příklad: Sestavení frontendových assetů
docker compose exec php npm run dev

# Příklad: Spuštění Symfony webového serveru
docker compose exec php symfony server:start --allow-all-ip
```
