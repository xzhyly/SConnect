# ScholarConnect — Master Build Prompt & Session Strategy
> IT 111 Final Project | BSIT 2A | Camarines Norte State College
> Stack: Laravel 11 · PHP 8.x · MySQL · PDO · Docker · PHP Mock API Server

---

## HOW TO USE THIS DOCUMENT

This file is your **session handoff system**. Every time you open a new Claude Code session:

1. Paste **Section 0 (Context Block)** first — always, every session
2. Check **Section 4 (Progress Tracker)** — find your current phase
3. Paste the **Phase Prompt** for that phase
4. When the phase is done or context is near limit, update the tracker and save

---

## SECTION 0 — CONTEXT BLOCK (Paste This Every New Session)

```
You are a senior Laravel developer helping build ScholarConnect — a PHP 8.x Laravel 11 web application 
for Camarines Norte State College's IT 111 final project.

PROJECT: Camarines Norte ScholarConnect
PURPOSE: Localized Smart Scholarship Aggregator & Alert System aligned with SDG 4 (Quality Education)
COURSE: IT 111 – Integrative Programming and Technologies

TECH STACK (non-negotiable, per rubrics):
- Backend: PHP 8.x + Laravel 11, strict MVC pattern
- Database: MySQL, ALL queries via PDO (use Laravel Eloquent which wraps PDO — never raw mysqli)
- Data exchange: JSON for ALL internal and external API communication
- Mock APIs: PHP built-in server serving JSON (simulates CHED, DOST-SEI, LGU endpoints)
- Containerization: Docker + docker-compose.yml (one-click setup required for grading)
- Frontend: Bootstrap 5, vanilla JS ES6+, no npm build step (keep it simple)
- Notifications: Laravel Mail via SMTP (Mailtrap for dev/demo)
- Version control: Git (commit often, every member must have commits)

DESIGN SYSTEM (match the existing PPTX design exactly):
- Primary background: #1B2A47 (dark navy)
- Secondary background: #0F1C33 (darker navy for cards/panels)
- Accent/highlight: #F5A623 (amber/orange — used for headings, badges, CTAs)
- Text on dark: #FFFFFF (primary), #B0BEC5 (muted)
- Text on light: #1B2A47 (dark navy)
- Light background panels: #FFFFFF or #F4F6F9
- Border/divider: 2px solid #F5A623 (amber) for section highlights
- Font: Inter or system-ui for body, bold weight for headings
- Buttons: bg #F5A623, text #1B2A47, hover darken 10%
- Nav: bg #0F1C33, text white, active item amber underline

DEMO SCENARIO (what must work live for full marks):
Step 1 — Admin logs in → clicks "Sync Now" → system makes HTTP GET to 3 PHP mock API servers
Step 2 — Middleware normalizes JSON response → upserts into MySQL via PDO/Eloquent
Step 3 — System matches new scholarships against registered student profiles
Step 4 — Email notification dispatched to eligible students (visible in Mailtrap)
Step 5 — Student logs in → sees personalized scholarship list → bookmarks one
Step 6 — Admin dashboard shows updated KPIs (total scholarships, active users, sync log)

ROLES:
- Minguez (Lead Architect): Middleware, API contracts, ScholarConnectMiddleware.php
- Villafranca (Backend Dev): Database schema, Eloquent models, business logic
- Lagrosa (Frontend Dev): Student-facing UI, Bootstrap layouts, client-side validation
- Abiera (Frontend Dev): Admin dashboard UI, charts, notification management UI

OS: Windows (no WSL). All commands must use Windows-compatible syntax.
Docker Desktop for Windows is the containerization tool.

CURRENT PHASE: [UPDATE THIS BEFORE PASTING — see Section 4]

PROJECT ROOT: scholarconnect/
```

---

## SECTION 1 — COMPLETE FILE STRUCTURE

