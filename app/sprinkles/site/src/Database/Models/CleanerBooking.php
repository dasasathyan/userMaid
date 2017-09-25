<?php
namespace UserFrosting\Sprinkle\Site\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class CleanerBooking extends Model{
  protected $table = "cleanerbooking";

  protected $fillable = [
      "id",
      "cleaner_name",
      "mobno",
      "contact_no",
      "address",
      "booked_by",
      "created_at",
      "status"
  ];
}
