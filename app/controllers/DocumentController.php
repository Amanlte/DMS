<?php

class DocumentController extends BaseController {

	public  function getFilesFor()
	{
		if(isset($_POST['id']) && isset($_POST['type'])) {
			$id = $_POST['id'];
			$type = $_POST['type'];
		}

		$files = null;
		if($type == 'file')
			$files = LIFTDocuments::where('file_number','=',$id)->select('document_name','author_name','date_publication','tag_words','extension')->get();
		else 
			$files = LIFTDocuments::where('folder_in','=',$id)->select('document_name','author_name','date_publication','tag_words','extension')->get();

		foreach ($files as $key => $file) {

			if($file['extension'] == 'pdf') {
				$files[$key]['extension'] = '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red;"></i>';
			} elseif ($file['extension'] == 'doc' || $file['extension'] == 'docx') {
				$files[$key]['extension'] = '<i class="fa fa-file-word-o" style="font-size:24px;color:lightblue;"></i>';
			} elseif ($file['extension'] == 'xls' || $file['extension'] == 'xlsx') {
				$files[$key]['extension'] = '<i class="fa fa-file-excel-o" style="font-size:24px;color:#005a31;"></i>';
			}
		}

		$res = array_values($files->toArray());

		$resVal["aaData"] = $res; 
		$resVal["sEcho"] = 1;
		$resVal["iTotalRecords"] = sizeof($res); 
		$resVal["iTotalDisplayRecords"] = sizeof($res);

		return json_encode($resVal);
	}

	public function uploadDocument() 
	{

		$document_name = $_POST['document_name'];
		$author_name = $_POST['author_name'];
		$date_publication = $_POST['date_publication'];
		$date_uploaded = date('Y-m-d');
		$category_id = $_POST['category_id'];
		$tag_words = $_POST['tag_words'];
		$category_name = $_POST['category_name'];
		$autorization_type = $_POST['auth_level'];
		$folder_in = $_POST['folder_in'];
		$uploaded_by = 'Yonatan';
		$node_type = $_POST['type'];
		  $fileName =$_FILES['file']['name'];
		  $extension = pathinfo($fileName, PATHINFO_EXTENSION);
   		$destinationPath = storage_path() . "/DMS/".$category_name."/";
   		//dd($destinationPath);
		   $target_file = $destinationPath . $document_name.".". $extension;
		 
		  $uploadOk = 1;

		  if(!File::exists($destinationPath)) {
			    File::makeDirectory($destinationPath);
			}

		  if (file_exists($target_file)) {

		     echo "<div class='alert alert-danger'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Error! </strong>Sorry, file already exists.
					</div>";
		     $uploadOk = 0;
		  }

		  // Allow certain file formats
		 if($extension != "pdf" && $extension != "doc" && $extension != "docx" && $extension != "xlsx" && $extension != "xls") {

		      echo "<div class='alert alert-danger'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Error! </strong>Document format not supported(.pdf,.doc,.docx,.xls,.xlsx).
					</div>";
		      $uploadOk = 0;
		 }
		 if ($_FILES["file"]["size"] > 500000) {
		     echo "<div class='alert alert-danger'>
  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  					<strong>Error! </strong>Sorry, your file is too large.
					</div>";
		     $uploadOk = 0;
		 }

		 //get next id of file number
		 $folderId = Tree::max('id');
		 $fileId = LIFTDocuments::max('file_number');
		 $nextId = 0;

		 if($folderId > $fileId)
		 	$nextId = $folderId + 1;
		 else
		 	$nextId = $fileId + 1;

		  if ($uploadOk == 1 && $node_type != 'file') {
		   $tmp_name = $_FILES["file"]["tmp_name"];
		         $name = $_FILES["file"]["name"];
		        
		   
		       if ( move_uploaded_file($tmp_name, $target_file)){

		           $docUpload = new LIFTDocuments;

		           $docUpload->document_name = $document_name;
		           $docUpload->author_name = $author_name;
		           $docUpload->date_publication = $date_publication;
		           $docUpload->date_uploaded = $date_uploaded;
		           $docUpload->tag_words = $tag_words;
		           $docUpload->size = $_FILES["file"]["size"];
		           $docUpload->file_number = $nextId;
		           $docUpload->extension = $extension;
		           $docUpload->document_category_id = $category_id;
		           $docUpload->autorization_type = $autorization_type;
		           $docUpload->uploaded_by = $uploaded_by;
		           $docUpload->folder_in = $folder_in;
		           $docUpload->file_number = $nextId;

		           $docUpload->save();

		           echo  	"<div class='alert alert-success'>
		  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		  					<strong>Success!</strong> The document is uploaded Successfully .
							</div>";
		         }
		         else {
		           echo "<div class='alert alert-success'>
	  					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
	  					<strong>Success!</strong>Sorry, there was an error uploading your file.
						</div>";
		         }
		     }
 
	}

	public function getDocumentDetail()
	{
		if($_POST['doc_name'])
			$doc_name = $_POST['doc_name'];

		$getDetail = LIFTDocuments::where('document_name','=',$doc_name)->get();
		$filePath = storage_path('app')."/DMS/".$this->getDocumentCategory($getDetail[0]['document_category_id'])."/";

		echo '<div class="col-xs-12">'.
				'<div class="col-xs-6">'.
					'<div class="inline-group">'.
						'<label>Autorization Level : </label><label style="font-weight:normal;"> '.ucwords($getDetail[0]['autorization_type']).'</label>'.
					'</div>'.
					'<div class="inline-group">'.
						'<label>Date Uploaded : </label><label style="font-weight:normal;"> '.$getDetail[0]['date_uploaded'].'</label>'.
					'</div>'.
					'<div class="inline-group">'.
						'<label>Uploaded By : </label><label style="font-weight:normal;"> '.ucwords($getDetail[0]['autorization_type']).'</label>'.
					'</div>'.
				'</div>'.
				'<div class="col-xs-6">'.
					'<div class="inline-group">'.
						'<label>Documetn Category : </label><label style="font-weight:normal;"> '.$this->getDocumentCategory($getDetail[0]['document_category_id']).'</label>'.
					'</div>'.
					'<div class="inline-group">'.
						'<label>File Size : </label><label style="font-weight:normal;"> '.$this->formatSizeUnits($getDetail[0]['size']).'</label>'.
					'</div>'.
					'<div class="inline-group">'.
						'<label>File Extension : </label><label style="font-weight:normal;"> '.strtoupper($getDetail[0]['extension']).'</label>'.
					'</div>'.
					'<div class="inline-group">'.
						'<label>Download Link : </label><a href="'.$filePath.$getDetail[0]['document_name'].'.'.$getDetail[0]["extension"].'"> '.ucwords($getDetail[0]["document_name"]).'.'.$getDetail[0]["extension"].'</a>'.
					'</div>'.					
				'</div>'.
			'</div>';
	}

	public function getDocumentURL()
	{
		if($_POST['doc_name'])
			$doc_name = $_POST['doc_name'];

		$getDetail = LIFTDocuments::where('document_name','=',$doc_name)->get();
		$filePath = storage_path('app')."/DMS/".$this->getDocumentCategory($getDetail[0]['document_category_id'])."/".$filePath.$getDetail[0]['document_name'].".".$getDetail[0]["extension"];

		return Response::download($filePath);
	}

	public function getDocumentCategory($id)
	{
		$category = Category::where('id','=', $id)->select('category')->get();

		return $category[0]['category'];
	}

	public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}


}
