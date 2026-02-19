<?php

use App\Models\Department;
use App\Models\User;

it('tests if an admin can insert a new HR user', function(){
    addAdminUser();

    // create departments
    addDepartment('Administration'); // id: 1
    addDepartment('Human Resources'); // id: 2

    // login with admin user
    $result = $this->post('/login', [
        'email' => 'admin@rhmangnt.com',
        'password' => 'Aa123456'
    ]);

    // check if it logged in successfully
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // add new HR user
    $result = $this->post('/hr-users/new', [
        'name' => 'HR user 1',
        'email' => 'hruser@gmail.com',
        'select_department' => Department::HR_DEPARTMENT,
        'address' => 'Street 1',
        'zip_code' => '1234-123',
        'city' => 'City',
        'phone' => '123456789',
        'salary' => '1000.00',
        'admission_date' => '2021-01-10',
        'role' => 'hr',
        'permissions' => '["hr"]'
    ]);

    // check if HR user was successfully created
    $this->assertDatabaseHas('users', [
        'name' => 'HR user 1',
        'email' => 'hruser@gmail.com',
        'role' => 'hr',
        'permissions' => '["hr"]'
    ]);

});

it('tests if an hr can insert a new collaborator user', function(){
    addHrUser();

    // create departments
    addDepartment('Administration'); // id: 1
    addDepartment('Human Resources'); // id: 2
    addDepartment('Storage');

    // login with admin user
    $result = $this->post('/login', [
        'email' => 'hr@mgmt.com',
        'password' => 'Aa123456'
    ]);

    // check if it logged successfuly by logged user role
    expect(auth()->user()->role)->toBe('hr');

    // add new collaborator user
    $result = $this->post('/hr-users/management/new-collaborator', [
        'name' => 'Collaborator 1',
        'email' => 'collaborator@gmail.com',
        'select_department' => 3,
        'address' => 'Street 2',
        'zip_code' => '0000-000',
        'city' => 'City 2',
        'phone' => '123456789',
        'salary' => '1000.00',
        'admission_date' => '2021-01-10',
        'role' => 'collaborator',
        'permissions' => '["collaborator"]'
    ]);

    // check if collaborator user was successfully created
    // $this->assertDatabaseHas('users', [
    //     'email' => 'collaborator@gmail.com',
    // ]); // OR

    expect(User::where('email', 'collaborator@gmail.com')->exists())->toBeTrue();
});

function addDepartment($name)
{
    Department::insert([
        'name' => $name,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
