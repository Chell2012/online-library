<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DTO;

use Carbon\Carbon;

/**
 * DTO for Authors
 * @author vyacheslav
 */
final class AuthorDataTransferObject
{
    private $name;
    private $middleName;
    private $surname;
    private $birth;
    private $death;
    private $approved;

    /**
     *
     * @param string|null $name
     * @param string|null $surname
     * @param string|null $middleName
     * @param Carbon|null $birth
     * @param Carbon|null $death
     * @param array|null $approved
     */
    public function __construct(string $name=null, string $surname=null, string $middleName=null, Carbon $birth=null, Carbon $death=null, array $approved=null)
    {
        $this->name = $name;
        $this->middleName = $middleName;
        $this->surname = $surname;
        $this->birth = $birth;
        $this->death = $death;
        $this->approved = $approved;
    }
    /**
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     *
     * @return null|string
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }
    /**
     *
     * @return null|string
     */
    public function getSurame(): ?string
    {
        return $this->surname;
    }

    /**
     *
     * @return null|Carbon
     */
    public function getBirthDate(): ?Carbon
    {
        return $this->birth;
    }

    /**
     *
     * @return null|Carbon
     */
    public function getDeathDate(): ?Carbon
    {
        return $this->death;
    }

    /**
     * @return null|array
     */
    public function getApprove(): ?array
    {
        return $this->approved;
    }
}