```
scholarconnect/
├── docker-compose.yml                  # One-click setup (graded)
├── Dockerfile                          # PHP 8.x + Laravel app container
├── .env.example                        # Environment template
├── README.md                           # Setup instructions
│
├── mock-api/                           # PHP Mock API Server (simulates CHED, DOST, LGU)
│   ├── server.php                      # Router — handles all 3 API endpoints
│   ├── data/
│   │   ├── ched_scholarships.json      # Mock CHED data
│   │   ├── dost_scholarships.json      # Mock DOST-SEI data
│   │   └── lgu_scholarships.json       # Mock LGU (12 municipalities) data
│   └── Dockerfile                      # PHP built-in server container
│
└── app/                                # Laravel 11 application
    ├── Http/
    │   ├── Controllers/
    │   │   ├── Auth/
    │   │   │   ├── StudentAuthController.php
    │   │   │   └── AdminAuthController.php
    │   │   ├── Student/
    │   │   │   ├── DashboardController.php
    │   │   │   ├── ScholarshipController.php
    │   │   │   └── BookmarkController.php
    │   │   └── Admin/
    │   │       ├── DashboardController.php
    │   │       ├── ScholarshipController.php
    │   │       ├── SyncController.php
    │   │       └── UserController.php
    │   └── Middleware/
    │       ├── AdminMiddleware.php
    │       └── StudentMiddleware.php
    ├── Models/
    │   ├── User.php                    # Students
    │   ├── Scholarship.php
    │   ├── Bookmark.php
    │   ├── Notification.php
    │   └── SyncLog.php
    ├── Services/
    │   ├── ScholarConnectMiddleware.php # Core integration logic (Minguez's code)
    │   └── NotificationService.php
    ├── Jobs/
    │   └── SyncScholarshipsJob.php     # Queued sync job
    ├── Mail/
    │   └── ScholarshipAlert.php
    └── Console/
        └── Commands/
            └── SyncScholarships.php    # Artisan command for scheduled sync
```

---

## SECTION 2 — DATABASE SCHEMA

```sql
-- Run via Laravel migrations (php artisan migrate)

-- users (students)
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    municipality VARCHAR(100),          -- one of 12 CNSC municipalities
    course VARCHAR(100),                -- e.g. BSIT, BSCS, BSED
    gwa DECIMAL(4,2),                   -- e.g. 1.50
    year_level TINYINT,
    is_admin BOOLEAN DEFAULT FALSE,
    email_notifications BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- scholarships
CREATE TABLE scholarships (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    provider VARCHAR(100) NOT NULL,     -- ched | dost_sei | lgu
    description TEXT,
    deadline DATE,
    minimum_gwa DECIMAL(4,2),
    required_course VARCHAR(255),       -- null = all courses
    municipality VARCHAR(100),          -- null = province-wide
    benefits TEXT,
    application_link VARCHAR(500),
    source_url VARCHAR(500) UNIQUE,     -- upsert key
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- bookmarks
CREATE TABLE bookmarks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    scholarship_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (scholarship_id) REFERENCES scholarships(id) ON DELETE CASCADE,
    UNIQUE (user_id, scholarship_id)
);

-- sync_logs
CREATE TABLE sync_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    source VARCHAR(100),                -- ched | dost_sei | lgu
    status VARCHAR(50),                 -- success | failed
    records_synced INT DEFAULT 0,
    error_message TEXT NULL,
    synced_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- notifications
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    scholarship_id BIGINT UNSIGNED,
    type VARCHAR(50),                   -- new_match | deadline_reminder
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

## SECTION 3 — PHASE PROMPTS

> Copy-paste the exact prompt for your current phase. Always paste Section 0 first.

---

### PHASE 1 PROMPT — Project Scaffold + Docker + Mock API

```
PHASE: 1 — Scaffold, Docker, and Mock API Server

Task: Set up the complete Laravel 11 project foundation on Windows with Docker.

Steps to complete:
1. Create a new Laravel 11 project: `composer create-project laravel/laravel scholarconnect`
2. Create docker-compose.yml with 3 services:
   - app: PHP 8.2-fpm + Laravel, port 8000
   - db: MySQL 8.0, port 3306, volume for persistence
   - mock-api: PHP built-in server, port 8080, serves mock scholarship JSON
3. Create mock-api/server.php that:
   - Routes GET /api/ched → returns ched_scholarships.json
   - Routes GET /api/dost → returns dost_scholarships.json
   - Routes GET /api/lgu → returns lgu_scholarships.json
   - Sets Content-Type: application/json header on all responses
4. Create mock-api/data/ with 3 JSON files, each with 5-8 realistic scholarship records.
   Each record must have: name, end_date, gwa_req, course (or null), award, url, source, municipality
