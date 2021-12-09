<?php

namespace App\Console\Commands\Weather;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NewsletterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Usado para notificar os usuários as 07 da manhã do horário de brasilia';

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
        User::with('user_ips')->chunk(200, function ($users) {
            foreach ($users as $user) {
                $user->notify(new \App\Notifications\Weather\NewsletterUser);
                $this->info("Previsão do tempo, Usuário: {$user->name} foi notificado.");
            }
        });

        return Command::SUCCESS;
    }
}
