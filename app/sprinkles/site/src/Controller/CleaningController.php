<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use Carbon\Carbon;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;

use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;

use UserFrosting\Sprinkle\Site\Database\Models\Cooking;
use UserFrosting\Sprinkle\Site\Database\Models\CookBooking;

use UserFrosting\Sprinkle\Site\Database\Models\Cleaning;
use UserFrosting\Sprinkle\Site\Database\Models\CleanerBooking;

class CleaningController extends SimpleController
{

  public function getCleaning($request, $response, $args)
  {
      $params = $request->getQueryParams();
      $count = 0;
      $this->ci->db;
      $cleanerlist = Cleaning::where('availability','y')->where('area', $params['cleaning_area'])->get();

     if ($params['cleaning_area']!=NULL) {
       if(count($cleanerlist)==NULL){
         return $response->write("Sorry no cleaner available currenty at your area");
       }else{
        $count++;

      return $this->ci->view->render($response,'pages/cleaning/cleanerbooking.html.twig', [
      'name' => $cleanerlist['name'],
      'gender'=>$cleanerlist['gender'],
      'counts'=>$cleanerlist
      ]);
    }}

       else {
          return $response->write("Wrong area Entered");
      }
  }

  public function getConfirmCleaning($request,$response,$args){
    $params = $request->getQueryParams();
    $this->ci->db;
    $bookedUser=$this->ci->currentUser->user_name;
    $cleanerlist = Cleaning::where('mobno', $params['mobno'])->first();
    //return $params['mobno'];
    $cleanerdetails = new CleanerBooking([
      'cleaner_name'=>$cleanerlist['name'],
      'booked_by'=>$bookedUser,
      'address'=>$params['address'],
      'contact_no'=>$params['contactno'],
      'mobno'=>$cleanerlist['mobno'],
      'status'=>1,
      'cleanerdetails'=>$cleanerdetails
    ]);

      $cleanerdetails->save();

    $cleanerlist->availability = "n";
    $cleanerlist->save();
    $email = $this->ci->currentUser->email;
    $message = new TwigMailMessage($this->ci->view, "mail/cleaner-book.html.twig");
    $message->from([
  'email' => 'dasa.sathyan@mca.christuniversity.in',
  'name' => 'HowZHold Tean'
]);
    $message->addEmailRecipient(
  new EmailRecipient($email, $user->full_name)
);

return $this->ci->view->render($response, 'pages/cleaning/bookingconfirmation.html.twig',[
'name' => $cleanerlist['name'],
'gender'=>$cleanerlist['gender'],
'mobno'=>$cleanerlist['mobno'],
'contactno'=>$cleanerdetails['contactno'],
'counts'=>$cleanerlist,
'booking_id'=>$cleanerdetails['id'],
'created_at'=>$cleanerdetails['created_at']
]);
}

public function getCancellation($request,$response,$args){
  $params = $request->getQueryParams();
  $count = 0;
  $this->ci->db;
  $cllist=CleanerBooking::where('created_at', '>=', Carbon::now()->subDay())->where('booked_by','=',$this->ci->currentUser->user_name)->where('status',1)->get();
  return $this->ci->view->render($response, 'pages/cleaning/cancellation.html.twig',[
    'id'=>$cllist['id'],
    'cleaner_name'=>$cllist['cleaner_name'],
    'created_at'=>$cllist['created_at'],
    'contact_no'=>$cllist['contact_no'],
    'mobno'=>$cllist['mobno'],
    'cancel'=>$cllist
  ]);
}

public function getCancelConfirmation($request,$response,$args){
  $params=$request->getQueryParams();
  $this->ci_db;
  $bookedUser=$this->ci->currentUser->user_name;
  $cancelcleaner=CleanerBooking::where('mobno',$params['clmobno'])->where('status',1)->where('booked_by',$bookedUser)->first();
  $cancelcleaner->status=0;
  $cancelcleaner->save();
  $releasecleaner=Cleaning::where('mobno',$params['clmobno'])->first();
  $releasecleaner->availability="y";
  $releasecleaner->save();
  return $this->ci->view->render($response, 'pages/cleaning/cancellation.html.twig');
}

public function getBookings($request,$response,$args){
  $params=$request->getQueryParams();
  $this->ci_db;
  $bookedUser=$this->ci->currentUser->user_name;

  $bookings=CleanerBooking::where('booked_by',$bookedUser)->get();

  return $this->ci->view->render($response, 'pages/cleaning/bookings.html.twig',[
    'cleaner_name'=>$bookings['cleaner_name'],
    'mobile'=>$bookings['mobile'],
    'address'=>$bookings['address'],
    'created_at'=>$bookings['created_at'],
    'bookings'=>$bookings
  ]);
}

public function getBill($request,$response,$args){
  $params=$request->getQueryParams();
  $this->ci->db;

  $bill=CleanerBooking::where('id',$params['id'])->where('status',1)->where('booked_by',$this->ci->currentUser->user_name)->get();

  return $this->ci->view->render($response, 'pages/cleaning/bill.html.twig',[
    'id'=>$bill['id'],
    'cleaner_name'=>$bill['cleaner_name'],
    'mobile'=>$bill['mobile'],
    'address'=>$bill['address'],
    'created_at'=>$bill['created_at'],
    'bills'=>$bill
  ]);
}
public function getCleaningSearch($request,$response,$args){

  $emailuser=$this->ci->currentUser->user_name;
  if($emailuser!="dasasathyan"){
    return "Sorry you dont have access";
}
else{
$params = $request->getQueryParams();
$this->ci->db;
$drlist=Cleaning::where('availability','y')->get();
return $this->ci->view->render($response, 'pages/cleaning/all.html.twig',[
  'clname'=>$drlist['name'],
  'clarea'=>$drlist['area'],
  'cllist'=>$drlist
]);
}
}

}
