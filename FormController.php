<?php

   use GuzzleHttp\Client;
   
   require_once __DIR__ . '/vendor/autoload.php';

   $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
   $dotenv->load();

   class SendInvite 
   {
      /**
       * Catch and store errors and messages
       * 
       * @var array
       */
      private $message = array();

      /**
       * Process invitation form to customer
       * 
       */

      public function processInvite(array $inputs)
      {      

         try {
            if(isset($inputs)) {
               foreach ($inputs as $key => $input) {
                  $required_suffix = 'field is required';
                  $input = trim($input);
                  if($key == 'customer_name') {
                     if(empty($input)) {
                        $this->message[] = "Customer's fullname " . $required_suffix; 
                     }
                     if(preg_match("/[0-9]+/", $input)) {
                        $this->message[] = "Customer's fullname cannot contain numbers";
                     }
                  }
                  if($key == 'customer_email') {
                     if(empty(trim($input))) {
                        $this->message[] = "Customer's email " . $required_suffix; 
                     }
                     if(!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                        $this->message[] = "Customer's email is not valid";
                     }
                  }
                  if($key == 'sender_name') {
                     if(empty($input)) {
                        $this->message[] = "Sender's fullname " . $required_suffix; 
                     }
                     if(preg_match("/[0-9]+/", $input)) {
                        $this->message[] = "Sender's fullname cannot contain numbers";
                     }
                  }
                  if($key == 'sender_email') {
                     if(empty($input)) {
                        $this->message[] = "Sender's email " . $required_suffix; 
                     }
                     if(!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                        $this->message[] = "Senders's email is not valid";
                     }
                  }
               }
            } else {
               $this->message[] = "Something went wrong, please check all inputs";
            }
            
            return $this->message;
         } catch (Exception $e) {
            error_log($e->getMessage());
            return $this->message[] = "Something went wrong, please try again";
         }
      }

      public function invite(array $inputs)
      {
         try {
            
            $buisinessUnitId = $_ENV['TRUST_PILOT_BUSINESS_UNIT_ID'];
            $templateId = $_ENV['TRUST_PILOT_TEMPLATE_ID'];

            $client = new Client([
               'base_uri' => $_ENV['TRST_PILOT_BASE_URL'],
            ]);

            $requestData = [
               "replyTo" => "david.peeters@outspot.be",
               "locale" => "en-US",
               "senderName" => $inputs['sender_name'],
               "senderEmail" => $inputs['sender_email'],
               "locationId" => "ABC123",
               "referenceNumber" => "inv00001",
               "consumerName" => $inputs['customer_name'],
               "consumerEmail" => $inputs['customer_email'],
               "serviceReviewInvitation" => [
                  "templateId" => $templateId,
                  "preferredSendTime" => date("Y-m-d h:i:s", strtotime("now")),
                  "redirectUri" => "http://outspot.be",
                  "tags" => [
                     "tag1",
                     "tag2"
                  ]
               ],
            ];

            $response = $client->request('POST', $buisinessUnitId . '/email-invitations', ['form_params' => $requestData]);

            // request was successful
            // json_encode($requestData);
            return $this->message[] = "Invitation sent successfully";
         } catch (Exception $e) {
            error_log($e->getMessage());
            return $this->message[] = "Something went wrong, please try again";
         }         
      }
   }