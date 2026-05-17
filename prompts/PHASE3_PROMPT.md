# PHASE 3 — Student Auth + Dashboard + Browse
> ScholarConnect | IT 111 Final Project | BSIT 2A | Camarines Norte State College

---

## CONTEXT

Phase 1 (Scaffold + Docker + Mock API) and Phase 2 (Middleware + Models + Sync Logic) are COMPLETE and TESTED.

- Docker is running (3 services: app, db, mock-api)
- `php artisan scholarships:sync` works and populates scholarships table
- All Eloquent models exist: User, Scholarship, Bookmark, Notification, SyncLog
- All student controllers already exist (but are mostly empty — fill them in)
- routes/web.php exists but student routes are not yet set up

Your job in Phase 3: Build the entire student-facing side of the application.

---

## CRITICAL RULES — READ BEFORE DOING ANYTHING

1. **ONE FILE AT A TIME.** Build only one file per task. Do not proceed to the next file unless the user explicitly says "proceed" or "next."
2. **WAIT FOR COMMAND.** After completing each file, stop and wait. Do not auto-continue.
3. **UPDATE PHASE3_REPORT.md after EVERY file.** Append a new log entry — never overwrite existing entries. Include: what file was created, what other files were modified (if any), any notes or issues. Report file is at `prompts/PHASE3_REPORT.md`.
4. **LOG ALL SIDE EFFECTS.** If creating one file requires editing another (e.g., routes/web.php, a controller, a model), log that in the report too.
5. **FOLLOW THE BUILD ORDER** listed in Section 4. Do not skip steps.
6. **DESIGN REFERENCE.** All UI must match the design system and slides in `designs/student/`. Filenames: Slide6.PNG through Slide11.PNG. For pages with no slide reference (Login, Dashboard, Scholarship Detail), follow the design system tokens exactly.

---

## DESIGN SYSTEM TOKENS

Apply these consistently across ALL blade views. Add this CSS block to `resources/css/app.css` or inline per layout:

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

