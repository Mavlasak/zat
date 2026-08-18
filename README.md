# Symfony Docker Project

Tento projekt obsahuje Symfony aplikaci připravenou pro spuštění v Dockeru s PHP 8.3 a MySQL.

## Požadavky

- Docker
- Docker Compose (plugin pro `docker compose`)

## Spuštění projektu

Po naklonování repozitáře postupujte následovně:

### 1. Sestavení a spuštění kontejnerů

Tento příkaz sestaví Docker obrazy (pokud je to poprvé) a spustí kontejnery na pozadí.
```bash
docker compose up -d --build
```

### 2. Instalace závislostí

Spusťte Composer uvnitř PHP kontejneru, aby se nainstalovaly všechny potřebné knihovny definované v `composer.lock`.
```bash
docker compose exec php composer install
```

### 3. Spuštění Symfony serveru

Nyní spustíme samotný webový server. Parametr `--allow-all-ip` je klíčový, aby byl server dostupný zvenčí kontejneru.
```bash
docker compose exec php symfony server:start --allow-all-ip
```

Aplikace by nyní měla být dostupná na adrese **http://localhost:8000**.

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

### Spuštění příkazů v kontejneru

Pro spuštění jakéhokoliv příkazu (např. `symfony console` nebo `php bin/console`) uvnitř PHP kontejneru použijte `docker compose exec php ...`:
```bash
# Příklad: Vyčištění cache
docker compose exec php php bin/console cache:clear

# Příklad: Spuštění migrací
docker compose exec php php bin/console doctrine:migrations:migrate
```
