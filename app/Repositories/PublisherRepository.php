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
 * Description of PublisherRepository
 *
 * @author vyacheslav
 */
class PublisherRepository implements PublisherRepositoryInterface {
    
    public function getAll($columns = ['*']): ?Collection {
        return Publisher::all($columns);
    }
    
    public function getPublisherById(int $id): ?Publisher {
        return Publisher::query()->find($id);
    }
    public function getPublisherId(string $publisherTitle): int {
        
        $publisher = $this->getPublisherByTitle($publisherTitle);
        if ($publisher===NULL){
            $publisher = $this->newPublisher($publisherTitle);
        }

        return $publisher->id;
    }
    
    public function getPublisherByTitle(string $title): ?Publisher{
        return Publisher::query()->where('title',$title)->first();
    }
    
    public function deletePublisher($id = null, $title = null): bool {
        if (!($id||$title)) {
            return false;
        }
        if ($id!=null){
            return $this->getPublisherById($id)->delete();
        }
        if ($title != null){
            return $this->getPublisherByTitle($title)->delete();
        }
        return false;
    }
    
    public function newPublisher(string $title): Publisher{
        return Publisher:: query()->create(['title'=>$title]);
    }
}
