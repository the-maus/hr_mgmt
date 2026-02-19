<?php

use App\Models\Department;
use App\Models\User;

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

it('displays the recovery password page correctly', function(){
    // check if route is accessible with 200 status
    expect($this->get('/forgot-password')->status())->toBe(200);

    // checking content to confirm
    expect($this->get('/forgot-password')->content())->toContain("Already know your password?");
});

it('tests if admin user can login successfully', function(){
    addAdminUser();

    // login with admin
    $result = $this->post('/login', [
        'email' => 'admin@rhmangnt.com',
        'password' => 'Aa123456'
    ]);

    // check if it logged in successfully
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));
});

it('tests if hr user can login successfully', function(){
    addHrUser();

    // login with admin
    $result = $this->post('/login', [
        'email' => 'hr@mgmt.com',
        'password' => 'Aa123456'
    ]);

    // check if it logged in successfully
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // check if it can access an HR exclusive page
    expect($this->get('/hr-users/management/home')->status())->toBe(200);
});

it('tests if collaborator user can login successfully', function(){
    addCollaboratorUser();

    // login with admin
    $result = $this->post('/login', [
        'email' => 'collaborator@mgmt.com',
        'password' => 'Aa123456'
    ]);

    // check if it logged in successfully
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // check if collaborator is blocked on HR exclusive route
    expect($this->get('/departments')->status())->not()->toBe(200);
});

function addAdminUser()
{
    // create an admin user
    User::insert([
        'department_id' => Department::ADMIN_DEPARTMENT,
        'name' => 'Administrator',
        'email' => 'admin@rhmangnt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'admin',
        'permissions' => '["admin"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function addHrUser()
{
    // create an hr user
    User::insert([
        'department_id' => Department::HR_DEPARTMENT,
        'name' => 'HR Collaborator',
        'email' => 'hr@mgmt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'hr',
        'permissions' => '["hr"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function addCollaboratorUser()
{
    // create a collaborator user
    User::insert([
        'department_id' => 3,
        'name' => 'Collaborator',
        'email' => 'collaborator@mgmt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'collaborator',
        'permissions' => '["collaborator"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}