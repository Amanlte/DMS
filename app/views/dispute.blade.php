@extends('app')

@section('header')

@endsection

@section('content')
<div class="box box-primary">
    <div class="row">
      	<div class="col-xs-12">
             <form role="dtForm" id="catForm" action = "{{ URL::route('dispuite-type-post') }}" method="post" data-toggle="validator">
				<div class="box-body">
					<div class="col-xs-6">
				        <div class="box-header">
				        	<h4>Create a Dispuite Type</h4>
				        </div>
						<div id="postMessage"></div>
	                    <div class="form-group">
	                    	<label for="exampleInputEmail1">Type</label>
	                  		<input type="text" class="form-control" name="type" id="type" placeholder="Enter a dispuite type" required>
	                    </div>
		              <div class="box-footer pull-down">
		                <button type="button" class="btn btn-primary" id="postDispuiteType">Add Type</button>
		              </div>
	        		</div>
	        		<div class="col-xs-6" style="border-left:solid #ededed 1px;">
	        			<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dispuite_type_lists">
	        				<thead>
	        					<th width="25%">Id</th><th>Type</th>
	        				</thead>
	        			</table>
	        		</div>
        		</div>
            </form>
    	</div>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript">

$(document).ready(function(){
	var catTable = $('#dispuite_type_lists').DataTable({
	    "ajax": {
	    	'url':'getDispuiteType',
	    	'dataType':'json'
	    },
          "columns":[
            {"data":"id"},
            {"data":"type"}
          ]
    });
});

$('#postDispuiteType').on("click", function() {
	$('catForm').validator();
    var type = $('#type').val();
    $.ajax({
       type: "POST",
       url: '/DMS/add/dispuiteType',
		cache: false,
       data: {"type": type },
       success: function(data) {
             // data is ur summary
            $('#postMessage').html(data);
            $('#type').val('');
            catTable.fnReloadAjax();
            catTable.fnDraw();
     }
   });
});

// var editor; // use a global for the submit and return data rendering in the examples
 
// $(document).ready(function() {
//     editor = new $.fn.dataTable.Editor( {
//         ajax: "getCategory",
//         table: "#category_lists",
//         fields: [ 
//         	{
//                 label: "Id:",
//                 type: "id"
//             }, {
//                 label: "Category:",
//                 type: "category"
//             }
//         ]
//     } );
 
//     var table = $('#category_lists').DataTable( {
//         lengthChange: false,
//         ajax: "",
//         columns: [
//             { data: "id" },
//             { data: "category" }
//         ],
//         select: true
//     } );
 
//     // Display the buttons
//     new $.fn.dataTable.Buttons( table, [
//         { extend: "create", editor: editor },
//         { extend: "edit",   editor: editor },
//         { extend: "remove", editor: editor }
//     ] );
 
//     table.buttons().container()
//         .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
// } );
</script>
@endsection