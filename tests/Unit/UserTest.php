<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    #[Test]
    public function check_if_user_columns_are_correct(): void
    {
        $user = new User();
        
        // Expected columns
        $columns_expected = [
            'name',
            'email',
            'password',
        ];

        // Columns that the User model actually accepts
        $fillable_columns = $user->getFillable();
        
        // Check if all expected columns are present
        foreach ($columns_expected as $column) {
            $this->assertContains($column, $fillable_columns, "The column {$column} is not present.");
        }

        // Check if there are no extra columns
        $extra_columns = array_diff($fillable_columns, $columns_expected);
        $this->assertCount(0, $extra_columns, 'There are extra columns in the model.');
    }

    #[Test]
    public function check_if_user_columns_are_not_empty(): void
    {
        $user = new User();

        $fillable_columns = $user->getFillable();

        // Check if the fillable columns are not empty
        $this->assertNotEmpty($fillable_columns, 'The fillable columns should not be empty.');
    }

    #[Test]
    public function check_if_user_columns_include_email_and_password(): void
    {
        $user = new User();

        $fillable_columns = $user->getFillable();

        // Check if the columns include 'email' and 'password'
        $this->assertContains('email', $fillable_columns, "The column 'email' is not present.");
        $this->assertContains('password', $fillable_columns, "The column 'password' is not present.");
    }
}
