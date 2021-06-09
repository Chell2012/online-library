<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DTO;

/**
 * DTO for Books
 *
 * @author vyacheslav
 */
class BookDataTransferObject
{
    private string $title;
    private int $publisherId;
    private int $year;
    private string $isbn;
    private int $categoryId;
    private string $link;
    private string $description;
    private array $authorsIds;
    private array $tagsIds;
    
    /**
     * 
     * @param string $title
     * @param int $publisherId
     * @param int $year
     * @param string $isbn
     * @param int $categoryId
     * @param string $link
     * @param string $description
     * @param array $authorsIds
     * @param array $tagsIds
     */
    public function __construct(
            string $title,
            int $publisherId,
            int $year,
            string $isbn,
            int $categoryId,
            string $link,
            string $description,
            array $authorsIds,
            array $tagsIds
            )
    {
        $this->title = $title;
        $this->publisherId = $publisherId;
        $this->year = $year;
        $this->isbn = $isbn;
        $this->categoryId = $categoryId;
        $this->link = $link;
        $this->description = $description;
        $this->authorsIds = $authorsIds;
        $this->tagsIds = $tagsIds;
    }
    /**
     * 
     * @return int
     */
    public function getPublisherId(): int
    {
        return $this->publisherId;
    }
    /**
     * 
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }
    /**
     * 
     * @return string
     */
    public function getISBN(): string
    {
        return $this->isbn;
    }
    /**
     * 
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
    /**
     * 
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
    /**
     * 
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * 
     * @return array
     */
    public function getAuthorsIds(): array
    {
        return $this->authorsIds;
    }
    /**
     * 
     * @return array
     */
    public function getTagsIds(): array
    {
        return $this->tagsIds;
    }
    /**
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
