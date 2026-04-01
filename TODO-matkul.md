# Matkul Database Revamp TODO

## Overview

Rombak matkul: add semester (1-8 required), sks, optional kode_matkul/deskripsi. Auto-show semester in UI (no select semester). CRUD for admin/dosen self-edit DB.

## Steps (Progress: 0/8)

### 1. [✅] New migration 2024_10_01_000002_add_semester_fields_to_matkuls_table.php

- Added semester, kode_matkul, sks nullable

### 2. [✅] app/Models/Matkul.php ($fillable + semester/kode_matkul)

### 3. [✅] database/seeders/MatkulSeeder.php created (12 examples), added to DatabaseSeeder

### 4. [✅] DashboardController.php nilaiIndex (matkul by semester fallback)

### 5. [ ] Update resources/views/pages/dosen/nilai-index.blade.php

- Remove semester step or optional; matkul cards show semester/SKS auto.

### 6. [ ] Add CRUD for matkul

- Controller methods: matkulIndex/create/store/edit/update/destroy
- Views: pages/admin/matkul-index.blade.php, matkul-form.blade.php

### 7. [ ] Add routes in web.php

- Route::prefix('admin/matkul')... (admin/staff_prodi/sesprodi)

### 8. [✅] Migrate/seeded success
