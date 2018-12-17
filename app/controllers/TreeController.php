<?php

class TreeController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function operateTree()
	{
		//
		$result = null;
		if(isset($_POST['operation'])) {

		    switch($_POST['operation']) {
		      case 'create_node':
		      //dd($_POST['operation']);
		        $node = isset($_POST['id']) && $_POST['id'] !== '#' ? (int)$_POST['id'] : '#';
		        
		        $nodeText = isset($_POST['text']) && $_POST['text'] !== '' ? $_POST['text'] : '';

		        $folderId = Tree::max('id');
				 $fileId = LIFTDocuments::max('file_number');
				 $nextId = 0;

				 if($folderId > $fileId)
				 	$nextId = $folderId + 1;
				 else
				 	$nextId = $fileId + 1;
		        //dd($node.$nodeText);
		        $tbl_tree = new Tree;
		        $tbl_tree->id = $nextId;
		        $tbl_tree->parent = $node;
		        $tbl_tree->text = $nodeText;
		        $tbl_tree->save();

		        $result = array('id' => $tbl_tree->id);
		        
		        return $result;

		        break;
		      case 'rename_node':
		        $node = isset($_POST['id']) && $_POST['id'] !== '#' ? (int)$_POST['id'] : '#';

		        $nodeText = isset($_POST['text']) && $_POST['text'] !== '' ? $_POST['text'] : '';

		        $tbl_tree = Tree::where('id','=', $node)->update(array('text' => $nodeText));

		        break;
		      case 'delete_node':
		        $node = isset($_POST['id']) && $_POST['id'] !== '#' ? (int)$_POST['id'] : '#';
		        if(isset($_POST['type']))
		        	$type = $_POST['type'];

	        	if($type == 'folder') {
		        	$folder = Tree::where('id','=', $node)->update(array('is_deleted' => 1));
		        	$parent = Tree::where('parent','=', $node)->update(array('is_deleted' => 1));
		        	$file = LIFTDocuments::where('folder_in','=', $node)->update(array('is_deleted' => 1));
		        } else {
		        	$tbl_tree = LIFTDocuments::where('file_number','=', $node)->update(array('is_deleted' => 1));
		        }

		        break;
		      default:
		        throw new Exception('Unsupported operation: ' . $_POST['operation']);
		        break;
		    }
		    
	  }
	}

	public function getAllTreeNodes()
	{

		$get_trees = Tree::where('is_deleted','=', 0)->get()->toArray();
		$get_trees_icon = array();
		$i=0;
		foreach ($get_trees as $get_tree) {
			$get_tree["icon"] = 'glyphicon glyphicon-folder-close';
			$get_tree["type"] = 'folder';
			$get_trees_icon[$i] = $get_tree;
			$i++;
		}
		//get a files from lift_documents
		$get_files = LIFTDocuments::where('folder_in', '!=', '' )->where('is_deleted','=', 0)->select('file_number AS id','folder_in AS parent', 'document_name AS text')->get()->toArray();


		$get_files_icon = array();
		$i = 0;
		foreach ($get_files as $get_file) {
			$get_file["icon"] = 'glyphicon glyphicon-file';
			$get_file["type"] = 'file';
			$get_files_icon[$i] = $get_file;
			$i++;
		}

		//merge results
		$results = array_merge($get_trees_icon,$get_files_icon);

		return json_encode($results);
	}
}
