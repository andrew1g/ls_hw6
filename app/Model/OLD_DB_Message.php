<?php
namespace App\Model;

use Base\Db;

class Message
{
    private $id;
    private $text;
    private $createdAt;
    private $authorId;
   
    private $image;
    private $image_filename;

    public function __construct(array $data)
    {
        $this->text = $data['text'];
        $this->createdAt = $data['created_at'];
        $this->authorId = $data['author_id'];
        $this->image = $data['image'] ?? '';
        $this->image_filename = $data['image_filename'] ?? '';
    }

    public static function deleteMessage(int $messageId)
    {
        $db = Db::getInstance();
        $query = "DELETE FROM messages WHERE id = $messageId";
        return $db->exec($query, __METHOD__);
    }

    public function save()
    {
        $db = Db::getInstance();
        $res = $db->exec(
            'INSERT INTO messages (
                    text, 
                    created_at,
                    author_id,                    
                    image,
                    image_filename
                    ) VALUES (
                    :text, 
                    :created_at,
                    :author_id,
                    :image,
                    :image_filename
                )',
            __FILE__,
            [
                ':text' => $this->text,
                ':created_at' => $this->createdAt,
                ':author_id' => $this->authorId,
                ':image' => $this->image,
                ':image_filename' => $this->image_filename,
            ]
        );

        return $res;
    }

    public static function getList(int $limit = 20, int $offset = 0): array
    {
        $db = Db::getInstance();
        $data = $db->fetchAll(
            "SELECT * fROM messages LIMIT $limit OFFSET $offset",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $messages = [];
        foreach ($data as $elem) {
            $message = new self($elem);
            $message->id = $elem['id'];
            $messages[] = $message;
        }

        return $messages;
    }

    public static function getUserMessages(int $userId, int $limit): array
    {
        $db = Db::getInstance();
        $data = $db->fetchAll(
            "SELECT * fROM messages WHERE author_id = $userId LIMIT $limit",
            __METHOD__
        );
        if (!$data) {
            return [];
        }

        $messages = [];
        foreach ($data as $elem) {
            $message = new self($elem);
            $message->id = $elem['id'];
            $messages[] = $message;
        }

        return $messages;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        //ищем пользователя по authorId
        return User::getById($this->authorId);
    }

    /**
     * @param User $author
     */
    public function setAuthorid(User $author): void
    {
        $this->authorId = $author->getId();
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
          
            //dd($uploadfile);

          

      
    }

    

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getImage_filename()
    {
        return $this->image_filename;
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