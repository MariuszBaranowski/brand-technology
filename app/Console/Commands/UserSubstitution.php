<?php

namespace App\Console\Commands;

use App\Services\Contracts\UserService;
use Illuminate\Console\Command;

class UserSubstitution extends Command
{

    public function __construct(private UserService $userService)
    {
        return parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-substitution';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reassign estate at user shift';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->userService->checkUserShifts();
    }
}
