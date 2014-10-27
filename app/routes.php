<?php
	
use Endroid\QrCode\QrCode;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::match(array('GET', 'POST'), '/', function(){

if(Input::has('submit')){
	$AccountSid = "AC248077508b8520426a8d0a27619d3a93";
	$AuthToken = "8d13609077ebce3135c691e6987e87f0";
	$client = new Services_Twilio($AccountSid, $AuthToken);

	$sms = $client->account->messages->sendMessage(
		"+16149024463",
		Input::get('phone_num'),
		"Congrats! Here is your ticket.",
		"http://seedmissions.com/qrcode?name=".urlencode(Input::get('name')) . "&phone_num=" . Input::get('phone_num')
		);
}

	return View::make('home');
});

Route::get('/qrcode', Function()
{
	$name = Input::get('name');
	$number = Input::get('phone_num');
	$code = base64_encode($name . $number);
	$QrCode = new QrCode();
	$QrCode->setText($code);
	$image = $QrCode->get();
	$response = Response::make(
		$image,
		 200
 	);

 	$response->header(
 		'content-type',
 		'image/png'
 	);

 return $response;

});
