<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', function () {
    return view('auth.login');
});
Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('login');
    }

    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]));

    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.request');

            Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.reset');
        }

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.email');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.update');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('register');
        }

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')]);
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
                ->name('verification.notice');
        }

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'signed', 'throttle:' . $verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
            ->name('verification.send');
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-profile-information.update');
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-password.update');
    }

    // Password Confirmation...
    if ($enableViews) {
        Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')]);
    }

    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('password.confirm');

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        if ($enableViews) {
            Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('two-factor.login');
        }

        Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:' . $twoFactorLimiter : null,
            ]));

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'password.confirm']
            : [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')];

        Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::post('/user/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.confirm');

        Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable');

        Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get('/user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.secret-key');

        Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes');

        Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware);
    }
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
    Route::resource('/doctors', \App\Http\Controllers\DoctorController::class);
    Route::get('/doctors/schedule_create/{doctor}', [\App\Http\Controllers\DoctorController::class, 'scheduleCreate'])->name('schedule-create');
    Route::post('/doctors/schedule_edit/{doctor}', [\App\Http\Controllers\DoctorController::class, 'scheduleUpdate'])->name('schedule-update');
    Route::resource('/receptionists', \App\Http\Controllers\ReceptionistController::class);
    Route::resource('/patients', \App\Http\Controllers\PatientController::class);
    Route::resource('/appointments', \App\Http\Controllers\AppointmentController::class);
    Route::resource('/prescriptions', \App\Http\Controllers\PrescriptionController::class);
    Route::resource('/incomes', \App\Http\Controllers\IncomeController::class);
    Route::resource('/expenses', \App\Http\Controllers\ExpenseController::class);
    // settings
    Route::group(['prefix'=>'settings'],function (){
        Route::resource('/expense-types', \App\Http\Controllers\ExpenseTypeController::class);
        Route::resource('/income-types', \App\Http\Controllers\IncomeTypeController::class);
        Route::resource('/formulas', \App\Http\Controllers\FormulaController::class);
        Route::resource('/frequency-types', \App\Http\Controllers\FrequencyTypeController::class);
        Route::resource('/period-types', \App\Http\Controllers\PeriodTypeController::class);
        Route::resource('/session-types', \App\Http\Controllers\SessionTypeController::class);
        Route::resource('/prescription-designs', \App\Http\Controllers\PrescriptionDesignController::class);
    });

    // get appointments of patients ajax
    Route::get('/appointment/get-appointments-of-patient', [\App\Http\Controllers\PrescriptionController::class, 'get_appointments_of_patient']);
    //  get medicines of doctors
    Route::get('/prescription/get_doctor_medicines', [\App\Http\Controllers\PrescriptionController::class, 'get_doctor_medicines']);

    // book appointment
    Route::get('/appointment/get_available_time', [\App\Http\Controllers\AppointmentController::class, 'get_available_time']);
    Route::get('/appointment/get_time_slots', [\App\Http\Controllers\AppointmentController::class, 'get_time_slots']);
    // appointment-lists
    Route::get('/appointment-list/today-appointment', [\App\Http\Controllers\AppointmentListController::class, 'todayAppointments'])->name('today-appointment');
    Route::get('/appointment-list/pending-appointment', [\App\Http\Controllers\AppointmentListController::class, 'pendingAppointments'])->name('pending-appointment');
    Route::get('/appointment-list/upcoming-appointment', [\App\Http\Controllers\AppointmentListController::class, 'upcomingAppointments'])->name('upcoming-appointment');
    Route::get('/appointment-list/complete-appointment', [\App\Http\Controllers\AppointmentListController::class, 'completeAppointments'])->name('complete-appointment');
    Route::get('/appointment-list/cancel-appointment', [\App\Http\Controllers\AppointmentListController::class, 'cancelAppointments'])->name('cancel-appointment');
    Route::get('/appointment-list/complete-action/{id}', [\App\Http\Controllers\AppointmentListController::class, 'completeAction'])->name('complete-action');
    Route::get('/appointment-list/cancel-action/{id}', [\App\Http\Controllers\AppointmentListController::class, 'cancelAction'])->name('cancel-action');
    // calender
    Route::get('/appointment/get-all-appointments', [\App\Http\Controllers\AppointmentController::class, 'get_all_appointments'])->name('get-all-appointments');
    Route::get('/appointment/get-appointments-per-date', [\App\Http\Controllers\AppointmentController::class, 'get_appointments_per_date']);

});
