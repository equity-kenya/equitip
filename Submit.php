<?php
$merchantreference = rand(1, 1000000000000000000);
$callbackurl = 'https://equity-kenya.github.io/equity/index.html'
//$branch = "Equity main"//
$ipn_id = "051d7fa9-c1b9-4289-8127-dd9d2673de5f";
// Retrieve form data
$amount = '100';
$phone = '0793381357';
//$first_name = $_POST['first_name'];//
//$last_name = $_POST['last_name'];//
//$middle_name = $_POST['middle_name'];//
//$email_address = $_POST['email_address'];//

if(APP_ENVIROMENT == 'sandbox'){
  $submitOrderUrl = "https://cybqa.pesapal.com/pesapalv3/api/Transactions/SubmitOrderRequest";
}elseif(APP_ENVIROMENT == 'live'){
  $submitOrderUrl = "https://pay.pesapal.com/v3/api/Transactions/SubmitOrderRequest";
}else{
  echo "Invalid APP_ENVIROMENT";
  exit;
}
$headers = array(
    "Accept: application/json",
    "Content-Type: application/json",
    "Authorization: Bearer $token"
);

// Request payload
$data = array(
    "id" => "$merchantreference",
    "currency" => "KES",
    "amount" => $amount,
    "description" => "Payment description goes here",
    "callback_url" => "$callbackurl",
    "notification_id" => "$ipn_id",
    //"branch" => "$branch",//
    "billing_address" => array(
        "email_address" => "$email_address",
        "phone_number" => "$phone",
        "country_code" => "KE",
        //"first_name" => "$first_name",//
       // "middle_name" => "$middle_name",//
      //"last_name" => "$last_name",//
        "line_1" => "Pesapal Limited",
        "line_2" => "",
        "city" => "",
        "state" => "",
        "postal_code" => "",
        "zip_code" => ""
    )
);
$ch = curl_init($submitOrderUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo $response = curl_exec($ch);
$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
?>
