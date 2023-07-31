<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Services\BookService;

/**
 * Загрузка книг
 *
 * Class LoadBooks
 *
 * @package App\Console\Commands
 */
class LoadBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Загрузка книг';
	
	/**
     * @var BookService
     */
	private $bookService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
		$this->bookService = $bookService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$this->info('Загрузка...');
        return $this->bookService->yandexBooksLoader(config('library.default_source'), config('library.default_uploader_id'));
        $this->info('завершено');

        return 0;
    }
}
