<?php

namespace App\Services;

use Faker\Factory;

class GeneralServices
{
    public static function checkIfSalaryIsGreaterThan($salary, $amount)
    {
        return $salary > $amount;
    }

    public static function createPhraseWithNameAndSalary($name, $salary)
    {
        return "$name's salary is: R$ $salary";
    }

    public static function getSalaryWithBonus($salary, $bonus)
    {
        return $salary + $bonus;
    }

    public static function fakeDataInJson()
    {
        // create 10 clients with fake data
        $clients = [];

        for ($i=0; $i < 10; $i++) { 
            $clients[] = [
                'name' => Factory::create()->name(),
                'email' => Factory::create()->email(),
                'phone' => Factory::create()->phoneNumber(),
                'address' => Factory::create()->address(),
            ];
        }

        return json_encode($clients, JSON_PRETTY_PRINT);
    }

    public static function jsonComplexData()
    {
        return json_encode(
            [
                'name' => 'João Ribeiro',
                'email' => 'joaoribeiro@gmail.com',
                'addresses' => [
                    [
                        'street' => 'Street 1',
                        'city' => 'Lisbon',
                        'country' => 'Portugal',
                    ],
                    [
                        'street' => 'Street 2',
                        'city' => 'Porto',
                        'country' => 'Portugal',
                    ],
                ],
                'phones' => [
                    'phones' => [
                        '123456789',
                        '987654321',
                        '123456789',
                    ],
                    'mobiles' => [
                        '987654321',
                        '123456789',
                        '987654321',
                    ],
                ]
            ]
        );
    }   
}
