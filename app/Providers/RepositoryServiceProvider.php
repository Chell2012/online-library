<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepository;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\AuthorRepository;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\TagRepository;
use App\Repositories\TagRepositoryInterface;
use App\Repositories\PublisherRepository;
use App\Repositories\PublisherRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PublisherRepositoryInterface::class, PublisherRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
