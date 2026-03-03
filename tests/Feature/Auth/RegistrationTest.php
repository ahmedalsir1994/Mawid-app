<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpVerificationMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_are_redirected_to_otp_verification(): void
    {
        Mail::fake();

        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        // Should NOT be logged in yet — OTP step is required first
        $this->assertGuest();

        // Must redirect to the OTP verification screen
        $response->assertRedirect('/verify-otp');

        // An OTP email must have been dispatched
        Mail::assertSent(OtpVerificationMail::class, fn ($mail) => $mail->hasTo('test@example.com'));
    }
}
