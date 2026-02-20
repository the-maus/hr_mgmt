<?php

it('tests if logged admin user can see HR collaborators page', function(){
    addAdminUser();
    // login with admin
    auth()->loginUsingId(1);

    // check if successfully access HR users page
    expect($this->get('/hr-users')->status())->toBe(200);
});

it('tests if non-logged user is blocked from home page', function(){
    // since non-logged user is redirected from home page
    expect($this->get('/home')->status())->toBe(302); 

    // or
    // expect($this->get('/home')->status())->not()->toBe(200); 
});

it('tests if logged user is blocked from login page', function(){
    addAdminUser();

    // login with admin
    auth()->loginUsingId(1);

    // since logged user would be redirected from login page
    expect($this->get('/login')->status())->toBe(302); 
});

it('tests if logged user is blocked from password recovery page', function(){
    addAdminUser();

    // login with admin
    auth()->loginUsingId(1);

    expect($this->get('/forgot-password')->status())->not()->toBe(200); 
});