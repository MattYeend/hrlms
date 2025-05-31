<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a successful response', function () {
    $response = $this->get('/');
    
    $response->assertRedirect('/login');

    $followed = $this->followingRedirects()->get('/');
    $followed->assertStatus(200);
    $followed->assertSee('Login'); 
});
