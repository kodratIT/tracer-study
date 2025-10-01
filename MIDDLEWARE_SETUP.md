# Middleware Setup - Admin vs Alumni Access Control

## Overview
Sistem middleware telah dikonfigurasi untuk memisahkan akses antara Admin dan Alumni dengan dashboard yang berbeda dan proteksi akses yang ketat.

## Middleware yang Dibuat

### 1. `EnsureUserIsAdmin`
- **Path**: `app/Http/Middleware/EnsureUserIsAdmin.php`
- **Fungsi**: Memastikan hanya admin yang dapat akses area admin
- **Guard**: `web` (Admin)
- **Redirect**: Admin area yang mencoba akses alumni → Admin dashboard

### 2. `EnsureUserIsAlumni`
- **Path**: `app/Http/Middleware/EnsureUserIsAlumni.php`
- **Fungsi**: Memastikan hanya alumni yang dapat akses area alumni
- **Guard**: `alumni`
- **Redirect**: Alumni yang mencoba akses admin → Alumni dashboard

### 3. `RedirectIfNotAlumni`
- **Path**: `app/Http/Middleware/RedirectIfNotAlumni.php`
- **Fungsi**: Mencegah cross-access antar role
- **Behaviour**: Redirect otomatis berdasarkan guard yang aktif

### 4. `FilamentAdminAuth`
- **Path**: `app/Http/Middleware/FilamentAdminAuth.php`
- **Fungsi**: Proteksi khusus untuk Filament Admin Panel
- **Behaviour**: Force logout alumni session jika mencoba akses admin

## Routing Configuration

### Alumni Routes (`/alumni/*`)
```php
Route::prefix('alumni')->name('alumni.')->group(function () {
    // Guest routes
    Route::middleware(['guest:alumni', 'guest:web'])->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'showRegister']);
        Route::post('/register', [AuthController::class, 'register']);
    });

    // Protected alumni routes
    Route::middleware(['alumni'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard']);
        Route::get('/profile', [AuthController::class, 'showProfile']);
        // ... other alumni routes
    });
});
```

### Admin Routes (`/admin/*`)
- Menggunakan Filament Panel dengan custom middleware
- Protected oleh `FilamentAdminAuth` middleware
- Guard: `web` (Admin users)

## Guards Configuration

### Authentication Guards (`config/auth.php`)
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',  // Admin users
    ],
    'alumni' => [
        'driver' => 'session',
        'provider' => 'alumni',  // Alumni users
    ],
],
```

## Access Control Matrix

| User Type | Can Access Admin | Can Access Alumni | Redirect Behaviour |
|-----------|------------------|-------------------|-------------------|
| **Admin** | ✅ Yes | ❌ No | `admin/*` → Admin Dashboard |
| **Alumni** | ❌ No | ✅ Yes | `alumni/*` → Alumni Dashboard |
| **Guest** | ❌ No | ❌ No | Redirect to respective login |

## Dashboard URLs

- **Admin Dashboard**: `/admin` (Filament Panel)
- **Alumni Dashboard**: `/alumni/dashboard` (Custom Blade View)

## Security Features

1. **Session Isolation**: Each guard menggunakan session terpisah
2. **Cross-Guard Protection**: Middleware mencegah akses lintas role
3. **Force Logout**: Alumni session akan di-logout jika mencoba akses admin
4. **Automatic Redirects**: User diarahkan ke dashboard sesuai role
5. **Guest Protection**: Route login hanya bisa diakses oleh guest

## Error Handling

- **Indonesia Localization**: Error messages dalam bahasa Indonesia
- **Session Messages**: Success/error feedback dengan session flash
- **Graceful Redirects**: No error pages, hanya redirect dengan pesan

## Testing

✅ **Middleware Working**:
- Admin dashboard redirect tanpa auth: HTTP 302 ✓
- Alumni dashboard redirect tanpa auth: HTTP 302 ✓
- Cross-access protection: Active ✓
- Login pages accessible: HTTP 200 ✓

## Usage

1. **Admin Login**: Akses `/admin/login` (Filament)
2. **Alumni Login**: Akses `/alumni/login` (Custom)
3. **Automatic Routing**: Login berhasil → redirect ke dashboard masing-masing
4. **Security**: Cross-access dicegah dengan middleware
