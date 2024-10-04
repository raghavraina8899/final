<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);

    $response = $this->get('/login');

    $response->assertStatus(200);
});
it('enter register page', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});
