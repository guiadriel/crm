<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class LoginPageTest extends TestCase
{
    /**
     * User can't be view any route if not logged
     */
    public function testUserIsRedirectWithNoLogin()
    {
        $response = $this->get('/admin/home');

        $response->assertRedirect(route('login'));
    }

    /**
     * User should be able to login
     *
     * @return void
     */
    public function testUserShouldBeLoginOnAdmin()
    {
        $response = $this->post(route('login'), ['email' => 'gui.adriel@gmail.com', 'password' => 'guilherme1']);
        $response->assertRedirect(url(RouteServiceProvider::HOME));
    }

}