5. Create .env with DB_HOST=db, MOCK_API_URL=http://mock-api:8080
6. Run migrations for all 5 tables (users, scholarships, bookmarks, sync_logs, notifications)
7. Create DatabaseSeeder with:
   - 1 admin user (admin@scholarconnect.test / password)
   - 3 student users with different municipalities and GWAs
8. Verify: `docker-compose up -d` works, `docker-compose ps` shows all 3 services healthy

DESIGN NOTE: Do not build any UI in this phase. Focus on infrastructure only.

DELIVERABLE CHECK before ending session:
- [ ] docker-compose.yml exists and all 3 services start
- [ ] curl http://localhost:8080/api/ched returns valid JSON
- [ ] php artisan migrate:fresh --seed works without errors
- [ ] .env.example committed to git

Save PROGRESS.md with: "PHASE 1 COMPLETE — date. Next: Phase 2."
```

---

### PHASE 2 PROMPT — Core Middleware + Database Layer

```
PHASE: 2 — ScholarConnectMiddleware + Eloquent Models + Sync Logic

Context: Phase 1 is complete. Docker is running. Mock API at http://mock-api:8080 is live.

Task: Build the core PHP middleware that is the heart of this project (what the panel will examine).

Steps to complete:

1. Create app/Services/ScholarConnectMiddleware.php with:
   - fetchAndNormalize(string $source): array
     → HTTP GET to mock API using Laravel Http facade (backed by Guzzle)
     → Validates response status, logs failure to sync_logs if not 200
     → Maps raw JSON fields to standard schema:
       title, provider, deadline, minimum_gwa, required_course,
       municipality, benefits, application_link, source_url
     → Returns normalized array
   - syncAll(): void
     → Loops ['ched', 'dost_sei', 'lgu']
     → Calls fetchAndNormalize() for each
     → Upserts each record via Scholarship::updateOrCreate(['source_url' => ...], $data)
     → Writes to sync_logs (source, status, records_synced)
     → Calls NotificationService::dispatchAlerts() after sync

2. Create app/Services/NotificationService.php with:
   - dispatchAlerts(): void
     → Gets all scholarships created/updated in last 24 hours
     → For each scholarship, find users where:
       * user.gwa <= scholarship.minimum_gwa
       * user.course matches scholarship.required_course (or scholarship is open to all)
       * user.municipality matches scholarship.municipality (or scholarship is province-wide)
       * user has NOT already been notified (check notifications table)
     → For each eligible user: create notifications record + dispatch ScholarshipAlert mail

3. Create app/Mail/ScholarshipAlert.php — email template showing:
   - Scholarship title, provider, deadline, benefits
   - Link to application
   - Branding: ScholarConnect navy + amber colors

4. Create app/Console/Commands/SyncScholarships.php (Artisan command):
   - Signature: scholarships:sync
   - Calls ScholarConnectMiddleware->syncAll()

5. Create Eloquent models with proper relationships:
   - Scholarship.php: hasMany Bookmarks, hasMany Notifications
   - User.php: hasMany Bookmarks, hasMany Notifications
   - Bookmark.php: belongsTo User, belongsTo Scholarship
   - SyncLog.php (no relationships needed)

6. Create Admin\SyncController.php:
   - sync() method — calls syncAll(), returns JSON response with sync summary
   - logs() method — returns last 20 sync log entries as JSON

IMPORTANT PHP 8.x FEATURES TO USE (panel will look for these):
- Constructor property promotion in models/services
- Named arguments where appropriate
- Match expressions instead of switch in normalization logic
- Readonly properties for config values
- Null coalescing operators for optional JSON fields

DELIVERABLE CHECK:
- [ ] php artisan scholarships:sync runs and populates scholarships table
- [ ] sync_logs table has entries for all 3 sources
- [ ] Running sync twice does NOT create duplicates (upsert works)
- [ ] Email is queued (check Mailtrap or log driver)

Save PROGRESS.md: "PHASE 2 COMPLETE — date. Models + Middleware done. Next: Phase 3 Auth."
```

---

### PHASE 3 PROMPT — Authentication + Student Routes

```
PHASE: 3 — Auth System + Student Dashboard + Scholarship Browse

Context: Phase 2 complete. Middleware syncs data from mock API. Scholarships in DB.

Task: Build the student-facing side of the application with the design system.

