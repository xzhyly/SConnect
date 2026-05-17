Here's your full Phase 4 checklist with file references:

---

## Phase 4 Master Checklist — Per File

### 4A — Admin Layout Foundation

| File | Action | UI Reference |
|---|---|---|
| `layouts/admin.blade.php` | CREATE | Copy structure from `layouts/student.blade.php` — change nav links to: Dashboard, Scholarships, Sync Now, Sync Logs. Change role label to "Administrator" |

---

### 4B — Admin Dashboard

| File | Action | UI Reference |
|---|---|---|
| `Admin/DashboardController.php` | UPDATE | — |
| `admin/dashboard.blade.php` | CREATE | KPI cards → same card style as `student/dashboard.blade.php`. Chart.js bar chart → new. Sync logs table → same table style as `student/notifications.blade.php` |

---

### 4C — Sync Now

| File | Action | UI Reference |
|---|---|---|
| `Admin/SyncController.php` | UPDATE | — |
| `admin/sync.blade.php` | CREATE | Sync Now button → same amber button style across all pages. Spinner → Bootstrap spinner. Results table → same table style as `student/notifications.blade.php` |

---

### 4D — Scholarship Management

| File | Action | UI Reference |
|---|---|---|
| `Admin/ScholarshipController.php` | UPDATE | — |
| `admin/scholarships/index.blade.php` | CREATE | Table base → same as `student/scholarships/index.blade.php`. Provider pills/badges → same as `components/scholarship-card.blade.php`. Add activate/deactivate toggle button per row |

---

### 4E — Sync Logs

| File | Action | UI Reference |
|---|---|---|
| `admin/sync-logs.blade.php` | CREATE | Same table + badge style as `student/notifications.blade.php`. Status badges → green "Success", red "Failed" (same color logic as notification icons) |

---

### 4F — Routes & Middleware

| File | Action | Notes |
|---|---|---|
| `routes/web.php` | UPDATE | Add all `/admin/*` routes under admin middleware group |
| Admin middleware | VERIFY | Must protect all admin routes — redirect non-admins |

---

## UI Reference Summary

```
layouts/student.blade.php
  └── base for layouts/admin.blade.php

student/dashboard.blade.php
  └── KPI card style → admin/dashboard.blade.php

student/notifications.blade.php
  └── table + badge style → admin/dashboard.blade.php (sync logs section)
                          → admin/sync.blade.php (results table)
                          → admin/sync-logs.blade.php

student/scholarships/index.blade.php
  └── table/filter structure → admin/scholarships/index.blade.php

components/scholarship-card.blade.php
  └── provider pills + badge colors → admin/scholarships/index.blade.php
```

---

## Build Order (Strict)

```
1. layouts/admin.blade.php          ← lahat ng admin pages need this
2. Admin/DashboardController.php    ← data muna bago UI
3. admin/dashboard.blade.php        ← first visible admin page
4. Admin/SyncController.php         ← logic muna bago Sync UI
5. admin/sync.blade.php             ← most critical feature
6. Admin/ScholarshipController.php
7. admin/scholarships/index.blade.php
8. admin/sync-logs.blade.php
9. routes/web.php                   ← wire everything
10. End-to-end demo test
```

---

Handa ka na bang magsimula sa **4A — `layouts/admin.blade.php`**? I-paste mo lang ang `layouts/student.blade.php` para magamit natin as base.