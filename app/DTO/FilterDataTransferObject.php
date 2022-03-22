<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DTO;

/**
 * DTO for Books Filter
 *
 * @author vyacheslav
 */
class FilterDataTransferObject
{
    private ?string $title;
    private ?int $publisherId;
    private ?int $year;
    private ?string $isbn;
    private ?int $categoryId;
    private ?array $authorsIds;
    private ?array $tagsIds;
    
    /**
     * 
     * @param string|null $title
     * @param int|null $publisherId
     * @param int|null $year
     * @param string|null $isbn
     * @param int|null $categoryId
     * @param array|null $authorsIds
     * @param array|null $tagsIds
     */
    public function __construct(
            ?string $title,
            ?int $publisherId,
            ?int $year,
            ?string $isbn,
            ?int $categoryId,
            ?array $authorsIds,
            ?array $tagsIds
            )
    {
        $this->title = $title;
        $this->publisherId = $publisherId;
        $this->year = $year;
        $this->isbn = $isbn;
        $this->categoryId = $categoryId;
        $this->authorsIds = $authorsIds;
        $this->tagsIds = $tagsIds;
    }
    /**
     * 
     * @return int
     */
    public function getPublisherId(): ?int
    {
        return $this->publisherId;
    }
    /**
     * 
     * @return int
     */
    public function getYear(): ?int
    {
        return $this->year;
    }
    /**
     * 
     * @return string
     */
    public function getISBN(): ?string
    {
        return $this->isbn;
    }
    /**
     * 
     * @return int
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }
    /**
     * 
     * @return array
     */
    public function getAuthorsIds(): ?array
    {
        return $this->authorsIds;
    }
    /**
     * 
     * @return array
     */
    public function getTagsIds(): ?array
    {
        return $this->tagsIds;
    }
    /**
     * 
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
