<?php

class CategoryController extends \BaseController {

	public function index()
	{
		return View::make('category');
	}

	public function postCategory()
	{

		//save category
		$docCategory = new Category;
		if(isset($_POST['name']))
			$catName = $_POST['name'];
		//dd($_POST['name']);
		$docCategory->category = $catName;

		$docCategory->save();

		return    "	<div class='alert alert-success'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Success!</strong> Category added successfully .
					</div>";

	}

	public function getCategory() 
	{

		$categories = Category::all();
		$res = array_values($categories->toArray());

		$resVal["aaData"] = $res; 
		$resVal["sEcho"] = 1;
		$resVal["iTotalRecords"] = sizeof($res); 
		$resVal["iTotalDisplayRecords"] = sizeof($res);

		return json_encode($resVal);
			

	}

	public function updateCategory() 
	{
		if(isset($_POST['category']))
			$category = $_POST['category'];

		dd($category);
	}

}
