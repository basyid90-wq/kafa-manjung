# 🚀 Panduan Deploy KAFA Manjung ke VPS

## Semak sebelum mula
- [ ] VPS dah beli & status "Started" di GB Network
- [ ] Domain `ekafa.online` dah aktif di Hostinger
- [ ] GitHub repo `basyid90-wq/kafa-manjung` dah wujud

---

## FASA 1 — Push Kod ke GitHub (Jalankan di Windows Terminal/CMD)

Buka **Command Prompt** atau **Git Bash**, pergi ke folder projek:

```bash
cd C:\laragon\www\kafa-manjung
git init
git add .
git commit -m "Initial commit - KAFA Manjung Laravel App"
git branch -M main
git remote add origin https://github.com/basyid90-wq/kafa-manjung.git
git push -u origin main
```

> Kalau tanya username/password GitHub: guna Personal Access Token (bukan password biasa).
> Cipta token di: https://github.com/settings/tokens → Generate new token (classic) → centang `repo`

---

## FASA 2 — IP VPS (Dah Confirm ✅)

**IP VPS:** `103.175.50.99`
**Nama:** ocw-bot-60556018 (OpenClaw Claw Mini - GB Network)

---

## FASA 3 — Tukar DNS Domain (Hostinger)

1. Login ke https://hpanel.hostinger.com
2. Klik **Domains** → `ekafa.online` → **Manage DNS**
3. Edit rekod **A** yang ada (atau tambah baru):
   - Type: `A`
   - Name: `@`
   - Value: `103.175.50.99`
   - TTL: `3600`
4. Tambah satu lagi untuk `www`:
   - Type: `A`
   - Name: `www`
   - Value: `103.175.50.99`
   - TTL: `3600`

> DNS propagation ambil masa 5–30 minit. Boleh check di https://dnschecker.org

---

## FASA 4 — Setup VPS (SSH masuk dulu)

### 4A. SSH ke VPS
```bash
# Dari Windows terminal / Git Bash
ssh root@103.175.50.99
```

### 4B. Upload & jalankan setup script
```bash
# Di dalam VPS (selepas SSH masuk):
curl -O https://raw.githubusercontent.com/basyid90-wq/kafa-manjung/main/setup-vps.sh
bash setup-vps.sh
```

Script ini akan auto-install:
- PHP 8.2 + semua extensions
- Nginx web server
- MySQL database
- Composer
- Node.js 20
- Certbot (SSL)
- Clone repo & build assets

---

## FASA 5 — Upload .env & Migrate Database

### 5A. Upload fail .env.production ke VPS
```bash
# Dari Windows terminal (bukan dalam VPS):
scp C:\laragon\www\kafa-manjung\.env.production root@103.175.50.99:/var/www/kafa-manjung/.env
```

### 5B. Generate APP_KEY & migrate
```bash
# Dalam VPS:
cd /var/www/kafa-manjung
php artisan key:generate
php artisan migrate:fresh --seed
```

> `migrate:fresh --seed` akan buat semula semua table dan masukkan data dummy untuk pembentangan.

---

## FASA 6 — Setup SSL (HTTPS)

```bash
# Dalam VPS (pastikan DNS dah propagate dulu):
certbot --nginx -d ekafa.online -d www.ekafa.online
# Ikut arahan, masukkan email, pilih option 2 (redirect HTTP ke HTTPS)
```

---

## ✅ Semak Akhir

Buka browser → https://ekafa.online

Test login dengan:
- **Pentadbir:** (tengok UserSeeder.php untuk credentials)
- Semua fungsi utama berfungsi

---

## 🔧 Troubleshoot Biasa

| Masalah | Penyelesaian |
|---------|--------------|
| 500 error | `cat /var/www/kafa-manjung/storage/logs/laravel.log` |
| Permission error | `chown -R www-data:www-data /var/www/kafa-manjung/storage` |
| Nginx error | `nginx -t` kemudian `systemctl reload nginx` |
| Database error | Semak `.env` — pastikan DB_PASSWORD betul |

---

## 📌 Credentials DB yang dibuat oleh setup script

- **Database:** `kafa_manjung`
- **Username:** `root`
- **Password:** `KafaSecure@2025!`

> Tukar password ini selepas pembentangan selesai untuk keselamatan.
