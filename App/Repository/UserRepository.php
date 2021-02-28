<?php

namespace App\Repository;

use App\models\User;
use PDO;

class UserRepository
{
    private PDO $getConnect;

    public function __construct(PDO $PDO)
    {
        $this->getConnect = $PDO;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT id, name, email, city 
                FROM users";
        $statement = $this->getConnect->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\User');
        return $statement->fetchAll();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        $sql = "SELECT id, name, email, city 
                FROM users 
                WHERE id = :id";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\User');
        return $statement->fetch();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getByName(string $name)
    {
        $sql = "SELECT id, name, email, city, password 
                FROM users 
                WHERE name = :name";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['name' => $name]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\User');
        return $statement->fetch();
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getByEmail(string $email)
    {
        $sql = "SELECT id, name, email, city, password 
                FROM users 
                WHERE email = :email";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['email' => $email]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\User');
        return $statement->fetch();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $city
     * @return bool
     */
    public function create(string $name, string $email, string $password, string $city): bool
    {
        $sql = "INSERT INTO users (name, email, password, city) 
                VALUE (:name, :email, :password, :city)";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password, 'city' => $city]);
        return true;
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $city
     * @return bool
     */
    public function update(int $id, string $name, string $email, string $password, string $city): bool
    {
        $sql = "UPDATE users 
                SET (  name = :name, 
                       email = :email, 
                       password = :password, 
                       city = :city) 
                WHERE id = :id";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'city' => $city
        ]);
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users 
                WHERE id = :id";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }
}