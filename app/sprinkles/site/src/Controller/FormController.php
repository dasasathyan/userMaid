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

use UserFrosting\Sprinkle\Site\Database\Models\Drivers;
use UserFrosting\Sprinkle\Site\Database\Models\DriversBooking;

class FormController extends SimpleController
{
  public function formCooking($request, $response, $args)
  {
      $params = $request->getParsedBody();
  }

  public function ServiceRegister($request, $response, $args)
  {
      return $this->ci->view->render($response, 'pages/partials/register.html.twig');
  }

  public function getCooking($request, $response, $args){

      $params = $request->getQueryParams();
      $count = 0;
      $this->ci->db;
      $cooklist = Cooking::where('availability','y')->where('area', $params['cooking_area'])->get();
      if ($params['cooking_area']!=NULL) {
        $count++;
      return $this->ci->view->render($response,'pages/cooking/cookingbooking.html.twig', [
      'name' => $cooklist['name'],
      'gender'=>$cooklist['gender'],
      'counts'=>$cooklist
      ]);
      }

       else {
          return $response->write("Wrong area Entered");
      }
    }

    public function getConfirmCooking($request,$response,$args){
      $params = $request->getParsedBody();
      $this->ci->db;
      $bookedUser=$this->ci->currentUser->user_name;
      $cooklist = Cooking::where('mobno', $params['mobno'])->first();
      //return $params['mobno'];
      $cookdetails = new CookBooking([
        'cook_name'=>$cooklist['name'],
        'booked_by'=>$bookedUser,
        'address'=>$params['address'],
        'contact_no'=>$params['contactno'],
        'mobno'=>$cooklist['mobno'],
        'status'=>1,
        'cookdetails'=>$cookdetails
      ]);

        $cookdetails->save();

      $cooklist->availability = "n";
      $cooklist->save();
      $email = $this->ci->currentUser->email;
      $message = new TwigMailMessage($this->ci->view, "mail/cook-book.html.twig");
      $message->from([
    'email' => 'dasa.sathyan@mca.christuniversity.in',
    'name' => 'HowZHold Tean'
]);
      $message->addEmailRecipient(
    new EmailRecipient($email, $user->full_name)
);
$this->ci->mailer->sendDistinct($message);


    //  $display = Cooking::where('mobno',$params['mobno'])->get();
      return $this->ci->view->render($response, 'pages/cooking/bookingconfirmation.html.twig',[
      'name' => $cooklist['name'],
      'gender'=>$cooklist['gender'],
      'mobno'=>$cooklist['mobno'],
      'contactno'=>$cookdetails['contactno'],
      'counts'=>$cooklist,
      'booking_id'=>$cookdetails['id'],
      'created_at'=>$cookdetails['created_at']
      ]);
    }



    public function getChangeAvailability($request,$response,$args){

      $emailuser=$this->ci->currentUser->user_name;
      if($emailuser!="dasasathyan"){
        return "Sorry you dont have access";

}

else{
  $params = $request->getQueryParams();
  $count = 0;
  $this->ci->db;
  $cllist = Cleaning::where('availability','n')->get();
  $cklist = Cooking::where('availability','n')->get();
  $drlist=Drivers::where('availability','n')->get();
  $count++;
    return $this->ci->view->render($response, 'pages/partials/changeavailability.html.twig',[
      'clname'=>$cllist['name'],
      'clgender'=>$cllist['gender'],
      'clname'=>$cllist['mobno'],
      'ckname'=>$cklist['name'],
      'ckmobno'=>$cklist['mobno'],
      'ckgender'=>$cklist['gender'],
      'drname'=>$drlist['name'],
      'drgender'=>$drlist['gender'],
      'drmobno'=>$drlist['mobno'],
      'ckcounts'=>$cklist,
      'clcounts'=>$cllist,
      'drcounts'=>$drlist
    ]);
}
}

    public function getConfirmavailability($request,$response,$args){
      $params = $request->getQueryParams();
      $count = 0;
      $this->ci->db;

    foreach($params['ckmobno'] as $ckselect){
    $count++;
      $changeck = Cooking::where('mobno', $ckselect)->first();
      $changeck->availability = "y";
      $changeck->save();
    }
      foreach($params['clmobno'] as $clselect){
    $count++;
    $changecl = Cleaning::where('mobno',$clselect)->first();
    $changecl->availability="y";
    $changecl->save();
  }
  foreach($params['drmobno'] as $drselect){
    $count++;
$changedr = Drivers::where('mobno',$drselect)->first();
$changedr->availability="y";
$changedr->save();
}
    return $this->ci->view->render($response, 'pages/partials/confirmchange.html.twig',[
      'count'=>$count,
      'name'=>$changecl,
      'name'=>$changedr,
      'name'=>$changeck
    ]);
}

public function getCancellation($request,$response,$args){
  $params = $request->getQueryParams();
  $count = 0;
  $this->ci->db;
  $cklist=CookBooking::where('created_at', '>=', Carbon::now()->subDay())->where('booked_by','=',$this->ci->currentUser->user_name)->where('status',1)->get();
  return $this->ci->view->render($response, 'pages/cooking/cancellation.html.twig',[
    'id'=>$cklist['id'],
    'cook_name'=>$cklist['cook_name'],
    'created_at'=>$cklist['created_at'],
    'contact_no'=>$cklist['contact_no'],
    'mobno'=>$cklist['mobno'],
    'cancel'=>$cklist
  ]);
}

public function getCancelConfirmation($request,$response,$args){
  $params=$request->getQueryParams();
  $this->ci_db;
  $bookedUser=$this->ci->currentUser->user_name;
  $cancelcook=CookBooking::where('mobno',$params['ckmobno'])->where('status',1)->where('booked_by',$bookedUser)->first();
  $cancelcook->status="0";
  $cancelcook->save();
  $releasecook=Cooking::where('mobno',$params['ckmobno'])->first();
  $releasecook->availability="y";
  $releasecook->save();
  return $this->ci->view->render($response, 'pages/cooking/cancellation.html.twig');

}

public function getCookingSearch($request,$response,$args){

  $emailuser=$this->ci->currentUser->user_name;
  if($emailuser!="dasasathyan"){
    return "Sorry you dont have access";
}
else{
$params = $request->getQueryParams();
$count = 0;
$this->ci->db;
$cllist = Cleaning::where('availability','y')->get();
$cklist = Cooking::where('availability','y')->get();
$drlist=Drivers::where('availability','y')->get();
$max=max(count($cllist),count($cklist),count(drlist));
return $this->ci->view->render($response, 'pages/cooking/all.html.twig',[
  'name'=>$cklist['name'],
  'area'=>$cklist['area'],
  'clname'=>$cllist['name'],
  'clarea'=>$cllist['area'],

  'drname'=>$drlist['name'],
  'drarea'=>$drlist['area'],

  'cklist'=>$cklist,
  'cllist'=>$cllist,
  'drlist'=>$drlist
]);
}
}
}
