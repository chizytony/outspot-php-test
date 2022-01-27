<?php

   require_once __DIR__ . '/FormController.php';

      $customer_name = '';
      $customer_email = '';
      $sender_name = '';
      $sender_email = '';
      $message = '';
      $sendInvitation = '';

   if(count($_POST) > 0) {
      $invite = new SendInvite();
      $errors = $invite->processInvite($_POST);

      extract($_POST);

      if(count($errors) == 0) {
         $sendInvitation = $invite->invite($_POST);
      };
   }
?>



<!doctype html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>OutSpot | Customer service review invitation</title>
      <script src="https://cdn.tailwindcss.com"></script>
   </head>
   <body class="bg-gray-200">
      <main class="justify-center flex my-10 items-center px-2">
         <section class="w-full max-w-2xl mx-auto">
            <h2 class="text-3xl font-semibold text-gray-800 py-8">Invite customer for review</h2>
            <div class="bg-white rounded-md shadow-md px-6 py-4">
               <form method="post" class="mt-3">
                  <p class="pb-4 mb-6 border-b border-gray-100 text-lg text-gray-500">Remember, all fields marked(*) are required</p>
                  <?php if(isset($errors) && is_array($errors) && count($errors) > 0): ?>
                     <div class="px-5 py-2 mb-5 font-semibold bg-red-400 border border-red-600 text-white rounded"><?= $errors[0] ?></div>
                  <?php elseif($sendInvitation == 'Something went wrong, please try again'): ?>
                     <div class="px-5 py-2 mb-5 font-semibold bg-red-400 border border-red-600 text-white rounded"><?= $sendInvitation ?></div>
                  <?php elseif($sendInvitation != ''):?>   
                     <div class="px-5 py-2 mb-5 font-semibold bg-green-400 border border-green-600 text-white rounded"><?= $sendInvitation ?></div>
                  <?php endif ?>
                  <div class="items-center -mx-2 md:flex">
                     <div class="w-full mx-2">
                        <label class="block mb-2 text-sm font-medium text-gray-600">Customer's full name <span class="text-red-600">*</span></label>
                        <input type="text" name="customer_name" value="<?= $customer_name ?>"
                           class="block w-full px-4 py-3 text-gray-700 bg-white border rounded-md focus:border-blue-400 focus:ring-blue-300 
                              focus:outline-none focus:ring focus:ring-opacity-40">
                     </div>

                     <div class="w-full mx-2 mt-4 md:mt-0">
                        <label class="block mb-2 text-sm font-medium text-gray-600">Customer's E-mail <span class="text-red-600">*</span></label>
                        <input type="email" name="customer_email" value="<?= $customer_email ?>"
                           class="block w-full px-4 py-3 text-gray-700 bg-white border rounded-md focus:border-blue-400 focus:ring-blue-300 
                           focus:outline-none focus:ring focus:ring-opacity-40">
                     </div>
                  </div>

                  <div class="items-center -mx-2 md:flex mt-4">
                     <div class="w-full mx-2">
                        <label class="block mb-2 text-sm font-medium text-gray-600">Sender's full name <span class="text-red-600">*</span></label>
                        <input type="text" name="sender_name" value="<?= $sender_name ?>"
                           class="block w-full px-4 py-3 text-gray-700 bg-white border rounded-md focus:border-blue-400 focus:ring-blue-300 
                           focus:outline-none focus:ring focus:ring-opacity-40">
                     </div>

                     <div class="w-full mx-2 mt-4 md:mt-0">
                        <label class="block mb-2 text-sm font-medium text-gray-600">Sender's E-mail <span class="text-red-600">*</span></label>
                        <input type="text" name="sender_email" value="<?= $sender_email ?>"
                           class="block w-full px-4 py-3 text-gray-700 bg-white border rounded-md focus:border-blue-400 focus:ring-blue-300 
                           focus:outline-none focus:ring focus:ring-opacity-40">
                     </div>
                  </div>

                  <!--div class="w-full mt-4">
                     <label class="block mb-2 text-sm font-medium text-gray-600">Additional message</label>
                     <textarea name="message"
                        class="block w-full h-40 px-4 py-2 text-gray-700 bg-white border rounded-md focus:border-blue-400 focus:outline-none 
                        focus:ring focus:ring-blue-300 focus:ring-opacity-40"><= $message ?></textarea>
                  </div-->

                  <div class="flex justify-start mt-8">
                     <button type="submit"
                        class="px-6 py-3 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none 
                        focus:bg-gray-600">Send Message</button>
                  </div>
               </form>
            </div>
         </section>
      </main>
   </body>
</html>