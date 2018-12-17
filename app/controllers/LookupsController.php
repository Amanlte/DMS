<?php

class LookupsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Land Holder Type loopup starts here
	|--------------------------------------------------------------------------
	*/

	public function landholderType()
	{
		return View::make('landholder');
	}

	public function postLandHolderType()
	{

		//save category
		$landHolderType = new LandHolderType;
		if(isset($_POST['type']))
			$type = $_POST['type'];
		//dd($_POST['name']);
		$landHolderType->type = $type;

		$landHolderType->save();

		return    "	<div class='alert alert-success'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Success!</strong> Land Holder Type added successfully .
					</div>";

	}

	public function getLandHolderType() 
	{

		$landHolderTypes = LandHolderType::all();
		$res = array_values($landHolderTypes->toArray());

		$resVal["aaData"] = $res; 
		$resVal["sEcho"] = 1;
		$resVal["iTotalRecords"] = sizeof($res); 
		$resVal["iTotalDisplayRecords"] = sizeof($res);

		return json_encode($resVal);
			

	}

	/*
	|--------------------------------------------------------------------------
	| Land Holder Type loopup ends here
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| Dispute Type loopup starts here
	|--------------------------------------------------------------------------
	*/

	public function disputeType()
	{
		return View::make('dispute');
	}

	public function postDisputeType()
	{

		//save dispuit type
		$disputeType = new DisputeType;
		if(isset($_POST['type']))
			$type = $_POST['type'];
		//dd($_POST['type']);
		$disputeType->type = $type;

		$disputeType->save();

		return    "	<div class='alert alert-success'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Success!</strong> Dispuit Type added successfully .
					</div>";

	}

	public function getDisputeType() 
	{

		$disputeTypes = DisputeType::all();
		$res = array_values($disputeTypes->toArray());

		$resVal["aaData"] = $res; 
		$resVal["sEcho"] = 1;
		$resVal["iTotalRecords"] = sizeof($res); 
		$resVal["iTotalDisplayRecords"] = sizeof($res);

		return json_encode($resVal);
			

	}

	/*
	|--------------------------------------------------------------------------
	| Dispute Type loopup starts here
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| Zone loopup starts here
	|--------------------------------------------------------------------------
	*/

	public function Zone()
	{
		return View::make('zone');
	}

	public function postZone()
	{

		//save category
		$zone = new Zone;
		
		if($_POST['zone_name'] == '' && $_POST['zone_code'] == '') {
			echo   "<div class='alert alert-danger'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Error!</strong> The fileds required .
					</div>";
		} else {
			if(isset($_POST['zone_name']) && isset($_POST['zone_code'])) {
				$zone_name = $_POST['zone_name'];
				$zone_code = $_POST['zone_code'];
			} 
			
			$zone->zone_name = $zone_name;
			$zone->zone_code = $zone_code;

			$zone->save();

			return    "	<div class='alert alert-success'>
	  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
	  					<strong>Success!</strong> Zone added successfully .
						</div>";
		}
		
	}

	public function getZone() 
	{

		$zone = Zone::all();
		$res = array_values($zone->toArray());

		$resVal["aaData"] = $res; 
		$resVal["sEcho"] = 1;
		$resVal["iTotalRecords"] = sizeof($res); 
		$resVal["iTotalDisplayRecords"] = sizeof($res);

		return json_encode($resVal);
			

	}

	/*
	|--------------------------------------------------------------------------
	| Zone loopup ends here
	|--------------------------------------------------------------------------
	*/
}
