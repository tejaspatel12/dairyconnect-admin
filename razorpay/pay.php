<?php

require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

$response=array();
    
$securecode=$_POST["securecode"];
$txnid=$_POST["txnid"];
$amount=$_POST["amount"];


// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => $txnid,
    'amount'          => $amount * 100, // 2000 rupees in paise
    // 'currency'        => 'INR',
     'currency'        => 'GBP',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$status = "yes";
$order_id = $razorpayOrderId;
$message = "Here is Order id";


 $response["status"]= $status;
 $response["message"]= $message;
 $response["order_id"]= $order_id;
 $response["keyId"]= $keyId;
 $response["keySecret"]= $keySecret;
 
 echo json_encode($response);