.btn-amber { background: var(--amber); color: var(--navy-dark); font-weight: 600; border: none; }
.btn-amber:hover { background: var(--amber-hover); }
.badge-provider { background: var(--amber); color: var(--navy-dark); font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; }
.card-dark { background: var(--navy-dark); border-radius: var(--card-radius); color: var(--text-light); }
.card-light { background: #fff; border-radius: var(--card-radius); box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
.nav-dark { background: var(--navy-dark); }
.section-title { color: var(--amber); font-weight: 700; letter-spacing: 0.05em; }
```

**Sidebar nav (all student pages):**
- Background: `#0F1C33` (dark navy)
- Logo: "ScholarConnect" in amber (`#F5A623`)
- Nav links (white text): Dashboard, Browse Scholarships, My Bookmarks, Notifications, Profile Settings
- Active nav item: amber background + dark text
- Icons: use Bootstrap Icons or simple text indicators

**Cards:**
- White background, border-radius 10px, subtle box-shadow
- Provider badge: colored pill (amber for CHED, different color for DOST, LGU)
- Deadline pill: small gray pill with days remaining
- GWA badge: small badge showing minimum GWA requirement
- "View Details" button: dark navy background, white text, full width

---

## DESIGN REFERENCE PER SCREEN

### Slide6.PNG — Landing Page (welcome.blade.php)
- Public page, not inside student layout
- White navbar: ScholarConnect logo left, Browse + About links center, Login + Register (amber button) right
- Hero section: dark navy background, large white heading, search bar + amber Search button
- Stats row: 3 cards — Total Scholarships, Municipalities Covered, Students Registered
- Below: Featured Scholarship Opportunities section

### Slide7.PNG — Registration (auth/register.blade.php)
- Split layout: left panel (dark navy, image, "Start Your Journey" text), right panel (white form)
- Form fields: Full Name, Email Address, Password, Confirm Password, Municipality (dropdown), Barangay (text input), Academic Program (dropdown), Academic Level (dropdown)
- Register button: full-width amber
- "Already have an account? Log in here" link below button
- No GWA field visible in design — add it as optional or hidden for now

### Slide8.PNG — Browse Scholarships (student/scholarships/index.blade.php)
- Left sidebar nav (dark navy, same across all student pages)
- Left filter panel (inside main content): Provider checkboxes (CHED, DOST, LGU, Private), Municipality dropdown, Academic Level dropdown, Course/Program dropdown, Minimum GWA dropdown, Clear All Filters button
- Top: search bar + Relevance sort dropdown
- Results: 2-column card grid, each card has title, provider badge, deadline pill, description, GWA required, Amount, View Details button, bookmark icon top-right

### Slide9.PNG — My Bookmarks (student/bookmarks/index.blade.php)
- Same sidebar nav, active: My Bookmarks
- Page title: "My Bookmarks"
- 3-column card grid of bookmarked scholarships
- Same card style as Browse page
- Each card: title, provider badge, deadline pill, description, GWA required, Amount, View Details button

### Slide10.PNG — Notifications (student/notifications.blade.php)
- Same sidebar nav, active: Notifications
- Page title: "Notifications" + unread count badge
- Filter tabs: All (5), Unread (2), Deadlines (2), New Scholarships (1)
- Notification rows: icon left, scholarship title bold, subtitle description, timestamp right, "New" badge for unread
- Different icon colors per type: deadline = red/orange, new scholarship = amber star, update = blue circle

### Slide11.PNG — Profile Settings (student/profile.blade.php)
- Same sidebar nav, active: Profile Settings
- Two sections:
  1. Personal Information: Full Name, Email Address, Municipality (dropdown), Barangay (text)
  2. Academic Information: Academic Program (dropdown), Academic Level (dropdown), Current GWA (number input)
- Save button per section or one global Save button (amber)

### NO SLIDE — Login Page (auth/login.blade.php)
- Mirror the Register page layout: split left (dark navy image panel) + right (white form)
- Left panel: same ScholarConnect branding, tagline
- Form fields: Email Address, Password, Remember Me checkbox
- Login button: full-width amber
- "Don't have an account? Register here" link

### NO SLIDE — Student Dashboard (student/dashboard.blade.php)
- Same sidebar nav, active: Dashboard
- Welcome banner: "Hello [name], here are scholarships matched for you" on dark navy background
- Stats row (4 cards): Total Available, Matched for You, Bookmarked, Days to Nearest Deadline
- Section title: "Matched Scholarships" in amber
- Card grid (2-3 columns): top 6 scholarships matched to student profile (GWA, course, municipality)
- Same card style as Browse page

### NO SLIDE — Scholarship Detail (student/scholarships/show.blade.php)
- Same sidebar nav
- Back button top-left: "← Back to Browse"
- Large card: provider badge, title (large), deadline pill, GWA requirement badge
- Details section: Description, Benefits/Amount, Required Course, Municipality, Application Link (external link button)
- Bookmark button top-right: toggles via JS fetch() — no page reload
- Button states: "Bookmark" (outline) ↔ "Bookmarked ✓" (amber filled)

---

## PRE-BUILD INSPECTION RULE (MANDATORY)

Before writing ANY code for a task, you MUST do the following:

### Step 1 — Scan the project tree
Run this command to get the full current file structure:
```
tree app resources routes database/migrations -F
```
Look for any files that could be related to the task. Do not assume — check.

### Step 2 — Read suggested files + any others you find

Each task has a suggested read list below. Treat these as a **minimum** — if you find other related files during your tree scan, read those too before coding.

| # | File to Build | Suggested Files to Read First |
|---|--------------|-------------------------------|
| 1 | `StudentMiddleware.php` | `app/Http/Middleware/AdminMiddleware.php`, `app/Http/Kernel.php` (if exists) |
| 2 | `routes/web.php` | current `routes/web.php`, `app/Http/Middleware/StudentMiddleware.php` (just built), `app/Http/Controllers/Auth/StudentAuthController.php` |
| 3 | `layouts/student.blade.php` | `resources/views/` (full scan), `resources/css/app.css`, `designs/student/Slide8.PNG` (sidebar reference) |
| 4 | `auth/login.blade.php` | `resources/views/layouts/` (all), `routes/web.php`, `app/Http/Controllers/Auth/StudentAuthController.php` |
| 5 | `auth/register.blade.php` | `auth/login.blade.php` (just built), `app/Http/Controllers/Auth/StudentAuthController.php`, `app/Models/User.php` |
| 6 | `StudentAuthController.php` | `app/Models/User.php`, `database/migrations/*_create_users_table.php`, `auth/register.blade.php` (just built) |
| 7 | `scholarship-card.blade.php` | `app/Models/Scholarship.php`, `app/Models/Bookmark.php`, `designs/student/Slide8.PNG`, `designs/student/Slide9.PNG` |
| 8 | `student/dashboard.blade.php` | `resources/views/layouts/student.blade.php`, `components/scholarship-card.blade.php` (just built), `app/Http/Controllers/Student/DashboardController.php` |
| 9 | `Student/DashboardController.php` | `app/Models/Scholarship.php`, `app/Models/User.php`, `app/Models/Bookmark.php`, `student/dashboard.blade.php` (just built) |
| 10 | `scholarships/index.blade.php` | `layouts/student.blade.php`, `components/scholarship-card.blade.php`, `app/Http/Controllers/Student/ScholarshipController.php`, `designs/student/Slide8.PNG` |
| 11 | `Student/ScholarshipController.php` | `app/Models/Scholarship.php`, `scholarships/index.blade.php` (just built), `routes/web.php` |
| 12 | `scholarships/show.blade.php` | `layouts/student.blade.php`, `app/Models/Scholarship.php`, `app/Models/Bookmark.php`, `Student/BookmarkController.php` |
| 13 | `bookmarks/index.blade.php` | `layouts/student.blade.php`, `components/scholarship-card.blade.php`, `app/Http/Controllers/Student/BookmarkController.php`, `designs/student/Slide9.PNG` |
| 14 | `Student/BookmarkController.php` | `app/Models/Bookmark.php`, `app/Models/Scholarship.php`, `routes/web.php`, `scholarships/show.blade.php` (just built) |
| 15 | `student/notifications.blade.php` | `layouts/student.blade.php`, `app/Models/Notification.php`, `app/Http/Controllers/Student/DashboardController.php`, `designs/student/Slide10.PNG` |
| 16 | `student/profile.blade.php` | `layouts/student.blade.php`, `app/Models/User.php`, `database/migrations/*_create_users_table.php`, `designs/student/Slide11.PNG` |
| 17 | `welcome.blade.php` | current `resources/views/welcome.blade.php`, `app/Models/Scholarship.php`, `routes/web.php`, `designs/student/Slide6.PNG` |

### Step 3 — Check the report
Read `prompts/PHASE3_REPORT.md` and look at the session logs. Previous AI sessions may have left notes about files they touched, patterns they used, or issues they encountered. Use that context.

### Step 4 — Then build
Only after Steps 1-3 are done, write the code.

---

## FILE BUILD ORDER

Follow this exact order. One file per session task. Wait for "proceed" or "next" before moving on.

| # | File | Type | Notes |
|---|------|------|-------|
| 1 | `app/Http/Middleware/StudentMiddleware.php` | NEW | Check auth + not admin |
| 2 | `routes/web.php` | UPDATE | Add all student + auth routes |
| 3 | `resources/views/layouts/student.blade.php` | NEW | Master layout, sidebar nav |
| 4 | `resources/views/auth/login.blade.php` | NEW | Split layout, no slide ref |
| 5 | `resources/views/auth/register.blade.php` | NEW | Slide7.PNG reference |
| 6 | `app/Http/Controllers/Auth/StudentAuthController.php` | UPDATE | Save extra registration fields |
| 7 | `resources/views/components/scholarship-card.blade.php` | NEW | Reusable card component |
| 8 | `resources/views/student/dashboard.blade.php` | NEW | No slide ref, matched scholarships |
| 9 | `app/Http/Controllers/Student/DashboardController.php` | UPDATE | Matching logic query |
| 10 | `resources/views/student/scholarships/index.blade.php` | NEW | Slide8.PNG reference |
| 11 | `app/Http/Controllers/Student/ScholarshipController.php` | UPDATE | Filter logic via GET params |
| 12 | `resources/views/student/scholarships/show.blade.php` | NEW | No slide ref, bookmark toggle |
| 13 | `resources/views/student/bookmarks/index.blade.php` | NEW | Slide9.PNG reference |
| 14 | `app/Http/Controllers/Student/BookmarkController.php` | UPDATE | toggle() returns JSON, index() |
| 15 | `resources/views/student/notifications.blade.php` | NEW | Slide10.PNG reference |
| 16 | `resources/views/student/profile.blade.php` | NEW | Slide11.PNG reference |
| 17 | `resources/views/welcome.blade.php` | UPDATE | Slide6.PNG reference |

---

## REPORT INSTRUCTIONS

After completing each file:

1. Open `prompts/PHASE3_REPORT.md`
2. **APPEND** a new log entry at the bottom — never delete or overwrite existing entries
3. Use this format:

```
---
✅ DONE — [filename]
Date: [current date/time]
Files Created: [list]
Files Modified: [list all side effects]
Notes: [any issues, decisions made, things next AI should know]
Next: [what file is next in the build order]
---
```

---

## DELIVERABLE CHECKLIST

Before declaring Phase 3 complete, verify:

- [ ] Student can register (with municipality, course, GWA, year_level fields)
- [ ] Student can log in
- [ ] Dashboard shows matched scholarships based on student profile
- [ ] Browse page filters work (URL params preserved on reload)
- [ ] Scholarship detail page shows full info
- [ ] Bookmark toggle works via JS fetch() — no page reload
- [ ] Bookmarks page shows saved scholarships
- [ ] Notifications page loads with list
- [ ] Profile settings page loads and saves
- [ ] All /student/* routes reject unauthenticated users (redirect to login)
- [ ] Design matches navy (#1B2A47) + amber (#F5A623) color scheme
- [ ] PHASE3_REPORT.md has a log entry for every file built

---

## HOW TO START

1. Read this entire file first
2. Read `prompts/PHASE3_REPORT.md` to check current progress
3. Find the first uncompleted file in the Build Order table above
4. Build that file only
5. Update `prompts/PHASE3_REPORT.md`
6. Stop and wait for user command