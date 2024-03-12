<?php
/*
create table `chat` (
  `id` int not null auto_increment primary key,
  `sender` int not null,
  `receiver` int not null,
  `message` text not null,
  `created_at` timestamp not null default current_timestamp
);
alter table `chat` add foreign key (`sender`) references `users` (`id`);
alter table `chat` add foreign key (`receiver`) references `users` (`id`);
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class Chat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender')->constrained('users');
            $table->foreignId('receiver')->constrained('users');
            $table->text('message');
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
        Schema::dropIfExists('chat');
    }
}
?>