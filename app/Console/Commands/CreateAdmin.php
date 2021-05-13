<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\AdminRegister;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send registration link for the admin';

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
        Mail::to($this->argument('email'))->send(new AdminRegister());
        $this->info('Registration Link has been sent to the provided email');
    }




}
