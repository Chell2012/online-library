<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DTO;

/**
 * DTO for Authors
 * @author vyacheslav
 */
final class AuthorDataTransferObject
{
    private string $name;
    private string $middleName;
    private string $surname;
    
    /**
     * 
     * @param string $name
     * @param string $surname
     * @param string $middleName
     */
    public function __construct(string $name, string $surname, string $middleName=null)
    {
        $this->name = $name;
        $this->middleName = $middleName;
        $this->surname = $surname;
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
    public function getMiddleName(): string
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
}
