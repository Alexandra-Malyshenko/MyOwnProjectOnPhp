<?php

namespace App\models;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $city;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function __toString(): string
    {
        return sprintf(
            '{"id": %d, "name": "%s", "email": "%s", "password": "%s" }',
            $this->getId(),
            $this->getName(),
            $this->getEmail(),
            $this->getPassword(),
            $this->getCity()
        );
    }
}