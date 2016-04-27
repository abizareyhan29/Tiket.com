<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\API\APIController as API;

class HomeController extends Controller {
	public function get_Currency()
	{
		$api = new API;
		$hasil = $api->getCurl('general_api/listCurrency');
		\App\Currency::whereRaw('id>0')->delete();
		$data = array();
		foreach ($hasil->result as $key) {
			$curr = new \App\Currency;
			$curr->code = $key->code;
			$curr->name = $key->name;
			$curr->save();
			$data['id'][$curr->id] = $key->code;
		}

		echo json_encode(
			array(
				'status_code'=>200,
				'insert_data'=>sizeof($data['id'])
			)
		);
	}

	public function get_Lang()
	{
		$api = new API;
		$hasil = $api->getCurl('general_api/listLanguage');
		// print_r($hasil);
		\App\Lang::whereRaw('id>0')->delete();
		$data = array();
		foreach ($hasil->result as $key) {
			$lang = new \App\Lang;
			$lang->code = $key->code;
			$lang->name_long = $key->name_long;
			$lang->name_short = $key->name_short;
			$lang->save();
			$data['id'][$lang->id] = $key->code;
		}

		echo json_encode(
			array(
				'status_code'	=> 200,
				'inserted_data'	=> sizeof($data['id'])
			)
		);
	}

	public function get_Country()
	{
		$api = new API;
		$hasil = $api->getCurl('general_api/listCountry');
		\App\Country::whereRaw('id>0')->delete();
		$data = array();
		foreach ($hasil->listCountry as $key) {
			$ctr = new \App\Country;
			$ctr->country_id = $key->country_id;
			$ctr->country_name = $key->country_name;
			$ctr->country_areacode = $key->country_areacode;
			$ctr->save();
			$data['id'][$ctr->id] = $key->country_id;
		}

		echo json_encode(
			array(
				'status_code'	=> 200,
				'inserted_data'	=> sizeof($data['id'])
			)
		);
	}

	public function view_Currency()
	{
		$s['data'] = \App\Currency::all();
		return view('master.currency')->with($s);
	}

	public function view_Lang()
	{
		$s['data'] = \App\Lang::all();
		return view('master.lang')->with($s);
	}

	public function view_Country()
	{
		$s['data'] = \App\Country::all();
		return view('master.country')->with($s);
	}
}
