# Role-Based Database Revamp TODO

## Overview

Revamp to new identifiers/passwords: kaprodi(\"kaprodi\"/\"kaprodi\"), admin(\"superman\"/\"orangkuat\"), staff_prodi(\"staff_prodi\"/\"staffprodi\"), sesprodi(\"sesprodi\"/\"sesprodi\"). Kadet unchanged. Each identifier enables specific role functions/UI.

## Steps (Progress: 3/10)

### 1. [✅] Migration for 'staff_prodi' role enum

### 2. [✅] DatabaseSeeder.php (new users/identifiers)

### 3. [✅] PengumumanSeeder.php (superman check)

### 4. [✅] DashboardController.php (allowed_roles + normalization + methods)

### 5. [ ] Update routes/web.php

### 2. [ ] Update DatabaseSeeder.php

### 3. [ ] Update PengumumanSeeder.php

### 4. [ ] Update DashboardController.php

### 5. [ ] Update routes/web.php

### 6. [ ] Update home.blade.php

### 7. [ ] Update app.blade.php

### 8. [ ] Create new views for staff_prodi/sesprodi

### 9. [ ] php artisan migrate --seed (or migrate:fresh --seed to reset)

### 10. [ ] Test logins

**Completed: None**
