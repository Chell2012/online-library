<?php

namespace App\DTO;

final class TagDataTransferObject
{
    private $title;
    private $category;
    private $approved;

    /**
     * @param string|null $title
     * @param int|null $category
     * @param array|null $approved
     */
    public function __construct(string $title = null, int $category = null, array $approved = null)
    {
        $this->title = $title;
        $this->category = $category;
        $this->approved = $approved;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return array|null
     */
    public function getApproved(): ?array
    {
        return $this->approved;
    }
}
