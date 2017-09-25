<?php
namespace UserFrosting\Sprinkle\Site\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class Drivers extends Model{
  protected $table = "drivers";

  protected $fillable = [
      "no",
      "name",
      "area",
      "gender",
      "availability",
      "mobno",
      "aadhar"
  ];
}
