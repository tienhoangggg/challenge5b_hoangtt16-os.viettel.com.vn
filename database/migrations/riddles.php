<?php
/*
create table `riddles` (
  `id` int not null auto_increment primary key,
  `teacher` int not null,
  `title` varchar(255) not null,
  `description` text not null,
  `file` varchar(255)
);
alter table `riddles` add foreign key (`teacher`) references `users` (`id`);
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class Riddles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riddles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher')->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->string('file')->nullable();
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
        Schema::dropIfExists('riddles');
    }
}
?>