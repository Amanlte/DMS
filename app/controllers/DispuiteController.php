<?php

class DispuiteController extends BaseController {

	public function index()
	{
		return View::make('dispuite');
	}

	public function postDispuiteType()
	{

		//save dispuit type
		$dispuiteType = new DispuiteType;
		if(isset($_POST['type']))
			$type = $_POST['type'];
		//dd($_POST['type']);
		$dispuiteType->type = $type;

		$dispuiteType->save();

		return    "	<div class='alert alert-success'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Success!</strong> Dispuit Type added successfully .
					</div>";

	}

	public function getDispuiteType() 
	{

		$dispuiteTypes = DispuiteType::all();
		$res = array_values($dispuiteTypes->toArray());

		$resVal["aaData"] = $res; 
		$resVal["sEcho"] = 1;
		$resVal["iTotalRecords"] = sizeof($res); 
		$resVal["iTotalDisplayRecords"] = sizeof($res);

		return json_encode($resVal);
			

	}

}
