<?php

global $app;

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex');
$app->get('/about', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageAbout');
$app->post('/account/register/services','UserFrosting\Sprinkle\Site\Controller\FormController:ServiceRegister');

$app->get('/cooking', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageCooking')
    ->add('authGuard');

    //  $app->get('/cooking/all', 'UserFrosting\Sprinkle\Site\Controller\FormController:getCooking');

  //  $app->post('/cookingform', 'UserFrosting\Sprinkle\Site\Controller\FormController:formCooking');

  //->get('/cooking/book', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageCookingbooking')
      $app->get('/cooking/book', 'UserFrosting\Sprinkle\Site\Controller\FormController:getCooking')
      ->add('authGuard');

      $app->post('/cooking/book/confirmation','UserFrosting\Sprinkle\Site\Controller\FormController:getConfirmCooking')
      ->add('authGuard');

      $app->get('/cooking/cancellation','UserFrosting\Sprinkle\Site\Controller\FormController:getCancellation')
      ->add('authGuard');

      $app->get('/cooking/cancellation/confirmation','UserFrosting\Sprinkle\Site\Controller\FormController:getCancelConfirmation')
      ->add('authGuard');

      $app->get('/cooking/bill', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageBill')
          ->add('authGuard');

        $app->get('/cooking/bookings','UserFrosting\Sprinkle\Site\Controller\PageController:pageBookings')
            ->add('authGuard');

          $app->get('/cooking/all', 'UserFrosting\Sprinkle\Site\Controller\FormController:getCookingSearch')
              ->add('authGuard');

              $app->get('/cleaning/all', 'UserFrosting\Sprinkle\Site\Controller\CleaningController:getCleaningSearch')
                  ->add('authGuard');

                  $app->get('/driving/all', 'UserFrosting\Sprinkle\Site\Controller\DriversController:getDrivingSearch')
                      ->add('authGuard');

                      $app->get('/changeavailability', 'UserFrosting\Sprinkle\Site\Controller\FormController:getChangeAvailability')
                      ->add('authGuard');

      $app->get('/confirmavailability','UserFrosting\Sprinkle\Site\Controller\FormController:getConfirmavailability')
          ->add('authGuard');

          $app->get('/cleaning', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageCleaning')
              ->add('authGuard');

        $app->get('/cleaning/book', 'UserFrosting\Sprinkle\Site\Controller\CleaningController:getCleaning')
          ->add('authGuard');

          $app->get('/cleaning/book/confirmation', 'UserFrosting\Sprinkle\Site\Controller\CleaningController:getConfirmCleaning')
            ->add('authGuard');

            $app->get('/cleaning/cancellation', 'UserFrosting\Sprinkle\Site\Controller\CleaningController:getCancellation')
              ->add('authGuard');

              $app->get('/cleaning/cancellation/confirmation','UserFrosting\Sprinkle\Site\Controller\CleaningController:getCancelConfirmation')
              ->add('authGuard');

              $app->get('/cleaning/bookings','UserFrosting\Sprinkle\Site\Controller\CleaningController:getBookings')
                  ->add('authGuard');

                  $app->get('/cleaning/bill', 'UserFrosting\Sprinkle\Site\Controller\CleaningController:getBill')
                      ->add('authGuard');

                      $app->get('/driving', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageDriving')
                          ->add('authGuard');

                      $app->get('/driving/book', 'UserFrosting\Sprinkle\Site\Controller\DriversController:getDriving')
                        ->add('authGuard');

                        $app->get('/driving/book/confirmation', 'UserFrosting\Sprinkle\Site\Controller\DriversController:getConfirmDriving')
                          ->add('authGuard');

                          $app->get('/driving/cancellation', 'UserFrosting\Sprinkle\Site\Controller\DriversController:getCancellation')
                            ->add('authGuard');

                            $app->get('/driving/cancellation/confirmation','UserFrosting\Sprinkle\Site\Controller\DriversController:getCancelConfirmation')
                            ->add('authGuard');

                            $app->get('/driving/bookings','UserFrosting\Sprinkle\Site\Controller\DriversController:getBookings')
                                ->add('authGuard');

                                $app->get('/driving/bill', 'UserFrosting\Sprinkle\Site\Controller\DriversController:getBill')
                                    ->add('authGuard');
