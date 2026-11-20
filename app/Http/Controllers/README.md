# Evencraft Controllers

Controller CRUD berbasis JSON untuk model hasil konsolidasi Evencraft.

## Controllers
- EventController
- EventSyllabusController
- SpeakerController
- AttendeeController
- EventRegistrationController
- EventSpeakerController
- TicketTierController
- TicketBenefitController
- TicketCategoryController (compatibility alias)
- PesertaController (compatibility alias)

## Instalasi
Salin folder `app/Http/Controllers` ke project Laravel. Pastikan model dan migration dari paket unified sebelumnya sudah dipasang.

Tambahkan route API berikut ke `routes/api.php`:

```php
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventSyllabusController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\EventSpeakerController;
use App\Http\Controllers\TicketTierController;
use App\Http\Controllers\TicketBenefitController;

Route::apiResource('events', EventController::class);
Route::apiResource('event-syllabuses', EventSyllabusController::class);
Route::apiResource('speakers', SpeakerController::class);
Route::apiResource('attendees', AttendeeController::class);
Route::apiResource('event-registrations', EventRegistrationController::class);
Route::apiResource('event-speakers', EventSpeakerController::class);
Route::apiResource('ticket-tiers', TicketTierController::class);
Route::apiResource('ticket-benefits', TicketBenefitController::class);
```

## Catatan
- Controller mengembalikan JSON dan menggunakan validasi Laravel.
- `Event` menggunakan SoftDeletes; endpoint DELETE mengarsipkan event melalui `deleted_at`.
- Autentikasi, authorization/policy, rate limiting, dan aturan akses per role belum ditambahkan karena belum ada spesifikasi otorisasi dalam model/dump yang diberikan.
- Pastikan route dilindungi middleware yang sesuai sebelum dipakai di produksi.
- Belum diuji terhadap aplikasi Laravel yang berjalan.
