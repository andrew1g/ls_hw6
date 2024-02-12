<?php
namespace App\Model\Eloquent;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'password',
        'email',
        'created_at',
    ];

    public function setPasswordAttribute($value)
{
      $this->attributes['password'] = $this->getPasswordHash($value);
}

    public static function getList(int $limit = 10, int $offset = 0)
    {
        return self::query()->limit($limit)->offset($offset)->orderBy('id', 'DESC')->get();
    }

    public static function getByEmail(string $email)
    {
        return self::query()->where('email', '=', $email)->first();
    }

    public static function getById(int $id)
    {
        return self::query()->find($id);
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

  
    public function getPassword()
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return in_array($this->id, ADMIN_IDS);
    }
}