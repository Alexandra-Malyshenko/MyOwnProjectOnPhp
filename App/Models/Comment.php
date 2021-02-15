<?php

namespace App\models;

class Comment
{
    private int $id;
    private string $text;
    private string $publication_date;
    private int $user_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getPublicationDate(): string
    {
        return $this->publication_date;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setPublicationDate(string $date): void
    {
        $this->publication_date = $date;
    }
}