<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function check_if_user_columns_is_correct(): void
    {
        $user = new User();
        
        $columns_expected = [
            'name',
            'email',
            'password'
        ];
        
        $array_compared = array_diff($columns_expected, $user->getFillable());

        $this->assertEquals(0, count($array_compared));
    }
}
