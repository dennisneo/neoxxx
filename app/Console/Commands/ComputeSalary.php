<?php

namespace App\Console\Commands;

use App\Models\ClassSessions\ClassSessions;
use Illuminate\Console\Command;

class ComputeSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teacher:salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Computes the salary of the teacher per week';

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
     * @return mixed
     */
    public function handle()
    {
        // salary are computed from Monday to Sunday

        // check if its Monday 12:00 am

        $last_monday = date('Y-m-d H:i:s' , strtotime( "previous monday" ) );
        $last_sunday = date('Y-m-d 23:59:59' , strtotime( "previous sunday" ) );

        // get all 'done' class sessions for the week

        $s = new ClassSessions;
        $s->teacherWeekSched( $last_monday , $last_sunday );

    }
}
