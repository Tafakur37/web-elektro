# TODO: Pengajuan CRUD for Kadet (Pesiar/IB/LWE)

Status: In Progress

## Steps:

### 1. ✅ Database Setup

- ✅ Create migration `database/migrations/2024_11_02_000000_create_pengajuan_table.php`
- ✅ Create model `app/Models/Pengajuan.php`
- [ ] Run `php artisan migrate`

### 2. ✅ Controller & Logic

- ✅ Create `app/Http/Controllers/PengajuanController.php` (w/ file upload)
- [ ]

### 3. ✅ Kadet Views

- [ ] Edit `resources/views/pages/surat.blade.php` (list + create form)

### 4. ✅ Staff Prodi Views

- ✅ Create `resources/views/pages/staff_prodi/pengajuan.blade.php` (list + approve/reject)

### 5. ✅ Routes & Integration

- ✅ Edit `routes/web.php` (pengajuan resource + surat-berkas repoint)
- ✅ Edit `resources/views/pages/staff_prodi/index.blade.php` (stats + pengajuan card)
- ✅ Edit `resources/views/app.blade.php` (staff_prodi sidebar)

### 6. ✅ Setup & Test

- [ ] `php artisan storage:link`
- [ ] Test: Kadet submit → Staff approve
- [ ] Update TODO progress

Next: Migration + Model
