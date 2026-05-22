<?php

use Illuminate\Support\Facades\Schedule;

// Jalankan perintah 'orders:auto-cancel' setiap 1 jam sekali
Schedule::command('orders:auto-cancel')->hourly();

// Opsi lain (bisa dipilih salah satu):
Schedule::command('orders:auto-cancel')->everyTwoHours(); // Setiap 2 jam
// Schedule::command('orders:auto-cancel')->daily(); // Setiap hari
