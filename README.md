# ScholarConnect

**Smart Scholarship Aggregator and Alert System**
IT 111 Final Project · BSIT 2A · Camarines Norte State College

> Aligned with **SDG 4 — Quality Education**: Ensuring inclusive and equitable access to scholarship opportunities for students in Camarines Norte.

---

## What is ScholarConnect?

ScholarConnect is a Laravel 11 web application that automatically aggregates scholarship listings from multiple government sources (CHED, DOST-SEI, and Local Government Units), matches them to registered student profiles, and sends real-time email alerts — so no Camarines Norte student misses a scholarship deadline again.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 11 (PHP 8.2) |
| Database | MySQL 8.0 |
| Frontend | Bootstrap 5 (no npm build step) |
| Containerization | Docker + Docker Compose |
| Mock API Server | PHP built-in server (3 instances) |
| Mail | Mailtrap (SMTP) |
| Queue | Laravel Database Queue |

---

## One-Click Setup

### Requirements
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed and running
- Port `8000` and `8080` must be free

### Start the app

```bash
git clone <repo-url> scholarconnect
cd scholarconnect
docker-compose up --build
```

That's it. The `entrypoint.sh` will automatically:

1. Run `composer install` inside the container
2. Check and configure `.env`
3. Generate `APP_KEY`
4. Run `migrate:fresh --seed` (fresh database with demo data)
5. Start the queue worker and Laravel dev server

App will be live at: **http://localhost:8000**

### Updating mock API data (no rebuild needed)

The `mock-api/data/` folder is volume-mounted. To update JSON files:

```bash
# Edit any file in mock-api/data/
docker-compose restart mock-api
```

### Full reset

```bash
docker-compose down -v
docker-compose up --build
```

---

## Demo Credentials

### Admin Account
| Field | Value |
|---|---|
| Email | `admin@scholarconnect.test` |
| Password | `password` |

### Student Accounts
| Name | Email | Password |
|---|---|---|
| Student 1 | `student1@scholarconnect.test` | `password` |
| Student 2 | `student2@scholarconnect.test` | `password` |
| Student 3 | `student3@scholarconnect.test` | `password` |

---

## Live Demo Steps

Follow these steps in order during the exhibit demo:

**1. Show the landing page**
Navigate to `http://localhost:8000` — show the public scholarship browse page. No login required.

**2. Log in as Admin**
Go to `/login`, use `admin@scholarconnect.test` / `password`.

**3. Trigger a Sync**
On the Admin Dashboard, click **"Sync Scholarships"**. This sends HTTP GET requests to all 3 mock API servers, normalizes the data, and stores it in MySQL.

**4. Show sync results**
The dashboard displays: sources fetched, total scholarships created/updated, and emails sent to matched students.

**5. Log out → Log in as Student**
Use `student1@scholarconnect.test` / `password`.

**6. Show the Student Dashboard**
Student sees only scholarships matched to their profile (course, year level, municipality).

**7. Show Email Notification**
Open Mailtrap inbox — show the scholarship alert email sent to the student during sync.

**8. Browse all scholarships**
Navigate to `/scholarships` — show the full list with filtering. Highlight the 12 Camarines Norte municipality-specific LGU grants.

---

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     Docker Network                          │
│                                                             │
│  ┌──────────────┐    HTTP GET    ┌─────────────────────┐   │
│  │  Mock API    │◄───────────────│                     │   │
│  │  Server      │                │  ScholarConnect     │   │
│  │  :8080       │                │  Middleware          │   │
│  │              │                │  (normalizes data)  │   │
│  │  · CHED      │────────────────►                     │   │
│  │  · DOST-SEI  │   JSON resp.   └────────┬────────────┘   │
│  │  · LGU       │                         │                │
│  └──────────────┘                         │ Eloquent ORM   │
│                                           ▼                │
│                                  ┌─────────────────┐       │
│                                  │   MySQL 8.0     │       │
│                                  │   Database      │       │
│                                  └────────┬────────┘       │
│                                           │                │
│                          ┌────────────────┼──────────────┐ │
│                          ▼                ▼              │ │
│                 ┌──────────────┐  ┌──────────────┐      │ │
│                 │ Notification │  │ Student      │      │ │
│                 │ Service      │  │ Dashboard    │      │ │
│                 │ (match +     │  │ (Blade views)│      │ │
│                 │  email)      │  └──────────────┘      │ │
│                 └──────┬───────┘                        │ │
│                        │ SMTP                           │ │
│                        ▼                               │ │
│                 ┌──────────────┐                       │ │
│                 │  Mailtrap    │                       │ │
│                 │  (email)     │                       │ │
│                 └──────────────┘                       │ │
└─────────────────────────────────────────────────────────────┘
```

**Data flow:** Mock APIs → HTTP GET → `ScholarConnectMiddleware` → Eloquent → MySQL → `NotificationService` → SMTP → Student email + Student Dashboard

---

## SDG 4 — Quality Education

ScholarConnect directly supports **UN Sustainable Development Goal 4** by:

- **Reducing information barriers** — Students in remote Camarines Norte municipalities (Capalonga, San Lorenzo Ruiz, Talisay, etc.) no longer need to manually check multiple government websites for scholarship updates.
- **Automated matching** — The system matches scholarships to student profiles by course, year level, and municipality — surfacing only relevant opportunities.
- **Proactive alerts** — Email notifications ensure students are informed before deadlines, not after.
- **Coverage of 12 municipalities** — LGU scholarship data covers all 12 municipalities of Camarines Norte: Daet, Labo, Vinzons, Capalonga, Jose Panganiban, Mercedes, Paracale, San Lorenzo Ruiz, Santa Elena, Talisay, Basud, and a province-wide grant.
- **Multi-source aggregation** — CHED, DOST-SEI, and LGU scholarships are unified in one platform — 23 scholarships across all sources.

---

## Project Structure

```
scholarconnect/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── SyncController.php       # HTTP sync trigger, JSON response
│   │   │   └── ...
│   │   └── Middleware/
│   │       └── ScholarConnectMiddleware.php  # API fetch + normalize (Minguez)
│   ├── Models/                          # Eloquent models (Villafranca)
│   └── Services/
│       └── NotificationService.php      # Match + email dispatch
├── resources/views/                     # Blade templates (Lagrosa, Abiera)
├── mock-api/
│   ├── data/
│   │   ├── ched_scholarships.json       # 6 CHED scholarships
│   │   ├── dost_scholarships.json       # 5 DOST-SEI scholarships
│   │   └── lgu_scholarships.json        # 12 LGU scholarships (all CN municipalities)
│   └── server.php
├── Dockerfile
├── docker-compose.yml
└── entrypoint.sh
```

---

## Team

| Member | Role | Responsibilities |
|---|---|---|
| **Minguez** | Lead Architect | `ScholarConnectMiddleware.php`, API contracts, data normalization |
| **Villafranca** | Backend Developer | Database schema, Eloquent models, business logic |
| **Lagrosa** | Frontend Developer | Student-facing UI, Bootstrap layouts, scholarship browse |
| **Abiera** | Frontend Developer | Admin dashboard UI, charts, notification management |

---

## Important Notes for Graders

- Running `docker-compose up --build` always produces a **clean, consistent state** — fresh migrations and seeded demo accounts every time.
- The `vendor/` folder is intentionally absent from the project root. The container installs its own dependencies via `entrypoint.sh`. Do not run `composer install` on Windows.
- All 3 mock API servers run inside the same Docker network — no external internet connection required to demo the app.
- Mail notifications require a valid Mailtrap SMTP config in `.env` (`