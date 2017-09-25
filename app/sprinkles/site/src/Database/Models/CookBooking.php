<?php
namespace UserFrosting\Sprinkle\Site\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class CookBooking extends Model{
  protected $table = "cookbooking";

  protected $fillable = [
      "id",
      "cook_name",
      "booked_by",
      "created_at",
      "address",
      "contact_no",
      "mobno",
      "status"
  ];
}
