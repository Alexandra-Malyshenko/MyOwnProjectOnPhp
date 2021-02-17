<?php

namespace App\models;

class Order
{
    private int $id;
    private int $user_id;
    private string $address;
    private string $price_total;
    private $comments;
    private string $contact_phone;
    private string $user_name;
    private string $user_email;
    private string $created_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getUserName(): int
    {
        return $this->user_name;
    }

    public function getUserEmail(): int
    {
        return $this->user_email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPriceTotal(): string
    {
        return $this->price_total;
    }

    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    public function getComments(): string
    {
        return $this->comments == null ? '' : $this->comments;
    }

    public function getDate(): string
    {
        return $this->created_at;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setUserName(int $user_name): void
    {
        $this->user_name = $user_name;
    }

    public function setUserEmail(int $user_email): void
    {
        $this->user_email = $user_email;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->price_total = $total_price;
    }

    public function setContactPhone(string $phone): void
    {
        $this->contact_phone = $phone;
    }

    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }
}