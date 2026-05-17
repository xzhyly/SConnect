# PHASE 4 — Admin Dashboard + Sync UI
> ScholarConnect | Laravel 11 | IT 111 Final Project | BSIT 2A | Camarines Norte State College
> Checkpoint: 2026-05-17 | DO NOT REDESIGN — continue from here

---

## 1. PROJECT OVERVIEW

**ScholarConnect** — Laravel 11 PHP web application for IT 111 final project at Camarines Norte State College, BSIT 2A.

**Purpose:** Localized Smart Scholarship Aggregator & Alert System for students across 12 municipalities of Camarines Norte. Aligned with SDG 4 (Quality Education).

**Stack:** Laravel 11, Bootstrap 5 CDN only (NO Tailwind, NO npm, NO Vite), Poppins font, Bootstrap Icons, MySQL via Docker.

**Running:**
- App → `localhost:8000`
- Mock API → `localhost:8080`
- Adminer → `localhost:8081` (server: db, user: scholarconnect, pass: secret)
- Docker container name: `scholarconnect_app`
- OS: Windows, `D:\IPT\scholarconnect`

---

## 2. PHASE 3 — COMPLETED ✅

All student-facing pages are DONE and WORKING:

- ✅ Landing page (`welcome.blade.php`) — hero, stats, features, featured scholarships, CTA
- ✅ Public Browse page (`/browse`) — guest mode, no login required
- ✅ Public About page (`/about`) — SDG 4, features, contact
- ✅ Forgot Password page (`/forgot-password`) — contact admin page
- ✅ `auth/login.blade.php` — standalone split layout
- ✅ `auth/register.blade.php` — standalone + success modal + 3s auto-redirect
- ✅ `StudentAuthController` — register/login/logout
- ✅ `layouts/student.blade.php` — fixed sidebar, amber avatar, first name only
- ✅ `student/dashboard.blade.php` — FULLY APPROVED, DO NOT TOUCH EVER
- ✅ `student/scholarships/index.blade.php` — browse page, sticky filters
- ✅ `student/scholarships/show.blade.php` — hero banner, bookmark toggle (JS fetch), alert toggle (persists to DB)
- ✅ `student/bookmarks/index.blade.php` — fade out on unbookmark, empty state
- ✅ `student/notifications.blade.php` — filter tabs, mark as read, color-coded icons
- ✅ `student/profile.blade.php` — sections, dropdowns, toggle switch
- ✅ `components/scholarship-card.blade.php` — pills, bookmark icon, JS fetch toggle
- ✅ `DashboardController` — stats, matched scholarships, upcoming deadlines, toggleAlerts
- ✅ `ScholarshipController` — filters, sort, paginate, publicIndex for guest browse
- ✅ `BookmarkController` — toggle method returns JSON
- ✅ Migration — `email_notifications` column added to users table

---

## 3. PHASE 4 — CURRENT GOAL

Build the **Admin Dashboard + Sync UI**.

This is the most critical part for the rubric:
- **Live Execution (40% of pitching grade)** — "Sync Now" button must make real HTTP calls to mock APIs → update DB → trigger email notifications

### Files to Build (in order):

| # | File | Type | Notes |
|---|------|------|-------|
| 1 | `admin/dashboard.blade.php` | NEW | KPI stats, Chart.js, recent sync logs |
| 2 | `Admin/DashboardController.php` | UPDATE | KPI queries, chart data |
| 3 | `admin/sync.blade.php` | NEW | Sync Now button, live progress, results |
| 4 | `Admin/SyncController.php` | UPDATE | HTTP fetch to mock APIs, upsert, notifications |
| 5 | `admin/scholarships/index.blade.php` | NEW | Admin scholarship list, manage |
| 6 | `Admin/ScholarshipController.php` | UPDATE | List, activate/deactivate |
| 7 | `admin/sync-logs.blade.php` | NEW | Sync history table |

---

## 4. DESIGN TOKENS (LOCKED — same as Phase 3)

```css
--navy-primary: #1B2A47
--navy-dark: #0F1C33
--amber: #F5A623
--amber-hover: #d48f1c
--text-muted: #B0BEC5
--bg-main: #F4F6F9
```

