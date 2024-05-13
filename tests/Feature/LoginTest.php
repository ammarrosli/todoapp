<?php

namespace Tests\Feature;

use App\Domain\Core\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $credential = [
            'email' => 'ammarro@gmail.com',
            'password' => 'ammar123'
        ];

        $response = $this->post('login',$credential);
        // $response->assertSessionMissing('errors'); 
    }

    public function test_user_cannot_login()
    {
        $credential = [
            'email' => 'user@ad.com',
            'password' => 'incorrectpass'
        ];
    
        $response = $this->post('login',$credential);
    
        $response->assertSessionHasErrors();
    }
}