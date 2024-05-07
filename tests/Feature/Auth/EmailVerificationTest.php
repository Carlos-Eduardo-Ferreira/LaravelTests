<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]    
    public function email_verification_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->
        get(route('verify_email.notice'));

        $response->assertStatus(200);
    }

    #[Test]    
    public function email_can_be_verified(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verify_email.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id, 
                'hash' => sha1($user->email)
            ]
        );

        $response = $this->actingAs($user)->
        get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue(
            $user->fresh()->
            hasVerifiedEmail()
        );

        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    }

    #[Test]    
    public function email_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verify_email.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id, 
                'hash' => sha1('wrong-email')
            ]
        );

        $this->actingAs($user)->
        get($verificationUrl);

        $this->assertFalse(
            $user->fresh()->
            hasVerifiedEmail()
        );
    }
}
