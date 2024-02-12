<?php

 include 'init.php';

 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Database\Capsule\Manager as Capsule;

 Capsule::schema()->dropIfExists('users');

 Capsule::schema()->create('users', function (Blueprint $table) {
     $table->increments('id');
     $table->string('name');
     $table->string('password');        
 	$table->string('email')->unique();
     $table->tinyInteger('isadmin')->default(0);	
     $table->timestamp('created_at')->nullable();
     $table->timestamp('updated_at')->nullable();
 });

 Capsule::schema()->dropIfExists('messages');

 Capsule::schema()->create('messages', function (Blueprint $table) {
     $table->increments('id');
     $table->integer('author_id')->unsigned();
     $table->text('text');
     $table->text('image');		
     $table->string('image_filename',1000);			
     $table->timestamp('created_at')->nullable();
     $table->timestamp('updated_at')->nullable();
 });