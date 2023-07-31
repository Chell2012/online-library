<?php

namespace App\Jobs;

use App\Services\BookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LoadBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $bookService;
    private $path;
    private $userId;

    /**
     * Create a new job instance.
     *
     * @param BookService $bookService
     * @return void
     */
    public function __construct(BookService $bookService, string $path, int $userId)
    {
        $this->bookService = $bookService;
        $this->path = $path;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @param string $path
     * @param int $userId
     * @return bool
     */
    public function handle()
    {
        return $this->bookService->yandexBooksLoader($this->path, $this->userId);
    }
}
