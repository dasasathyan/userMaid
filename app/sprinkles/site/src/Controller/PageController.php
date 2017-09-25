<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\Site\Database\Models\Cooking;
use UserFrosting\Sprinkle\Site\Database\Models\CookBooking;

use UserFrosting\Sprinkle\Site\Database\Models\Cleaning;
use UserFrosting\Sprinkle\Site\Database\Models\CleanerBooking;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\SoftDeletes;
use UserFrosting\Sprinkle\Account\Util\Password;
use UserFrosting\Sprinkle\Core\Database\Models\Model;
use UserFrosting\Sprinkle\Core\Facades\Debug;


class PageController extends SimpleController
{

  public function pageIndex($request, $response, $args)
  {
      return $this->ci->view->render($response, 'pages/partials/index.html.twig');
  }

  public function pageAbout($request, $response, $args)
  {
      return $this->ci->view->render($response, 'pages/partials/about.html.twig');
  }

    public function pageCleaning($request, $response, $args)
    {

        return $this->ci->view->render($response, 'pages/cleaning/cleaning.html.twig');
    }

    public function pageCooking($request, $response, $args)
    {
      return $this->ci->view->render($response, 'pages/cooking/cooking.html.twig');
    }

    public function pageDriving($request, $response, $args)
    {
      return $this->ci->view->render($response, 'pages/driving/driving.html.twig');
    }

    public function pageCookingbooking($request,$response,$args){
        return $this->ci->view->render($response, 'pages/cooking/cookingbooking.html.twig');
    }

    public function pageBill($request,$response,$args){
      $params=$request->getQueryParams();
      $this->ci->db;
      echo $params['id'];

      $bill=CookBooking::where('id',$params['id'])->where('status',1)->where('booked_by',$this->ci->currentUser->user_name)->get();
      if($bill==NULL){
        return $response->write("Invalid ID no.");
    }
    else{
      return $this->ci->view->render($response, 'pages/cooking/bill.html.twig',[
        'id'=>$bill['id'],
        'cook_name'=>$bill['cook_name'],
        'mobile'=>$bill['mobile'],
        'address'=>$bill['address'],
        'created_at'=>$bill['created_at'],
        'bills'=>$bill
      ]);
  }
    }

    public function pageBookings($request,$response,$args){
      $params=$request->getQueryParams();
      $this->ci_db;
      $bookedUser=$this->ci->currentUser->user_name;

      $bookings=CookBooking::where('booked_by',$bookedUser)->get();

      return $this->ci->view->render($response, 'pages/cooking/bookings.html.twig',[
        'cook_name'=>$bookings['cook_name'],
        'mobile'=>$bookings['mobile'],
        'address'=>$bookings['address'],
        'created_at'=>$bookings['created_at'],
        'bookings'=>$bookings
      ]);

    }

  }
