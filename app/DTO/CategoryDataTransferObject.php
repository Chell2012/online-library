<?php

namespace App\DTO;

final class CategoryDataTransferObject
{
    private $title;
    private $approved;

    /**
     * @param string|null $title
     * @param array|null $approved
     */
    public function __construct(string $title = null, array $approved = null)
    {
        $this->title = $title;
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
     * @return array|null
     */
    public function getApproved(): ?array
    {
        return $this->approved;
    }
}
