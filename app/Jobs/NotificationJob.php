<?php

namespace App\Jobs;

use App\Core\Http\HttpClient;

use Illuminate\Support\Facades\Queue;

class NotificationJob extends Job
{
    
    private $user_id;
    private $message;

    public function __construct(int $user_id, string $message)
    {
       $this->user_id = $user_id;
       $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(HttpClient $httpClient)
    {
        $this->http = $httpClient;
        
        $this->send();
    }

    private function send()
    {
       $notify = $this->http->post(env('MOCKY_NOTIFY'), []);

       if($notify->getStatusCode() != 200){
            Queue::laterOn('high', 10800, new NotificationJob($this->user_id, $this->message));
       }
       
    }
}
