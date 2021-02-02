<?php

namespace App\Tools;

class Session
{
    public function setName($name): void
    {
        session_name($name);
    }

    public function getName(): string
    {
        return session_name();
    }

    public function setId($id): void
    {
        session_create_id($id);
    }

    public function getId(): string
    {
        return (string) session_id();
    }

    public function cookieExists(): bool
    {
        // TODO realization of this method
    }

    public function sessionExists(): bool
    {
        return !empty($_SESSION);
//        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function start(): bool
    {
        return session_start();
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function setSavePath($savePath): void
    {
        session_save_path($savePath);
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function contains($key): bool
    {
        return $_SESSION[$key] ? true : false;
    }

    public function delete($key): void
    {
        unset($_SESSION[$key]);
    }
}
