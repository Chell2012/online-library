<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DTO;

use Carbon\Carbon;

/**
 * DTO for Users
 * @author vyacheslav
 */
final class UserDataTransferObject
{
    private $name;
    private $email;
    private $verified;
    private $roles;

    /**
     *
     * @param string|null $name
     * @param string|null $email
     * @param bool|null $verified
     * @param array|null $roles
     */
    public function __construct(string $name=null, string $email=null, bool $verified=null, array $roles = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->verified = $verified;
        $this->roles = $roles;
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
    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
     *
     * @return null|bool
     */
    public function getVerified(): ?bool
    {
        return $this->verified;
    }
    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }
}   
