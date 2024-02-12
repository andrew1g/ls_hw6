<?php
namespace App\Model;

use Base\Db;

class User
{
    private $id;
    private $name;
    private $registration_date;
    private $password;
    private $email;
    private $isadmin;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->password = $data['password'];;
        $this->registration_date = $data['registration_date'];
        $this->email = $data['email'];
        $this->isadmin = $data['isadmin'];
    }

    

    public function save()
    {
        $db = Db::getInstance();
        $res = $db->exec(
            'INSERT INTO users (
                    name, 
                    password, 
                    registration_date,
                    email
                    ) VALUES (
                    :name, 
                    :password, 
                    :registration_date,
                    :email                    
                )',
            __FILE__,
            [
                ':name' => $this->name,
                ':password' => self::getPasswordHash($this->password),
                ':registration_date' => $this->registration_date,
                ':email' => $this->email,
            ]
        );

        $this->id = $db->lastInsertId();

        return $res;
    }

   


    public static function getList(int $limit = 10, int $offset = 0): array
    {
        $db = Db::getInstance();
        $data = $db->fetchAll(
            "SELECT * fROM users LIMIT $limit OFFSET $offset",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $users = [];
        foreach ($data as $elem) {
            $user = new self($elem);
            $user->id = $elem['id'];
            $users[] = $user;
        }

        return $users;
    }

    public function getIEmail()
    {
        return $this->email;
    }

    public static function getPasswordHash(string $password)
    {
        return sha1('.solsolsol' . $password);
    }


    public function getId()
    {
        return $this->id;
    }

   
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

// //Я сделал хранение признака Админа в базе.
//     public function isAdmin(): bool
//     {
//             if ($this->isadmin===NUll) {
//                 return false;
//             }
//             else {
//                 return $this->isadmin;
//             }    
//     }


public function isAdmin(): bool
{
  return in_array($this->id, ADMIN_IDS);
} 

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $data = $db->fetchOne("SELECT * fROM users WHERE id = :id", __METHOD__, [':id' => $id]);
        if (!$data) {
            return null;
        }

        $user = new self($data);
        $user->id = $id;
        return $user;
    } 

    public static function getByIds(array $userIds)
    {
        $db = Db::getInstance();
        $idsString = implode(',', $userIds);
        $data = $db->fetchAll(
            "SELECT * fROM users WHERE id IN($idsString)",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $users = [];
        foreach ($data as $elem) {
            $user = new self($elem);
            $user->id = $elem['id'];
            $users[$user->id] = $user;
        }

        return $users;
    } 


    public static function getByEmail(string $email)
    {
        $db = Db::getInstance();
        $data = $db->fetchOne(
            "SELECT * fROM users WHERE email = :email",
            __METHOD__,
            [':email' => $email]
        );
        if (!$data) {
            return null;
        }

        $user = new self($data);
        $user->id = $data['id'];
        return $user;
    }

}