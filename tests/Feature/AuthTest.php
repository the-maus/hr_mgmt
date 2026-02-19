<?php

it('displays the login page when user not logged in', function(){
    // check on Fortify context if, when accessing home page, it will be redirected to login
    $result = $this->get('/')->assertRedirect('/login');

    // check if it redirects
    expect($result->status())->toBe(302);

    // check if login route is accessible with 200 status
    expect($this->get('/login')->status())->toBe(200);

    // check if login page contains "Forgot your password?" text 
    // in order to check if the page was correctly loaded
    expect($this->get('/login')->content())->toContain("Forgot your password?");
});