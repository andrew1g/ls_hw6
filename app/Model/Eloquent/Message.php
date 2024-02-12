<?php
namespace App\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    public $timestamps = false;
    protected $fillable = [
        'text',
        'created_at',
        'author_id',
        'image',
        'image_filename',
    ];

    public static function deleteMessage(int $messageId)
    {
        return self::destroy($messageId);
    }
    public static function getList(int $limit = 20, int $offset = 0)
    {
        return self::with('author')
            ->limit($limit)
            ->offset($offset)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public static function getUserMessages(int $userId, int $limit)
    {
        return self::query()->where('author_id', '=', $userId)->limit($limit)->get();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }


    public function loadFile(string $file)
    {

  $home = $_SERVER['DOCUMENT_ROOT'];
            $imagename = $_FILES["image"]["name"];
   
            $uploaddir = '/images/';
            $uploadfile = $uploaddir . basename($_FILES['image']['name']);

        
            move_uploaded_file($file, $home.$uploadfile);
            $this->image_filename = $imagename;
            $this->image = $uploadfile;

        
    }

    

    
    public function getImage()
    {
        return $this->image;
    }

    public function getData()
    {
        return [
            'id' => $this->id,
            'author_id' => $this->authorId,
            'text' => $this->text,
            'created_at' => $this->createdAt,
            'image' => $this->image
        ];
    }
}