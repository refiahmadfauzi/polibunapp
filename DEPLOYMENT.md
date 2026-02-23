# Panduan Deploy Polibunapp (Gratis)

Aplikasi ini siap di-deploy secara gratis menggunakan **Render.com**. PostgreSQL gratis (90 hari pertama untuk database free tier) dan web service gratis termasuk dalam tier free.

## Opsi 1: Render.com (Direkomendasikan)

### Langkah 1: Push ke GitHub
Pastikan kode sudah di-push ke repository GitHub:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/USERNAME/polibunapp.git
git push -u origin main
```

### Langkah 2: Deploy dengan Blueprint
1. Buka [Render Dashboard](https://dashboard.render.com/)
2. Klik **New** → **Blueprint**
3. Connect repository GitHub Anda
4. Render akan mendeteksi `render.yaml` dan membuat:
   - Web Service (aplikasi Laravel)
   - PostgreSQL database
5. **PENTING**: Tambahkan `APP_KEY` di Environment Variables:
   - Generate key: `php artisan key:generate --show`
   - Copy output (format: `base64:xxxxx...`)
   - Di Render Dashboard → polibunapp → Environment → Add Variable:
     - Key: `APP_KEY`
     - Value: (paste key yang di-copy)
6. Klik **Apply** untuk deploy

### Langkah 3: Jalankan Seeder
**PENTING** - Jalankan seeder untuk membuat user admin pertama:
```bash
# Via Render Shell (Dashboard → polibunapp → Shell)
php artisan db:seed --force
```

### Akses Aplikasi
- **Homepage**: `https://polibunapp.onrender.com`
- **Admin Panel (Filament)**: `https://polibunapp.onrender.com/admin`
- **Login default**: `admin@polibun.app` / `password`

### Catatan Render Free Tier
- **Web Service**: Spin down setelah 15 menit tidak aktif, bangun ~30 detik saat akses pertama
- **PostgreSQL**: Free database (90 hari, lalu perlu upgrade atau migrate)
- **Instance Hours**: 750 jam/bulan gratis
- **Region**: Singapore tersedia untuk latency lebih baik dari Indonesia

---

## Opsi 2: Railway

1. Buka [Railway.app](https://railway.app/)
2. **New Project** → **Deploy from GitHub repo**
3. Pilih repository polibunapp
4. Railway akan auto-detect Dockerfile
5. Add PostgreSQL: **+ New** → **Database** → **PostgreSQL**
6. Set environment variables:
   - `DATABASE_URL` (otomatis dari PostgreSQL)
   - `APP_KEY` (generate dengan `php artisan key:generate --show`)
   - `APP_ENV` = production
   - `APP_DEBUG` = false
7. Generate domain: **Settings** → **Networking** → **Generate Domain**

**Note**: Railway memberikan $5 kredit gratis/bulan. Setelah habis, perlu upgrade.

---

## Opsi 3: Fly.io

1. Install [Fly CLI](https://fly.io/docs/hands-on/install-flyctl/)
2. Login: `fly auth login`
3. Di folder project:
```bash
fly launch --no-deploy
```
4. Tambahkan PostgreSQL: `fly postgres create`
5. Set secrets:
```bash
fly secrets set APP_KEY=$(php artisan key:generate --show)
fly secrets set DATABASE_URL="postgres://..."
```
6. Deploy: `fly deploy`

---

## Variabel Environment yang Dibutuhkan

| Variable | Wajib | Keterangan |
|----------|-------|------------|
| APP_KEY | ✅ | `php artisan key:generate --show` |
| APP_ENV | ✅ | `production` |
| APP_DEBUG | ✅ | `false` |
| APP_URL | - | Auto dari RENDER_EXTERNAL_URL (Render) |
| DATABASE_URL | ✅ | Connection string PostgreSQL |
| DB_CONNECTION | ✅ | `pgsql` |

---

## Troubleshooting

### Error: "No application encryption key"
- Pastikan `APP_KEY` sudah di-set di Environment Variables
- Format harus: `base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=`

### Error: "could not connect to server"
- Pastikan DATABASE_URL benar
- Di Render: gunakan **Internal Database URL** (bukan External) untuk koneksi antar service

### 502 Bad Gateway
- Cek logs di Dashboard
- Pastikan port 10000 di-expose (sudah diatur di Dockerfile)
- Storage permissions: `chmod -R 775 storage bootstrap/cache`

### Assets (CSS/JS) tidak load
- Pastikan `npm run build` berjalan saat build (sudah di Dockerfile)
- Cek `ASSET_URL` jika perlu: set ke `https://your-app.onrender.com`
