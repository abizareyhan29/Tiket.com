<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class APIController extends Controller {
	public $token;

	public function __construct()
	{
		$this->getToken();
	}

	public function getToken()
	{
		\Session::put('token', '');
		if (session('token')=="") {
			$URL = env(env('API_ENV'));
			$curl = new \Curl\Curl();
			$curl->setUserAgent('twh.22537337;PROSOFT;');
			$curl->setopt(CURLOPT_SSL_VERIFYPEER, FALSE);
			$curl->get($URL."apiv1/payexpress", array(
				'method' => 'getToken',
				'secretkey' => env(env('API_KEY')),
				'output' => 'json'
			));
			if ($curl->error) {
				\Session::put('token', '');
				die("Error :". $curl->error_code);
			} else {
				$json = json_decode($curl->response);
				$this->token = $json->token;
				\Session::put('token', $json->token);
			}
			// echo session('token');
		} else {
			$this->token = \Session::get('token');
		}
	}

	public function getCurl($endpoint, $data = array())
	{
		$URL = env(env('API_ENV'));
		$curl = new \Curl\Curl();
		$curl->setUserAgent('twh.22537337;PROSOFT;');
		$curl->setopt(CURLOPT_SSL_VERIFYPEER, FALSE);
		$data+=array('output'=>'json', 'token' => $this->token);
		$curl->get($URL.$endpoint, $data);
		if ($curl->error) {
			die("Error :". $curl->error_code);
		} else {
			$json = json_decode($curl->response);
			// echo $json;
			// die();
			return $json;
		}
	}
}
