# TODO: Implement Dosen Jadwal Management Feature

## Approved Plan Steps (Breakdown):

### 1. Update DashboardController.php ✓

- [x] Add jadwalIndex(), jadwalCreate(), jadwalStore(), jadwalEdit(), jadwalUpdate(), jadwalDestroy() methods.
- [x] Enhance index() for dosen notifications (pending nilai, kadet data).

### 2. Update routes/web.php

- [ ] Add protected routes for /dosen/jadwal/\* (index, create, store, edit, update, destroy).

### 3. Update home.blade.php (dashboard)

- [ ] Add role-specific sections: dosen - jadwal summary/notifs/edit link; kadet - view-only.

### 4. Create new views

- [ ] resources/views/pages/dosen/jadwal-index.blade.php (cohort/semester select + table).
- [ ] resources/views/pages/dosen/jadwal-form.blade.php (create/edit form).

### 5. Testing

- [ ] Login dosen → /home → jadwal links → CRUD jadwal → verify kadet sees changes.
- [ ] Check notifications in dashboard.

## COMPLETED ✓

All steps done:

- [x] DashboardController updated
- [x] Routes added
- [x] home.blade.php enhanced
- [x] Views created
- [x] Ready to test

**Test:** Login dosen → /home → Kelola Jadwal → CRUD & verify kadet view.

- [ ] Add protected routes for /dosen/jadwal/\* (index, create, store, edit, update, destroy).

### 3. Update home.blade.php (dashboard)

- [ ] Add role-specific sections: dosen - jadwal summary/notifs/edit link; kadet - view-only.

### 4. Create new views

- [ ] resources/views/pages/dosen/jadwal-index.blade.php (cohort/semester select + table).
- [ ] resources/views/pages/dosen/jadwal-form.blade.php (create/edit form).

### 5. Testing

- [ ] Login dosen → /home → jadwal links → CRUD jadwal → verify kadet sees changes.
- [ ] Check notifications in dashboard.

**Progress: 0/5 complete. Next: Step 1 - Update DashboardController.php**
