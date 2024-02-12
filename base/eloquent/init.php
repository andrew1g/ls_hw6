<?php
require '../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'ls6eloquent',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix' => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

//Включаем лог запросов
$capsule->getConnection()->enableQueryLog();

function printLog() {
    echo '<pre>';
    $log = Capsule::getQueryLog();
    foreach ($log as $logelement) {
        echo $logelement['time'] . ": " . $logelement['query'] . " bind: " . json_encode($logelement['bindings']) . "<br>";        
    }
    echo '</pre>';
}


class User extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    public function messages() {
        return $this->hasMany(Message::class, 'author_id', 'id');
    }



}

class Message extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';
    
    public function author() {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}


