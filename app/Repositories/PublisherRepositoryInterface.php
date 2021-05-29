<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author vyacheslav
 */
interface PublisherRepositoryInterface {
    /**
     * 
     * @param type $columns
     * @return Collection|null
     */
    public function getAll($columns): ?Collection;
    /**
     * 
     * @param string $title
     * @return Publisher|null
     */
    public function getPublisherByTitle(string $title): ?Publisher;
    /**
     * 
     * @param string $publisherTitle
     * @return int
     */
    public function getPublisherId(string $publisherTitle): int;
    /**
     * 
     * @param int $id
     * @return Publisher|null
     */
    public function getPublisherById(int $id): ?Publisher;
    /**
     * 
     * @param string $title
     * @return Publisher
     */
    public function newPublisher(string $title): Publisher;
    /**
     * 
     * @param int $id
     * @param string $title
     * @return bool
     */
    public function deletePublisher(int $id, string $title): bool;
}
