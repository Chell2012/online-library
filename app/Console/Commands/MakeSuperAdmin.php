<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Создание суперпользователя
 *
 * Class MakeSuperAdmin
 *
 * @package App\Console\Commands
 */
class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create
    {email : e-mail, логин администратора}
    {password? : пароль администратора}
    {--generatePassword : сгенерировать пароль автоматически}
    {--name=admin : имя пользователя (admin по умолчанию)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание суперпользователя';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $superAdmin = new User();
        $superAdmin->email = $email;

        $superAdmin->name = $this->option('name');

        if (empty($password)) {
            if ($this->option('generatePassword')) {
                $password = $this->generatePassword();
            } else {
                $password = $this->secret(
                    'Введите пароль или оставьте поле пустым, чтобы сгенерировать пароль автоматически'
                );
                if (empty($password)) {
                    $this->generatePassword();
                }
            }
        }
        $superAdmin->password = Hash::make($password);
        $superAdmin->save();
        $superAdmin->assignRole('Администратор');

        $this->info('завершено');

        return 0;
    }

    /**
     * Генерация и выдача пароля
     *
     * @return string
     */
    private function generatePassword(): string
    {
        $password = bin2hex(openssl_random_pseudo_bytes(4));
        $this->line("Ваш пароль: $password");

        return $password;
    }
}
