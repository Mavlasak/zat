# Symfony Docker Project

Tento projekt obsahuje Symfony aplikaci připravenou pro spuštění v Dockeru s PHP 8.3, MySQL a PostgreSQL. Frontend je spravován pomocí Webpack Encore a Bootstrapu.

## Požadavky

- Docker
- Docker Compose (plugin pro `docker compose`)
- Node.js a npm (pro správu frontendových závislostí uvnitř Docker kontejneru)

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

Po instalaci Composer závislostí je potřeba nainstalovat i frontendové závislosti (např. Bootstrap) pomocí npm.
```bash
docker compose exec php npm install
```

### 4. Sestavení frontendových assetů (Webpack Encore)

Pro sestavení CSS a JavaScript souborů (včetně Bootstrapu) použijte Webpack Encore.
```bash
# Pro vývoj (s watch režimem, který automaticky přebudovává při změnách souborů)
docker compose exec php npm run dev

# Pro produkci (optimalizované a minifikované soubory)
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

### 7. Spuštění Symfony webového serveru

Spusťte vestavěný webový server Symfony uvnitř PHP kontejneru. Parametr `--allow-all-ip` je klíčový, aby byl server dostupný zvenčí kontejneru.
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
