<?php
namespace UserFrosting\Sprinkle\Site\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class DriversBooking extends Model{
  protected $table = "driversbooking";

  protected $fillable = [
      "id",
      "driver_name",
      "mobno",
      "contact_no",
      "address",
      "booked_by",
      "created_at",
      "status"
  ];
}
