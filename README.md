# Order tracker
Gestionale interno per la gestione di ordini e clienti.

## Stack tecnologico
- Backend: Laravel 12.x
- Frontend: Blade + Alpine.js
- CSS: Tailwind CSS
- Database: MySQL
- Autenticazione lato backend: Laravel Breeze
- Testing: Pest

## Scelte tecniche
È stato utilizzato Laravel 12.x perchè è la versione più recente e stabile.

Per il frontend è stato scelto di utilizzare il sistema di templating nativo di Laravel Blade, con Alpine.js per la gestione dell'interattività lato client, questo ha permesso una più rapida esecuzione del frontend, data la UI/UX dell'esercizio molto snella.

Per il flusso di autenticazione è stato scelto Laravel Breeze, da Laravel 12.x in poi non viene più inserita negli starter kit, rendendola deprecated, ma attualmente rimane una soluzione pienamente funzionante.

Per la parte di API Restful invece è stato utilizzato Laravel sanctum per la protezione delle rotte, garantendo sicurezza dei dati, con autenticazione token-based.

## Setup

- Clonare la repository in locale

- Installare le dipendenze PHP

```bash
composer install
```
- Creare il file .env dall' .env.example e generare la key

```bash
php artisan key:generate
```

- Configurare il file .env e la connessione al database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_tracker
DB_USERNAME=root
DB_PASSWORD=
```

- Creare il database

Creare manualmente il database `order_tracker`

- Eseguire migration e seeder

```bash
php artisan migrate --seed
```

- Installare le dipendenze frontend

```bash
npm install
```
- Avviare i due server su due terminali separati

```bash
# Per compilare gli asset frontend
npm run dev

# Per avviare il server Laravel
php artisan serve
```

L'applicazione sarà disponibile su `http://localhost:8000`.

Tramite l' UserSeeder, sarà disponibile il login con queste credenziali:

```
Email:    admin@example.com
Password: password
```
## Test
```bash
php artisan test
```
Per i test sono stati implementati due feature test per il flusso API,

- AuthTest -> per il login tramite API
- CustomerTest -> per le operazioni CRUD tramite API

## Vincoli Logici Implementati

**1. Cliente eliminato non elimina gli ordini**
- Implementato SoftDelete sul modello `Customer`
- Gli ordini mantengono il riferimento al cliente eliminato
- Observer su `Customer` aggiorna lo stato degli ordini non finali a `customer_cancelled`

**2. Ordini non modificabili se completati o annullati**
- Policy `OrderPolicy` blocca l'edit degli ordini in stato finale
- Observer `OrderObserver` impedisce aggiornamenti su ordini finali

**3. Aggiornamento stato coerente**
- Enum `OrderStatus` con metodo `canTransitionTo()` per gestire la coerenza dei cambi di stato
- Observer `OrderObserver` valida ogni cambio di stato prima del salvataggio
- Flusso unidirezionale: `pending` → `processing` → `completed` / `cancelled`

## API

La documentazione delle API è disponibile nel file [API.md](./API.md).