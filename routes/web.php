
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventSyllabusController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\EventSpeakerController;
use App\Http\Controllers\TicketTierController;
use App\Http\Controllers\TicketBenefitController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\PesertaController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Routes yang hanya dapat diakses oleh pengguna yang belum login.
|
*/

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
| Semua route di bawah ini hanya dapat diakses oleh pengguna
| yang sudah berhasil login.
|
*/

Route::middleware('auth')->group(function () {

    // Redirect halaman utama
    Route::get('/', fn () => redirect()->route('events.index'));

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Admin & Staff Routes
    |--------------------------------------------------------------------------
    |
    | Admin dan Staff dapat melakukan:
    | - Index
    | - Create
    | - Store
    | - Edit
    | - Update
    |
    | Tidak termasuk Show dan Destroy.
    |
    */

    Route::middleware('role:Admin,Staff')->group(function () {

        // Events
        Route::resource('events', EventController::class)
            ->except(['show', 'destroy']);

        // Event Syllabuses
        Route::resource('event-syllabuses', EventSyllabusController::class)
            ->except(['show', 'destroy'])
            ->parameters([
                'event-syllabuses' => 'eventSyllabus'
            ]);

        // Speakers
        Route::resource('speakers', SpeakerController::class)
            ->except(['show', 'destroy']);

        // Attendees
        Route::resource('attendees', AttendeeController::class)
            ->except(['show', 'destroy']);

        // Event Registrations
        Route::resource('event-registrations', EventRegistrationController::class)
            ->except(['show', 'destroy'])
            ->parameters([
                'event-registrations' => 'eventRegistration'
            ]);

        // Event Speakers
        Route::resource('event-speakers', EventSpeakerController::class)
            ->except(['show', 'destroy'])
            ->parameters([
                'event-speakers' => 'eventSpeaker'
            ]);

        // Ticket Tiers
        Route::resource('ticket-tiers', TicketTierController::class)
            ->except(['show', 'destroy'])
            ->parameters([
                'ticket-tiers' => 'ticketTier'
            ]);

        // Ticket Benefits
        Route::resource('ticket-benefits', TicketBenefitController::class)
            ->except(['show', 'destroy'])
            ->parameters([
                'ticket-benefits' => 'ticketBenefit'
            ]);

        // Ticket Categories (Compatibility)
        Route::resource('ticket-categories', TicketCategoryController::class)
            ->except(['show', 'destroy'])
            ->parameters([
                'ticket-categories' => 'ticketCategory'
            ]);

        // Peserta (Compatibility)
        Route::resource('peserta', PesertaController::class)
            ->except(['show', 'destroy'])
            ->parameters([
                'peserta' => 'peserta'
            ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Admin Only Routes
    |--------------------------------------------------------------------------
    |
    | Hanya Admin yang dapat menghapus data.
    |
    */

    Route::middleware('role:Admin')->group(function () {

        // Events
        Route::delete('/events/{event}', [EventController::class, 'destroy'])
            ->name('events.destroy');

        // Event Syllabuses
        Route::delete('/event-syllabuses/{eventSyllabus}', [EventSyllabusController::class, 'destroy'])
            ->name('event-syllabuses.destroy');

        // Speakers
        Route::delete('/speakers/{speaker}', [SpeakerController::class, 'destroy'])
            ->name('speakers.destroy');

        // Attendees
        Route::delete('/attendees/{attendee}', [AttendeeController::class, 'destroy'])
            ->name('attendees.destroy');

        // Event Registrations
        Route::delete('/event-registrations/{eventRegistration}', [EventRegistrationController::class, 'destroy'])
            ->name('event-registrations.destroy');

        // Event Speakers
        Route::delete('/event-speakers/{eventSpeaker}', [EventSpeakerController::class, 'destroy'])
            ->name('event-speakers.destroy');

        // Ticket Tiers
        Route::delete('/ticket-tiers/{ticketTier}', [TicketTierController::class, 'destroy'])
            ->name('ticket-tiers.destroy');

        // Ticket Benefits
        Route::delete('/ticket-benefits/{ticketBenefit}', [TicketBenefitController::class, 'destroy'])
            ->name('ticket-benefits.destroy');

        // Ticket Categories
        Route::delete('/ticket-categories/{ticketCategory}', [TicketCategoryController::class, 'destroy'])
            ->name('ticket-categories.destroy');

        // Peserta
        Route::delete('/peserta/{peserta}', [PesertaController::class, 'destroy'])
            ->name('peserta.destroy');

    }); 

});
