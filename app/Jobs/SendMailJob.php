<?php

namespace App\Jobs;

use App\Facades\DB;
use Exception;

class SendMailJob
{
    public function __construct(private int $jobId)
    {
        $this->handle();
    }

    public function handle()
    {
        DB::execute("UPDATE jobs SET status = 'started' where id = '{$this->jobId}'");
        try {
            $mail = DB::getOne('newsletter', $this->jobId, 'job_id');
            $users = DB::get("SELECT * FROM users where number not in (SELECT user_number FROM user_sent_newsletter where job_id = {$this->jobId})");
        } catch (Exception $exception) {
            DB::execute("UPDATE jobs SET status = 'failed' where id = '{$this->jobId}'");
            return 0;
        }
        foreach ($users as $user) {
            try {
                $this->sendMessage($mail,$user);
            } catch (Exception $exception) {
                DB::execute("UPDATE jobs SET status = 'failed' where id = '{$this->jobId}'");
                return 0;
            }
        }

        DB::execute("UPDATE jobs SET status = 'completed' where id = '{$this->jobId}'");
    }

    private function sendMessage($mail, $user): void
    {
        $sentStatus = rand(0, 10000);
        if ($sentStatus === 0) {
            throw new Exception('Send failed!');
        }
        DB::execute("INSERT INTO user_sent_newsletter (job_id, user_number) VALUES ('{$this->jobId}', '{$user['number']}')");
    }
}