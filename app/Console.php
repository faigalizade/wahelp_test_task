<?php

namespace App;

use App\Facades\DB;
use App\Jobs\SendMailJob;

class Console
{
    private string $command;
    public function __construct(private array $arguments)
    {
        $this->command = $this->arguments[0];
        if (!method_exists($this, $this->command)) {
            echo "Error: Unknown command";
            exit(1);
        }
        $this->arguments = array_slice($this->arguments, 1);
        $this->{$this->command}();
    }

    private function migrate()
    {
        $migrations = scandir(realpath('app/migrations'));
        foreach ($migrations as $migration) {
            if (in_array($migration, ['.', '..'])) {
                continue;
            }
            DB::migrate(realpath('app/migrations/'.$migration));
        }
    }

    private function failedJobs()
    {
        $jobs = DB::get("SELECT id FROM jobs WHERE status = 'failed'");
        foreach ($jobs as $job) {
            new SendMailJob($job['id']);
        }
    }
}