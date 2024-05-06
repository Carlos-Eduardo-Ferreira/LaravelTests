<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    /** @test */
    public function only_logged_in_users_can_see_customers_list(): void
    {
        $response = $this->get(route('dashboard'));
        
        $response->assertRedirect(route('login'));
    }
}
