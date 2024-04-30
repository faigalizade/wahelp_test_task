<?php
namespace App\Controllers;

use App\Facades\DB;
use App\Jobs\SendMailJob;
use App\Request;

class MainController extends Controller
{
    public function index()
    {
        return "Hello World";
    }

    public function upload()
    {
        $fileName = 'test';
        $path = $this->request->file('file')->save(filename: $fileName);
        $file = fopen($path, "r");
        $isFirst = true;
        $insertQuery = '';
        while (($row = fgetcsv($file)) !== FALSE) {
            array_pop($row);
            if (!$isFirst) {
                $insertQuery .= ",";
            }
            $isFirst = false;
            $insertQuery .= "('".trim($row[0])."', '$row[1]')";
        }
        $insertQuery = "INSERT INTO users (number, name) VALUES $insertQuery AS new ON DUPLICATE KEY UPDATE name = new.name;";
        DB::execute($insertQuery);
        return [
            'success' => true,
        ];
    }

    public function mailing()
    {
        $subject = $this->request->get('subject') ?? 'Test Subject';
        $text = $this->request->get('text') ?? 'Hello world';
        $jobId = DB::create("INSERT INTO jobs (status) VALUES ('created')");
        $newsLetter = DB::create("INSERT INTO newsletter (job_id, text, subject) VALUES ({$jobId}, '{$text}', '{$subject}')");
        new SendMailJob($jobId, $newsLetter);
    }
}