<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DTO;

use Illuminate\Support\Carbon;

/**
 * DTO for Authors
 * @author vyacheslav
 */
final class AuthorDataTransferObject
{
    private string $name;
    private ?string $middleName;
    private string $surname;
    private ?Carbon $birth;
    private ?Carbon $death;
    
    /**
     * 
     * @param string $name
     * @param string $surname
     * @param string $middleName
     * @param Carbon $birth
     * @param Carbon $death
     */
    public function __construct(string $name, string $surname, string $middleName=null, Carbon $birth=null, Carbon $death=null)
    {
        $this->name = $name;
        $this->middleName = $middleName;
        $this->surname = $surname;
        $this->birth = $birth;
        $this->death = $death;
    }
    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * 
     * @return string
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }
    /**
     * 
     * @return string
     */
    public function getSurame(): string
    {
        return $this->surname;
    }

    /**
     * 
     * @return Carbon
     */
    public function getBirthDate(): ?Carbon
    {
        return $this->birth;
    }

    /**
     * 
     * @return Carbon
     */
    public function getDeathDate(): ?Carbon
    {
        return $this->death;
    }
}
