<?php
namespace UserFrosting\Sprinkle\Site\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class Cooking extends Model{
  protected $table = "cooking";

  protected $fillable = [
      "no",
      "area",
      "gender",
      "availability",
      "mobno",
      "aadhar"
  ];
}