DESIGN SYSTEM REMINDER:
Primary bg: #1B2A47 | Accent: #F5A623 | Dark panel: #0F1C33
Font: Inter (import from Google Fonts) | Body text on light: #1B2A47

Steps:

1. Set up Laravel Breeze (simple auth) for BOTH student and admin:
   - php artisan breeze:install blade
   - Customize registration to include: municipality (dropdown, 12 CNSC municipalities),
     course (BSIT/BSCS/BSED/BSBA/BEED), gwa (decimal input), year_level

2. Create student layout (resources/views/layouts/student.blade.php):
   - Top navbar: #0F1C33 bg, ScholarConnect logo (amber text), nav links in white
   - Active nav item has amber underline
   - Sidebar or top nav: Dashboard | Browse | Bookmarks | Notifications | Profile

3. Create Student\DashboardController + view (student/dashboard.blade.php):
   - Welcome banner: "Hello [name], here are your matched scholarships"
   - Stats row: [Total Available] [Matched for You] [Bookmarked] [Days to Nearest Deadline]
   - Card grid of top 6 matched scholarships (matching user's profile)
   - Each card: title, provider badge (amber), deadline, GWA requirement, "View Details" button

4. Create Student\ScholarshipController + views:
   - index: Browseable list with filters (provider, municipality, GWA, deadline sort)
   - show: Full scholarship detail page with "Bookmark" toggle button
   - Filter form submits via GET — persist filter state in URL params

5. Create Student\BookmarkController:
   - toggle(Scholarship $scholarship) — adds/removes bookmark, returns JSON {bookmarked: bool}
   - index — shows bookmarked scholarships grid

6. Create notification view (student/notifications.blade.php):
   - List of all notifications for this user
   - Mark all as read button

BLADE COMPONENT to create (reusable):
- resources/views/components/scholarship-card.blade.php
  Props: $scholarship, $bookmarked (bool)
  Shows: amber provider badge, title, deadline pill, GWA badge, bookmark button

DELIVERABLE CHECK:
- [ ] Student can register, log in, see dashboard
- [ ] Dashboard shows scholarships matched to student's profile
- [ ] Browse page filters work (URL params preserved)
- [ ] Bookmark toggle works via JS fetch() call (no page reload)
- [ ] Design matches navy + amber color scheme

Save PROGRESS.md: "PHASE 3 COMPLETE — date. Student UI done. Next: Phase 4 Admin."
```

---

### PHASE 4 PROMPT — Admin Dashboard + Sync UI

```
PHASE: 4 — Admin Dashboard + Sync Control + KPI Charts

Context: Phase 3 complete. Student side working. Now build the admin control panel.

Task: Admin dashboard with live sync trigger, KPI metrics, user management, scholarship CRUD.

Steps:

1. Admin layout (resources/views/layouts/admin.blade.php):
   - Full dark theme: bg #0F1C33, sidebar bg #1B2A47
   - Sidebar: ScholarConnect logo, nav items with amber active state
   - Nav items: Dashboard | Scholarships | Users | API Sync | Logs

2. Admin\DashboardController + view (admin/dashboard.blade.php):
   - KPI cards row (amber icon, white number, muted label on dark card):
     * Total Scholarships (active)
     * Registered Students
     * Notifications Sent (last 30 days)
     * Last Sync (time ago)
   - Bar chart: Scholarships by Provider (CHED / DOST-SEI / LGU)
     Use Chart.js CDN — data injected via @json blade directive
   - Recent sync log table (last 10 entries): source, status badge, records, time

3. Admin\SyncController (already created in Phase 2) + Sync UI:
   - View: admin/sync.blade.php
   - "Sync Now" button → JS fetch() POST to /admin/sync/run
   - Real-time progress: show spinner, then display JSON result (sources synced, records upserted)
   - Sync history table showing all sync_logs entries

4. Admin\ScholarshipController + CRUD views:
   - index: Data table with search, filter by provider/status, paginated
   - create/edit: Form with all scholarship fields
   - Toggle active/inactive without deleting

5. Admin\UserController:
   - index: Students list with their profile stats (matched scholarships count, bookmarks)
   - show: Individual student profile view

6. Protect all /admin/* routes with AdminMiddleware
   - Middleware checks: auth()->user()->is_admin === true
   - Redirect non-admins to /dashboard

DELIVERABLE CHECK:
- [ ] Admin can log in (admin@scholarconnect.test / password)
- [ ] "Sync Now" button triggers live API fetch and shows result
- [ ] KPI numbers are accurate (real DB counts)
- [ ] Chart.js bar chart renders scholarship distribution
- [ ] All /admin routes reject non-admin users

Save PROGRESS.md: "PHASE 4 COMPLETE — date. Admin UI done. Next: Phase 5 Docker + Polish."
```

---

### PHASE 5 PROMPT — Docker Finalization + Demo Polish + Required Deliverables

```
PHASE: 5 — Docker Polish + Required Deliverables + Demo Prep

Context: Phases 1-4 complete. Full app working. Now finalize for exhibit.

Task: Make docker-compose up truly one-click, create all required deliverables, polish demo flow.

Steps:

1. Finalize docker-compose.yml:
   - Services: app (Laravel), db (MySQL), mock-api (PHP server)
   - Add entrypoint script to app container that auto-runs:
     * composer install
     * php artisan key:generate (if not set)
     * php artisan migrate:fresh --seed
     * php artisan queue:work (background)
   - Add healthcheck to db service so app waits for MySQL
   - Port mappings: app→8000, db→3306, mock-api→8080
   - Volume: mysql-data for DB persistence

2. Create README.md with:
   - One-click setup: `docker-compose up -d`
   - Demo credentials: admin@scholarconnect.test / password + 3 student accounts
   - Demo steps (numbered, matches the live demo script)
   - Architecture diagram text description (for exhibit)
   - SDG 4 technical link explanation

3. Create DEMO_SCRIPT.md — exact script for the 15-minute presentation:
   00:00-05:00 — Pitch (who talks, what they say per slide)
   05:00-12:00 — Live demo steps (who clicks what, in what order)
   12:00-15:00 — Likely panel questions per role

4. Create SDG_TECHNICAL_BRIEF.md (2-page content):
   - How ScholarConnect technically implements SDG 4
   - Specific code references (which file, which method) that serve the goal
   - Measurable impact: how many students in Camarines Norte could benefit

5. Polish and bug fixes:
   - Test the full demo scenario end-to-end (see Section 0, DEMO SCENARIO)
   - Add loading states to Sync Now button
   - Ensure no Laravel errors in production mode (APP_DEBUG=false)
   - Add error handling if mock API is unreachable (graceful fallback in middleware)
   - Make sure all 4 team members have Git commits

6. Architecture Diagram (export-ready):
   - Create resources/views/architecture.blade.php
   - Visual SVG/HTML diagram showing:
     [CHED Mock API] → HTTP GET → [ScholarConnectMiddleware] → PDO/Eloquent → [MySQL]
     [DOST Mock API] → HTTP GET ↗                                              ↓
     [LGU Mock API]  → HTTP GET ↗                              [NotificationService] → SMTP → [Student Email]
                                                               [Student Dashboard] ← Bootstrap UI ← [Laravel Blade]
   - Print this as A3 for the poster

DELIVERABLE CHECK (these are graded separately):
- [ ] docker-compose up -d && docker-compose ps → all green
- [ ] README.md exists with clear setup steps
- [ ] SDG Technical Brief (2 pages) written
- [ ] Architecture diagram visual exists
- [ ] Full demo scenario runs without crash (practice 3 times)
- [ ] All team members have commits in git log

Save PROGRESS.md: "PHASE 5 COMPLETE — PROJECT DONE. Demo ready."
```

---

## SECTION 4 — PROGRESS TRACKER

Update this after every session. Copy the updated version into PROGRESS.md in your project root.

```
Last Updated: [DATE]
Current Phase: [1 / 2 / 3 / 4 / 5]
Last Completed Task: [describe]

PHASE STATUS:
[ ] Phase 1 — Scaffold + Docker + Mock API
[ ] Phase 2 — Middleware + Models + Sync Logic
[ ] Phase 3 — Student Auth + Dashboard + Browse
[ ] Phase 4 — Admin Dashboard + Sync UI
[ ] Phase 5 — Docker Polish + Deliverables

KNOWN ISSUES / BLOCKERS:
- (list any errors or incomplete items here)

NEXT SESSION STARTS WITH:
- Paste Section 0 (Context Block) with CURRENT PHASE updated to: [X]
- Then paste Phase [X] Prompt from Section 3
```

---

## SECTION 5 — QUICK REFERENCE: RUBRIC CHECKLIST

Use this as your final checklist before demo day.

### System Rubrics (50% of final grade)
- [ ] **Interoperability (20%)** — 3 distinct HTTP API calls to mock servers + Laravel app = 2+ disparate stacks ✓
- [ ] **SDG Mapping (10%)** — NotificationService.dispatchAlerts() directly serves SDG 4 (students get scholarship info) ✓
- [ ] **PHP 8.x + PDO (25%)** — Laravel Eloquent uses PDO under the hood; use PHP 8.x features (match, named args, constructor promotion) in middleware ✓
- [ ] **JSON & Data (25%)** — Mock API returns JSON, middleware processes JSON, SyncController returns JSON, all API responses JSON ✓
- [ ] **DevOps (20%)** — `docker-compose up -d` runs everything, show `docker-compose logs` during demo ✓

### Pitching Rubrics (50% of final grade)
- [ ] **Live Execution (40%)** — "Sync Now" → real HTTP call → DB update → email sent. NO hardcoded data ✓
- [ ] **Technical Depth (30%)** — Each member knows their code: Minguez=middleware, Villafranca=models/DB, Lagrosa/Abiera=UI
- [ ] **Communication (15%)** — Practice role-specific Q&A (see DEMO_SCRIPT.md)
- [ ] **Visuals & Pitch (15%)** — Slides show Architecture diagram + SDG link clearly ✓

### Ground Rules (Automatic Penalties)
- ⛔ NO mock/hardcoded data in demo — must be live HTTP fetch every time
- ✅ Terminal window with `docker-compose logs` must be visible
- ✅ Be ready to open VS Code and explain any line of code
- ✅ Professional attire / team shirt

---

## SECTION 6 — ROLE-BASED Q&A PREP

Study your own section. The panel will ask YOU specifically.

### Minguez — Lead Architect
- "Walk me through fetchAndNormalize(). Why did you use Http::get() instead of file_get_contents()?"
- "What happens when the CHED API is down? How does your middleware handle it?"
- "Why is source_url used as the upsert key? What problem does that solve?"
- "Explain the difference between your middleware and a simple cURL call."

### Villafranca — Backend Dev
- "Why is PDO better than mysqli for this project?"
- "Explain the updateOrCreate() method — what SQL does it generate?"
- "What does the sync_logs table contain and why is it important?"
- "If two sync jobs run at the same time, could there be duplicate records? How is that prevented?"

### Lagrosa — Frontend Dev
- "How does the scholarship filter work? Walk me through the GET request to the URL params to the DB query."
- "Why did you use fetch() instead of a form submit for the bookmark toggle?"
- "How does the scholarship card component get its data from the controller?"

### Abiera — Frontend Dev
- "How does Chart.js receive the data from Laravel? Walk me through @json."
- "What happens when the Sync Now button is clicked? Trace from button click to DB update."
- "How do you protect the admin routes from regular students?"

---

## SECTION 7 — DESIGN TOKENS (For UI Consistency)

Add this as a CSS block at the top of every view's stylesheet:

```css
:root {
  --navy-primary: #1B2A47;
  --navy-dark: #0F1C33;
  --amber: #F5A623;
  --amber-hover: #d48f1c;
  --text-light: #FFFFFF;
  --text-muted: #B0BEC5;
  --text-dark: #1B2A47;
  --bg-light: #F4F6F9;
  --border-amber: 2px solid #F5A623;
  --card-radius: 10px;
  --transition: all 0.2s ease;
}

/* Reusable classes */
.btn-amber { background: var(--amber); color: var(--navy-dark); font-weight: 600; border: none; }
.btn-amber:hover { background: var(--amber-hover); }
.badge-provider { background: var(--amber); color: var(--navy-dark); font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; }
.card-dark { background: var(--navy-dark); border-radius: var(--card-radius); color: var(--text-light); }
.card-light { background: #fff; border-radius: var(--card-radius); box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
.nav-dark { background: var(--navy-dark); }
.section-title { color: var(--amber); font-weight: 700; letter-spacing: 0.05em; }
```

---

*ScholarConnect Master Prompt — Generated for IT 111 Final Project*
*Use responsibly. Update PROGRESS.md after every session.*
