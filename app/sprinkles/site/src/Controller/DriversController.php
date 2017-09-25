<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use Carbon\Carbon;
use UserFrosting\Support\Exception\ForbiddenException;
use Slim\Exception\NotFoundException;


use UserFrosting\Sprinkle\Core\Controller\SimpleController;

use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;

use UserFrosting\Sprinkle\Site\Database\Models\Drivers;
use UserFrosting\Sprinkle\Site\Database\Models\DriversBooking;


class DriversController extends SimpleController
{

  public function getDriving($request, $response, $args)
  {
      $params = $request->getQueryParams();
      $count = 0;
      $this->ci->db;
      $driverslist = Drivers::where('availability','y')->where('area', $params['driving_area'])->get();

     if ($params['driving_area']!=NULL) {
       if(count($driverslist)==NULL){
         return $response->write("Sorry no drivers available currenty at your area");
       }else{
        $count++;

      return $this->ci->view->render($response,'pages/driving/driverbooking.html.twig', [
      'name' => $driverslist['name'],
      'gender'=>$driverslist['gender'],
      'counts'=>$driverslist
      ]);
    }}

       else {
          return $response->write("Wrong area Entered");
      }
  }

  public function getConfirmDriving($request,$response,$args){
    $params = $request->getQueryParams();
    $this->ci->db;
    $bookedUser=$this->ci->currentUser->user_name;
    $driverslist = Drivers::where('mobno', $params['mobno'])->first();
    //return $params['mobno'];
    //echo $driverslist['name'];
  //  return "asd";
    $driversdetails = new DriversBooking([
      'driver_name'=>$driverslist['name'],
      'booked_by'=>$bookedUser,
      'address'=>$params['address'],
      'contact_no'=>$params['contactno'],
      'mobno'=>$driverslist['mobno'],
      'status'=>1,
      'driverdetails'=>$driversdetails
    ]);

      $driversdetails->save();

    $driverslist->availability = "n";
    $driverslist->save();
    $email = $this->ci->currentUser->email;
    $message = new TwigMailMessage($this->ci->view, "mail/drivers-book.html.twig");
    $message->from([
  'email' => 'dasa.sathyan@mca.christuniversity.in',
  'name' => 'HowZHold Tean'
]);
    $message->addEmailRecipient(
  new EmailRecipient($email, $user->full_name)
);

return $this->ci->view->render($response, 'pages/driving/bookingconfirmation.html.twig',[
'name' => $driverslist['name'],
'gender'=>$driverslist['gender'],
'mobno'=>$driverslist['mobno'],
'contactno'=>$driversdetails['contactno'],
'counts'=>$driverslist,
'booking_id'=>$driversdetails['id'],
'created_at'=>$driversdetails['created_at']
]);
}

public function getCancellation($request,$response,$args){
  $params = $request->getQueryParams();
  $count = 0;
  $this->ci->db;
  $drlist=DriversBooking::where('created_at', '>=', Carbon::now()->subDay())->where('booked_by','=',$this->ci->currentUser->user_name)->where('status',1)->get();
  return $this->ci->view->render($response, 'pages/driving/cancellation.html.twig',[
    'id'=>$drlist['id'],
    'driver_name'=>$drlist['driver_name'],
    'created_at'=>$drlist['created_at'],
    'contact  no'=>$drlist['contactno'],
    'mobno'=>$drlist['mobno'],
    'cancel'=>$drlist
  ]);
}

public function getCancelConfirmation($request,$response,$args){
  $params=$request->getQueryParams();
  $this->ci_db;
  $bookedUser=$this->ci->currentUser->user_name;
  $canceldrivers=DriversBooking::where('mobno',$params['drmobno'])->where('status',1)->where('booked_by',$bookedUser)->first();
  $canceldrivers->status=0;
  $canceldrivers->save();
  $releasedrivers=Drivers::where('mobno',$params['drmobno'])->first();
  $releasedrivers->availability="y";
  $releasedrivers->save();
  return $this->ci->view->render($response, 'pages/driving/cancellation.html.twig');
}

public function getBookings($request,$response,$args){
  $params=$request->getQueryParams();
  $this->ci_db;
  $bookedUser=$this->ci->currentUser->user_name;

  $bookings=DriversBooking::where('booked_by',$bookedUser)->get();

  return $this->ci->view->render($response, 'pages/driving/bookings.html.twig',[
    'driver_name'=>$bookings['driver_name'],
    'mobile'=>$bookings['mobile'],
    'address'=>$bookings['address'],
    'created_at'=>$bookings['created_at'],
    'bookings'=>$bookings
  ]);
}

public function getBill($request,$response,$args){
  $params=$request->getQueryParams();
  $this->ci->db;

  $bill=DriversBooking::where('id',$params['id'])->where('status',1)->where('booked_by',$this->ci->currentUser->user_name)->get();

  return $this->ci->view->render($response, 'pages/driving/bill.html.twig',[
    'id'=>$bill['id'],
    'driver_name'=>$bill['driver_name'],
    'mobile'=>$bill['mobile'],
    'address'=>$bill['address'],
    'created_at'=>$bill['created_at'],
    'bills'=>$bill
  ]);
}
public function getDrivingSearch($request,$response,$args){

  $emailuser=$this->ci->currentUser->user_name;
  if($emailuser!="dasasathyan"){
    throw new NotFoundException($request, $response);

}
else{
$params = $request->getQueryParams();
$this->ci->db;
$drlist=Drivers::where('availability','y')->get();
return $this->ci->view->render($response, 'pages/driving/all.html.twig',[
  'drname'=>$drlist['name'],
  'drarea'=>$drlist['area'],
  'drlist'=>$drlist
]);
}
}

}
