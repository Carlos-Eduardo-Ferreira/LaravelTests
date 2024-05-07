<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]    
    public function profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->
        get(route('profile.edit'));

        $response->assertOk();
    }

    #[Test]    
    public function profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->
        patch(route('profile.update'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasNoErrors()->
        assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    #[Test]    
    public function email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->
        patch(route('profile.update'), [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

        $response->assertSessionHasNoErrors()->
        assertRedirect(route('profile.edit'));

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    #[Test]    
    public function user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->
        delete(route('profile.destroy'), [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors()->
        assertRedirect(route('welcome'));

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    #[Test]    
    public function correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->
        from(route('profile.edit'))->
        delete(route('profile.destroy'), [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrorsIn('userDeletion', 'password')->
        assertRedirect(route('profile.edit'));

        $this->assertNotNull($user->fresh());
    }
}
