<?php

use App\Services\GeneralServices;

it('tests if salary is greater than a specific amount', function () {
    $salary = 1000;
    $amount = 500;

    $result = GeneralServices::checkIfSalaryIsGreaterThan($salary, $amount);

    expect($result)->toBeTrue();
});

it('tests if salary is not greater than a specific amount', function () {
    $salary = 1000;
    $amount = 1500;

    $result = GeneralServices::checkIfSalaryIsGreaterThan($salary, $amount);

    expect($result)->toBeFalse();
});

it('tests if the phrase is created successfully', function () {
    $name = 'Matheus Sampaio';
    $salary = 8000;

    $result = GeneralServices::createPhraseWithNameAndSalary($name, $salary);

    expect($result)->toBe("Matheus Sampaio's salary is: R$ 8000");
});

it('tests if the salary with bonus is calculated correctly', function () {
    $salary = 1000;
    $bonus = 25;

    $result = GeneralServices::getSalaryWithBonus($salary, $bonus);

    expect($result)->toBe(1025);
});

it('tests if the fake JSON data is created correctly', function () {
    $result = GeneralServices::fakeDataInJson();
    $clients = json_decode($result);

    expect(count($clients))->toBeGreaterThanOrEqual(1);
    expect($clients[0])->toHaveKeys(['name', 'email', 'phone', 'address']);
});

it('tests if the complex data is created correctly', function () {
    $result = GeneralServices::jsonComplexData();
    $data = json_decode($result, true);

    // expect(count($data))->toBeGreaterThanOrEqual(1);
    expect($data)->toHaveKeys(['name', 'email', 'phones', 'addresses']);
    expect($data['addresses'])->tobeArray();
    expect($data['addresses'][0])->toHaveKeys(['street', 'city', 'country']);
    expect($data['phones'])->toHaveKeys(['phones', 'mobiles']);
    expect($data['phones']['phones'])->toBeArray();
    expect($data['phones']['mobiles'])->toBeArray();
});
