<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_returns_token(): void
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'user@example.com',
            'password' => 'secret123',
        ]);

        $response->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('token'));
    }
}
