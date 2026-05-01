# SYSTEM FLOW & MODULE MAP — KAFA Manjung

> Dokumen ini menerangkan aliran data sistem dan hubungan antara modul.
> **Wajib rujuk sebelum edit mana-mana modul** — supaya modul berkaitan tidak terabai.

---

## 🗺️ Peta Hierarki Data

```
Daerah (District)
└── Sekolah (School)
    ├── Pengguna (User) — Guru Besar, Guru KAFA, Penyelia
    └── Kelas KAFA (KafaClass)
        ├── Murid (Student)
        │   ├── Kehadiran (Attendance)
        │   ├── Peperiksaan → Keputusan (Exam → ExamResult)
        │   ├── Rekod Disiplin (DisciplinaryRecord)
        │   ├── Rekod Pencapaian (StudentAchievement)
        │   ├── Pemindahan Murid (StudentTransfer)
        │   └── Ibu Bapa (Parent) → akses ParentResult
        ├── RPH (RphRecord) → Kelulusan (RphApproval)
        ├── Jadual Waktu (Timetable → TimeSlot)
        └── Aktiviti (Activity)

Buku (Book)
└── Pesanan Buku (BookOrder) — oleh Pembekal/Sekolah

Kewangan (Financial) — rekod bayaran sekolah

Sijil (CertificateTemplate → CertificateBulk) — jana sijil murid

Pengumuman (Announcement) — papar kepada semua / role tertentu

Laporan (Report) — agregat data semua modul di atas
```

---

## 🔗 Hubungan Modul — Jadual Ketergantungan

> Bila edit modul di lajur **Modul**, semak juga modul di lajur **Modul Berkaitan**.

| # | Modul | Modul Berkaitan | Sebab Kaitan |
|---|-------|-----------------|--------------|
| 1 | **District** | School, User, Pentadbir | School milik District; User ada `district_id` |
| 2 | **School** | KafaClass, User, Student, Financial, BookOrder | Semua data terikat `school_id` |
| 3 | **User** | Role, School, District | User ada role + school/district |
| 4 | **KafaClass** | Student, Attendance, Timetable, RPH | Kelas adalah unit utama operasi |
| 5 | **Student** | KafaClass, Attendance, ExamResult, DisciplinaryRecord, Achievement, Transfer, Parent | Murid adalah entiti pusat sistem |
| 6 | **Attendance** | Student, KafaClass | Kehadiran ikat murid + kelas |
| 7 | **Exam** | ExamResult, Student, Subject | Peperiksaan jana keputusan per murid |
| 8 | **ExamResult** | Exam, Student, ParentResult, Report | Keputusan dipapar ke ibu bapa & laporan |
| 9 | **Subject** | Exam, Timetable, RPH | Subjek digunakan dalam peperiksaan, jadual & RPH |
| 10 | **RPH (Record)** | RphApproval, Subject, KafaClass, Guru | RPH perlu kelulusan Guru Besar |
| 11 | **RphApproval** | RphRecord, User (Guru Besar) | Kelulusan RPH oleh Guru Besar |
| 12 | **Timetable** | TimeSlot, Subject, KafaClass | Jadual waktu ikat subjek + kelas |
| 13 | **Book** | BookOrder | Buku boleh dipesan |
| 14 | **BookOrder** | Book, School, Pembekal | Pesanan buku oleh sekolah kepada pembekal |
| 15 | **Financial** | School | Rekod kewangan terikat sekolah |
| 16 | **Disciplinary** | Student, School | Rekod disiplin per murid |
| 17 | **Achievement** | Student, School | Pencapaian akademik/ko-k per murid |
| 18 | **StudentTransfer** | Student, School (asal & baru) | Pemindahan murid antara sekolah |
| 19 | **Certificate** | Student, CertificateTemplate | Jana sijil berdasarkan template |
| 20 | **Announcement** | User (semua role) | Pengumuman boleh ditarget role tertentu |
| 21 | **Report** | Student, Attendance, ExamResult, Financial | Laporan agregat pelbagai modul |
| 22 | **Parent (Ibu Bapa)** | Student, ExamResult | Ibu bapa lihat data anak sahaja |

---

## 🔄 Aliran Data Utama

### Aliran 1 — Pendaftaran Murid Baru
```
Admin/Guru Besar
  → Daftar Sekolah (jika baru)
  → Daftar Kelas KAFA
  → Daftar Murid (Student) → assign ke KafaClass
  → Daftar Ibu Bapa (Parent) → link ke Student
```
**Modul terlibat:** School → KafaClass → Student → Parent

---

### Aliran 2 — Rekod Kehadiran Harian
```
Guru KAFA
  → Buka modul Kehadiran
  → Pilih Kelas + Tarikh
  → Rekod hadir/tidak hadir per murid
  → Data tersimpan → boleh dijana dalam Laporan
```
**Modul terlibat:** KafaClass → Student → Attendance → Report

---

### Aliran 3 — Peperiksaan & Keputusan
```
Guru KAFA / Guru Besar
  → Cipta Peperiksaan (Exam) — pilih subjek + kelas
  → Masuk keputusan (ExamResult) per murid
  → Ibu Bapa boleh lihat keputusan (ParentResult)
  → Laporan boleh jana ringkasan keputusan
```
**Modul terlibat:** Subject → Exam → ExamResult → ParentResult → Report

---

### Aliran 4 — RPH & Kelulusan
```
Guru KAFA
  → Cipta RPH (RphRecord) — pilih subjek + kelas + tarikh
  → Hantar untuk kelulusan

Guru Besar
  → Semak RPH (RphApproval) → Lulus / Tolak
  → Guru terima notifikasi status
```
**Modul terlibat:** Subject → KafaClass → RphRecord → RphApproval → Notification

---

### Aliran 5 — Pesanan Buku
```
Pentadbir / Guru Besar
  → Semak katalog Buku (Book)
  → Buat Pesanan (BookOrder) — pilih buku + kuantiti

Pembekal
  → Semak senarai pesanan
  → Kemaskini status penghantaran
```
**Modul terlibat:** Book → BookOrder → (Pembekal role)

---

### Aliran 6 — Jana Sijil
```
Admin / Guru Besar
  → Pilih Template Sijil (CertificateTemplate)
  → Jana Sijil Pukal (CertificateBulk) → pilih murid
  → Sijil boleh dicetak / diverifikasi via QR kod (URL awam)
```
**Modul terlibat:** Student → CertificateTemplate → CertificateBulk → QR Verify (Public)

---

## ⚠️ Zon Bahaya — Modul Tinggi Risiko Kesan Berantai

Bila edit modul ini, **WAJIB semak semua modul berkaitan** kerana perubahan boleh pecahkan data lain:

| Modul | Risiko | Tindakan Wajib |
|---|---|---|
| **Student** | ExamResult, Attendance, Certificate akan orphan jika delete | Guna soft delete, semak cascade |
| **KafaClass** | Student assignment akan hilang jika kelas dipadam | Semak ada murid sebelum delete |
| **Subject** | Exam & Timetable & RPH bergantung pada Subject | Jangan delete Subject yang masih digunakan |
| **School** | Semua data (murid, guru, kelas) terikat school_id | Jangan bagi tukar school_id sesuka hati |
| **ExamResult** | ParentResult & Report bergantung padanya | Perubahan struktur perlu semak kedua-dua |
| **User** | Padam user boleh orphan RPH, Attendance record | Pertimbang deactivate bukan delete |
