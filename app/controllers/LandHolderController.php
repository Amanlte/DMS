<?php

class LandHolderController extends BaseController {

	public function landHolderType()
	{
		$view =  View::make('landholder');

		if(Request::ajax()) {
	        $sections = $view->renderSections(); // returns an associative array of 'content', 'head' and 'footer'

	        return $sections['content'].$sections['content']; // this will only return whats in the content section

	    }

	    // just a regular request so return the whole view

	    return $view;
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

}
