<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    #[Test]
    public function only_logged_in_users_can_see_dashboard_screen(): void
    {
        $user = User::factory()->create(); 
        
        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }
}