**Provider colors (LOCKED):**
- `ched` / `dost_sei` → purple `#7C3AED`
- `lgu` → green `#059669`
- `private` → orange `#D97706`

**Admin layout:**
- Same navy sidebar style as student layout
- But admin-specific nav links: Dashboard, Scholarships, Sync Now, Sync Logs
- Role label: "Administrator" instead of "Student"

---

## 5. ADMIN DASHBOARD TARGET UI

### KPI Stats Row (4 cards):
- Total Scholarships (active)
- Total Students Registered
- Syncs This Month
- Scholarships Added This Week

### Chart.js Section:
- Bar chart — Scholarship distribution by provider (CHED, DOST, LGU, Private)
- Data passed from controller via `@json()`

### Recent Sync Logs (last 5):
- Table: Source | Status | Records Synced | Date
- Status badges: green "Success", red "Failed"

---

## 6. SYNC NOW — CRITICAL REQUIREMENTS

This is the most important feature for the rubric demo.

**Button behavior:**
1. Admin clicks "Sync Now"
2. Button shows loading state (spinner + "Syncing...")
3. JS `fetch()` POST to `/admin/sync`
4. Controller makes HTTP GET to 3 mock API endpoints:
   - `http://mock-api:8080/api/ched`
   - `http://mock-api:8080/api/dost`
   - `http://mock-api:8080/api/lgu`
5. Normalizes JSON response via `ScholarConnectMiddleware`
6. Upserts into `scholarships` table via `updateOrCreate()`
7. Matches new scholarships against student profiles
8. Dispatches email notifications to eligible students
9. Logs sync result to `sync_logs` table
10. Returns JSON response with results
11. UI updates to show: records synced per source, total, timestamp

**MUST use:**
- `Http::get()` (Laravel HTTP Client) — NOT file_get_contents or curl
- `updateOrCreate(['source_url' => ...], [...])` — prevents duplicates
- `response()->json([...])` — returns JSON to JS fetch
- CSRF token in fetch headers

---

## 7. IMPORTANT RULES (LOCKED — never break)

- **Bootstrap 5 CDN only** — NO Tailwind, NO npm, NO Vite
- **Always ask for file contents before editing ANY file**
- **Dashboard files (student)** = APPROVED, never modify
- **All admin pages** = `@extends('layouts.admin')` (need to create this layout)
- **deadline >= now()** on ALL scholarship queries
- **Provider DB values** are lowercase: `ched`, `dost_sei`, `lgu`, `private`
- **Always use startOfDay()** on both sides of `diffInDays()` to prevent decimal days
- **Sync Now** must be real HTTP fetch — NO hardcoded data, NO fake responses

---

## 8. EXISTING ADMIN FILES TO CHECK FIRST

Before building anything, ask user to paste:
1. `app/Http/Controllers/Admin/DashboardController.php`
2. `app/Http/Controllers/Admin/SyncController.php`
3. `app/Http/Controllers/Admin/ScholarshipController.php`
4. `app/Services/ScholarConnectMiddleware.php`
5. `resources/views/admin/` (list files if any exist)
6. `app/Models/SyncLog.php`
7. `app/Mail/ScholarshipAlert.php`

---

## 9. ADMIN LAYOUT TO CREATE

Need to create `resources/views/layouts/admin.blade.php`:
- Same navy sidebar style as student layout
- Nav links: Dashboard, Scholarships, Sync Now, Sync Logs
- Role: "Administrator" label
- Avatar: amber circle with admin initial
- No student-specific links

---

## 10. DEMO SCENARIO (what must work for full marks)

```
Step 1 — Admin logs in → admin@scholarconnect.test / password
Step 2 — Admin clicks "Sync Now"
Step 3 → System makes HTTP GET to 3 mock API servers
Step 4 → Middleware normalizes JSON → upserts into MySQL
Step 5 → System matches new scholarships against student profiles
Step 6 → Email notification dispatched (visible in Mailtrap)
Step 7 → Admin dashboard shows updated KPIs
Step 8 → Student logs in → sees new scholarships in dashboard
```

