<?php
/*
create table `submissions` (
  `id` int not null auto_increment primary key,
  `assignment_id` int not null,
  `student` int not null,
  `file` varchar(255),
  `created_at` timestamp not null default current_timestamp
);
alter table `submissions` add foreign key (`assignment_id`) references `assignments` (`id`);
alter table `submissions` add foreign key (`student`) references `users` (`id`);
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class Submissions
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments');
            $table->foreignId('student')->constrained('users');
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
        Schema::dropIfExists('submissions');
    }
}
?>