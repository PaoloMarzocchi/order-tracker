# Documentazione API

Base URL: `http://localhost:8000/api`

---

## Autenticazione

### Login
```http
POST /login
Accept: application/json
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

**Risposta 200:**
```json
{
  "token": "1|xxxxxxxxxxxxx"
}
```

**Risposta 401:**
```json
{
  "message": "Invalid credentials"
}
```

### Logout
```http
POST /logout
Authorization: Bearer {token}
```

**Risposta 200:**
```json
{
  "message": "Logged out successfully"
}
```

---

## Clienti

Tutte le route richiedono autenticazione: `Authorization: Bearer {token}`

### Lista Clienti
è possibile passare il parametro `show_deleted=true` per restituire anche i clienti soft-deleted

```http
GET /customers 
GET /customers?show_deleted=true
```

**Risposta 200:**
```json
[
    {
        "id": 3,
        "name": "Coralie Dibbert",
        "email": "greenfelder.phoebe@example.com",
        "phone": "(301) 463-8419",
        "address": "573 Margie Station Suite 378East Marlee, NJ 73720-5556",
        "created_at": "2026-02-14T11:52:09.000000Z",
        "updated_at": "2026-02-16T15:51:32.000000Z",
        "deleted_at": null
    },
]
```

### Dettaglio Cliente
```http
GET /customers/{id}
```

**Risposta 200:**
```json
{
    "id": 3,
    "name": "Coralie Dibbert",
    "email": "greenfelder.phoebe@example.com",
    "phone": "(301) 463-8419",
    "address": "573 Margie Station Suite 378East Marlee, NJ 73720-5556",
    "created_at": "2026-02-14T11:52:09.000000Z",
    "updated_at": "2026-02-16T15:51:32.000000Z",
    "deleted_at": null
}
```

### Creazione Cliente
```http
POST /customers
Content-Type: application/json
```
nel body della richiesta
```json
{
    "name": "Napoleon Kassulke",
    "email": "roslyn.ankunding@example.net",
    "phone": "+1-424-982-4930",
    "address": "10228 Hill Falls Apt. 219\nSouth Leehaven, AR 76580-7149",
}
```

**Risposta 201:**
```json
{
    "id": 4,
    "name": "Napoleon Kassulke",
    "email": "roslyn.ankunding@example.net",
    "phone": "+1-424-982-4930",
    "address": "10228 Hill Falls Apt. 219\nSouth Leehaven, AR 76580-7149",
    "created_at": "2026-02-14T11:52:09.000000Z",
    "updated_at": "2026-02-14T11:52:09.000000Z",
    "deleted_at": null
}
```

### Modifica Cliente
```http
PUT /customers/{id}
Content-Type: application/json
```
nel body della richiesta
```json
{
    "name": "Napoleon Kassulke",
    "email": "napoleon.kassulke@example.net",
    "phone": "+1-424-982-4930",
    "address": "10228 Hill Falls Apt. 219\nSouth Leehaven, AR 76580-7149",
}
```

**Risposta 200:**
```json
{
    "id": 4,
    "name": "Napoleon Kassulke",
    "email": "napoleon.kassulke@example.net",
    "phone": "+1-424-982-4930",
    "address": "10228 Hill Falls Apt. 219\nSouth Leehaven, AR 76580-7149",
    "created_at": "2026-02-14T11:52:09.000000Z",
    "updated_at": "2026-02-14T11:52:09.000000Z",
    "deleted_at": null
}
```

### Cancellazione Cliente
```http
DELETE /customers/{id}
```

**Risposta 200:**
```json
{
  "message": "Customer deleted successfully."
}
```

**Note:** Utilizza SoftDelete — il cliente non viene eliminato fisicamente. Gli ordini associati in stato non finale vengono marcati come `customer_cancelled`.

---

## Ordini

Tutte le route richiedono autenticazione: `Authorization: Bearer {token}`

### Lista Ordini
```http
GET /orders
GET /orders?status=pending
GET /orders?status=completed
```

**Risposta 200:**
```json
{
  "data": [
    {
        "id": 41,
        "customer_id": 4,
        "order_number": "15343516",
        "status": "pending",
        "total_amount": "100.00",
        "order_date": "2026-02-21T00:00:00.000000Z",
        "created_at": "2026-02-17T09:11:52.000000Z",
        "updated_at": "2026-02-17T09:11:52.000000Z",
        "customer": {
            "id": 4,
            "name": "Napoleon Kassulke",
            "email": "roslyn.ankunding@example.net",
            "phone": "+1-424-982-4930",
            "address": "10228 Hill Falls Apt. 219\nSouth Leehaven, AR 76580-7149",
            "created_at": "2026-02-14T11:52:09.000000Z",
            "updated_at": "2026-02-14T11:52:09.000000Z",
            "deleted_at": null
        }
    },
  ],
  "links": {...},
  "meta": {...}
}
```

### Dettaglio ordine
```http
GET /orders/{id}
```

**Risposta 200:**
```json
{
    "id": 41,
    "customer_id": 4,
    "order_number": "15343516",
    "status": "pending",
    "total_amount": "100.00",
    "order_date": "2026-02-21T00:00:00.000000Z",
    "created_at": "2026-02-17T09:11:52.000000Z",
    "updated_at": "2026-02-17T09:11:52.000000Z",
    "customer": {
        "id": 4,
        "name": "Napoleon Kassulke",
        "email": "roslyn.ankunding@example.net",
        "phone": "+1-424-982-4930",
        "address": "10228 Hill Falls Apt. 219\nSouth Leehaven, AR 76580-7149",
        "created_at": "2026-02-14T11:52:09.000000Z",
        "updated_at": "2026-02-14T11:52:09.000000Z",
        "deleted_at": null
    }
}
```

### Creazione Ordine
```http
POST /orders
Content-Type: application/json
```
nel body della richiesta
```json
{
  "customer_id": 4,
  "total_amount": 150.00,
  "order_date": "2026-02-15",
  "status": "pending"
}
```

**Risposta 201:**
```json
{
    "customer_id": 4,
    "total_amount": 150,
    "status": "pending",
    "order_date": "2026-02-15T00:00:00.000000Z",
    "order_number": "05774177",
    "updated_at": "2026-02-18T08:44:52.000000Z",
    "created_at": "2026-02-18T08:44:52.000000Z",
    "id": 43
}
```

**Note:** `order_number` viene generato automaticamente se non fornito.

### Modifica Ordine
```http
PUT /orders/{id}
Content-Type: application/json
```
nel body della richiesta
```json
{
    "id": 43,
    "customer_id": 4,
    "order_number": "05774177",
    "status": "pending",
    "total_amount": 200,

}
```

**Risposta 200:**
```json
{
    "id": 43,
    "customer_id": 4,
    "order_number": "05774177",
    "status": "pending",
    "total_amount": 200,
    "order_date": "2026-02-15T00:00:00.000000Z",
    "created_at": "2026-02-18T08:44:52.000000Z",
    "updated_at": "2026-02-18T08:50:27.000000Z"
}
```

**Risposta 422 (transizione stato non valida):**
```json
{
  "message": "Invalid status transition from Completed to Pending"
}
```

**Note:** Gli ordini in stato `completed`, `cancelled` o `customer_cancelled` non possono essere modificati.

### Cancellazione Ordine
```http
DELETE /orders/{id}
```

**Risposta 200:**
```json
{
  "message": "Order cancelled successfully."
}
```

**Risposta 422 (ordine già in stato finale):**
```json
{
  "message": "Invalid status transition from Completed to Cancelled"
}
```

**Note:** Non elimina l'ordine ma ne cambia lo stato a `cancelled`.

---

## Stati Ordine

-  `pending`: possibili variazioni in -> `processing`, `cancelled`, `customer_cancelled` |
-  `processing`: possibili variazioni in -> `completed`, `cancelled`, `customer_cancelled` |
-  `completed`: nessuna possibile variazione
-  `cancelled`: nessuna possibile variazione
-  `customer_cancelled`: nessuna possibile variazione