---

## 11. NEXT STEPS (ORDERED)

1. Ask user to paste all existing admin files (listed in Section 8)
2. Create `layouts/admin.blade.php`
3. Build `admin/dashboard.blade.php` with KPI stats + Chart.js + sync logs
4. Update `Admin/DashboardController.php` with real DB queries
5. Build `admin/sync.blade.php` with Sync Now button + live JS fetch
6. Update `Admin/SyncController.php` — HTTP fetch to mock APIs + upsert + notifications
7. Build `admin/scholarships/index.blade.php` — scholarship management
8. Build `admin/sync-logs.blade.php` — full sync history
9. Test full demo scenario end-to-end

---

## 12. CONTINUATION PROMPT FOR NEXT AI SESSION

```
You are continuing Phase 4 of ScholarConnect — a Laravel 11 PHP web application for IT 111 final project at Camarines Norte State College, BSIT 2A.

CRITICAL: Do NOT redesign, do NOT restart, do NOT rethink. Continue exactly from where we left off.

PROJECT: ScholarConnect — scholarship matching app for Camarines Norte students.
STACK: Laravel 11, Bootstrap 5 CDN only (NO Tailwind, NO npm, NO Vite), Poppins font, Bootstrap Icons, MySQL via Docker.
RUNNING: Docker → localhost:8000. Mock API → localhost:8080. Container: scholarconnect_app.
OS: Windows, D:\IPT\scholarconnect

PHASE 3 — ALL DONE ✅:
- All student pages complete and working
- Landing page, public browse, about page complete
- student/dashboard.blade.php — FULLY APPROVED, DO NOT TOUCH EVER
- All bookmark, notification, profile features working

PHASE 4 — CURRENT GOAL: Admin Dashboard + Sync UI

MOST CRITICAL FEATURE (40% of pitching grade):
"Sync Now" button → real HTTP GET to 3 mock APIs → upsert DB → email notifications → JSON response

IMMEDIATE FIRST STEPS:
1. Ask user to paste these files:
   - app/Http/Controllers/Admin/DashboardController.php
   - app/Http/Controllers/Admin/SyncController.php
   - app/Services/ScholarConnectMiddleware.php
   - app/Models/SyncLog.php
   - app/Mail/ScholarshipAlert.php
2. List any existing admin blade files
3. Create layouts/admin.blade.php
4. Build admin/dashboard.blade.php

DESIGN TOKENS (LOCKED):
--navy-primary: #1B2A47 | --navy-dark: #0F1C33 | --amber: #F5A623
Provider colors: ched/dost_sei=#7C3AED, lgu=#059669, private=#D97706

LOCKED RULES (never break):
- Bootstrap 5 CDN only
- Always ask for file contents before editing ANY file
- Student dashboard = APPROVED, never touch
- deadline >= now() on ALL scholarship queries
- Provider DB values: lowercase (ched, dost_sei, lgu, private)
- Sync Now MUST use real Http::get() — no fake/hardcoded data
- Use updateOrCreate(['source_url' => ...]) for upsert
- Return response()->json() from SyncController
- Use CSRF token in JS fetch headers

ADMIN LAYOUT REQUIREMENTS:
- Same navy sidebar as student layout
- Nav links: Dashboard, Scholarships, Sync Now, Sync Logs
- Role label: "Administrator"
- @extends('layouts.admin') for all admin pages

SYNC NOW REQUIREMENTS:
- JS fetch() POST to /admin/sync
- Button shows spinner + "Syncing..." while loading
- HTTP GET to: mock-api:8080/api/ched, /api/dost, /api/lgu
- Upsert via updateOrCreate(['source_url' => $url], [...])
- Match new scholarships against student profiles
- Dispatch ScholarshipAlert emails to eligible students
- Log to sync_logs table
- Return JSON: { success, records_synced, sources: [...], timestamp }
- UI shows results without page reload

AFTER PHASE 4 → PHASE 5:
- Docker polish, README.md, DEMO_SCRIPT.md, SDG_TECHNICAL_BRIEF.md
- Architecture diagram
- End-to-end demo test
```