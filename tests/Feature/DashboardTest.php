<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function only_logged_in_users_can_see_dashboard_screen(): void
    {
        $user = User::factory()->create();

        // Acting as the created user and accessing the dashboard route
        $response = $this->actingAs($user)->get(route('dashboard'));

        // Asserting that the status of the response is 200 (OK)
        $response->assertStatus(200);

        // Asserting that the response contains the text 'Dashboard'
        $response->assertSee('Dashboard');
    }

    #[Test]
    public function non_logged_in_users_cannot_see_dashboard_screen(): void
    {
        // Accessing the dashboard route without being authenticated
        $response = $this->get(route('dashboard'));

        // Asserting that the user is redirected to the login page
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function logged_in_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        // Acting as the created user and accessing the dashboard route
        $response = $this->actingAs($user)->get(route('dashboard'));

        // Asserting that the status of the response is 200 (OK)
        $this->assertEquals(200, $response->status(), 'Authenticated user could not access the dashboard.');
    }

    #[Test]
    public function ensure_response_content_for_dashboard(): void
    {
        $user = User::factory()->create();

        // Acting as the created user and accessing the dashboard route
        $response = $this->actingAs($user)->get(route('dashboard'));

        // Asserting that the status of the response is 200 (OK)
        $response->assertStatus(200);

        // Asserting that the view returned is the 'dashboard' view
        $response->assertViewIs('dashboard');
    }
}
