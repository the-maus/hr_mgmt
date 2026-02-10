<?php

use App\Models\User;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/email', function () {
    Mail::raw('Test message', function(Message $message){
        $message->to('test@gmail.com')
                ->subject('Welcome to HR MGMT')
                ->from('hr@hrmgmt.com');
    });

    echo "Mail sent!";
});

Route::get('/admin', function(){
    $admin = User::with('detail', 'department')->find(1);
    dd($admin->toArray());
});
