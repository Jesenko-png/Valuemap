<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'valuemap:create-admin {email?}';
    protected $description = 'Create or update a ValueMap administrator';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Administrator email');
        $password = $this->secret('Administrator password');
        if (!$email || !$password || strlen($password) < 12) {
            $this->error('A valid email and a password of at least 12 characters are required.');
            return self::FAILURE;
        }
        User::updateOrCreate(['email' => $email], ['name' => 'ValueMap administrator', 'password' => $password, 'is_admin' => true]);
        $this->info('Administrator account is ready.');
        return self::SUCCESS;
    }
}
