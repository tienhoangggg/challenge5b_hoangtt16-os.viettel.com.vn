<?php
/*create table `users` (
    `id` int not null auto_increment primary key,
    `role` varchar(255) not null default 'student',
  `username` varchar(255) not null,
    `password` varchar(255) not null,
    `name` varchar(255) not null,
    `email` varchar(255),
    `phone` varchar(255),
    `avatar` varchar(255)
);*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role')->default('student');
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
?>