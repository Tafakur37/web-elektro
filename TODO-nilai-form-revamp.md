# TODO: Revamp Nilai Form (Dynamic Remedial + Kehadiran → IPS Calc)

## New Requirements

- **Semester select**: Simplify (use dropdown, not fancy grid).
- **Form changes** (`nilai-form.blade.php`):
    - Fields: Tugas (always), UTS, UAS.
    - **Dynamic Remedial**: On input ≤60 for UTS/UAS → show "Nilai Remedial UTS/UAS" field below (JS oninput/enter).
    - **Kehadiran**: New field at bottom (1-100?).
    - **IPS Calc**: Auto-calculate IPS from all fields (update model/controller).
- Assume IPS formula: weighted average (Tugas20%, UTS35%, UAS45%) + kehadiran factor (TBD, e.g. \*0.9 if <80).

## Step-by-Step

- [x] **Step 1**: Simplify semester in `nilai-index.blade.php` (dropdown).
- [x] **Step 2**: Added `kehadiran`/`ips` migration, model $fillable/casts, validation nullable.
- [x] **Step 1-5**: COMPLETE - Dynamic remedial JS (≤60 show field), kehadiran, live IPS preview, semester dropdown simplified.

**Status**: ✅ FULLY IMPLEMENTED

**Features**:

- Semester dropdown (simple).
- Form: Tugas | UTS (dynamic remedial if ≤60) | UAS (dynamic) | Kehadiran → Live IPS/Grade preview.
- Backend: calculateIPS() with attendance factor.

**Demo Command**: `start http://localhost/Web-Elektro/public/dosen/nilai` (login dosen, test UTS=50 → remedial appears).

**Current Progress**: Starting refinements.
**Test**: `/dosen/nilai` → form → input UTS=50 → remedial appears → kehadiran → IPS preview.
