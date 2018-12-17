<?php

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

Route::get('/', function()
{
	
	return View::make('index');
});

Route::get('/hello', "TreeController@getAllTreeNodes");

Route::post('getAllTreeNodes', "TreeController@getAllTreeNodes");

Route::post('operateTree', "TreeController@operateTree");

Route::post('getFilesFor', "DocumentController@getFilesFor");

Route::get('category', "CategoryController@index");

Route::get('getCategory', "CategoryController@getCategory");

Route::get('updateCategory', "CategoryController@updateCategory");

Route::post('/DMS/add/category', array (
    'as'=>'category-post',
    'uses'=>'CategoryController@postCategory'
));

Route::post('/DMS/Document/upload', array (
    'as'=>'document-upload',
    'uses'=>'DocumentController@uploadDocument'
));

Route::post('/DMS/Document/getDocumentDetail', array (
    'as'=>'document-detail',
    'uses'=>'DocumentController@getDocumentDetail'
));

Route::post('/DMS/Document/getDocumentURL', array (
    'as'=>'document-url',
    'uses'=>'DocumentController@getDocumentURL'
));

// lookups route 

Route::post('/LookUp/disputeType', array (
    'as'=>'dispute-type-post',
    'uses'=>'LookupsController@postDisputeType'
));

Route::get('DisputeType', "LookupsController@disputeType");

Route::get('getDisputeType', "LookupsController@getDisputeType");

Route::post('/LookUp/landHolderType', array (
    'as'=>'land-holder-type-post',
    'uses'=>'LookupsController@postLandHolderType'
));

Route::post('/Lookup/landholderType/', "LandHolderController@landHolderType");

Route::get('getLandHolderType', "LookupsController@getLandHolderType");

Route::post('/LookUp/Zone', array (
    'as'=>'zone-post',
    'uses'=>'LookupsController@postZone'
));

Route::get('Zone', "LookupsController@Zone");

Route::get('getZone', "LookupsController@getZone");
