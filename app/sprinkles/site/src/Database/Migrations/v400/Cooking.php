<?php
namespace UserFrosting\Sprinkle\Site\Database\Migrations\v400;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;

class Cooking extends Migration
{
public function up(){
  if (!$this->schema->hasTable('cooking')) {
      $this->schema->create('throttles', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('mobno');
          $table->string('area');
          $table->string('gender');
          $table->string('availability');
          $table->integer('aadhar');

          $table->engine = 'InnoDB';
          $table->collation = 'utf8_unicode_ci';
          $table->charset = 'utf8';
          $table->index('type');
          $table->index('ip');
      });
}

}
public function down()
{
    $this->schema->drop('cooking');
}
}

 ?>
