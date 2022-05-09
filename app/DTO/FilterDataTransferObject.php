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
    private $title;
    private $publisherId;
    private $year;
    private $isbn;
    private $categoryId;
    private $authorsIds;
    private $tagsIds;
    private $approved;
    private $sortBy;

    /**
     *
     * @param string|null $title
     * @param int|null $publisherId
     * @param int|null $year
     * @param string|null $isbn
     * @param int|null $categoryId
     * @param array|null $authorsIds
     * @param array|null $tagsIds
     * @param array|null $approved
     * @param string|null $sortBy
     */
    public function __construct(

        ?string $title,
        ?int $publisherId,
        ?int $year,
        ?string $isbn,
        ?int $categoryId,
        ?array $authorsIds,
        ?array $tagsIds,
        ?array $approved,
        ?string $sortBy
    ){
        $this->title = $title;
        $this->publisherId = $publisherId;
        $this->year = $year;
        $this->isbn = $isbn;
        $this->categoryId = $categoryId;
        $this->authorsIds = $authorsIds;
        $this->tagsIds = $tagsIds;
        $this->approved = $approved;
        $this->sortBy = $sortBy;
    }
    /**
     *
     * @return int|null
     */
    public function getPublisherId(): ?int
    {
        return $this->publisherId;
    }
    /**
     *
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }
    /**
     *
     * @return string|null
     */
    public function getISBN(): ?string
    {
        return $this->isbn;
    }
    /**
     *
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }
    /**
     *
     * @return array|null
     */
    public function getAuthorsIds(): ?array
    {
        return $this->authorsIds;
    }
    /**
     *
     * @return array|null
     */
    public function getTagsIds(): ?array
    {
        return $this->tagsIds;
    }
    /**
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     *
     * @return array|null
     */
    public function getApproved(): ?array
    {
        return $this->approved;
    }
    /**
     *
     * @return string|null
     */
    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }
}
