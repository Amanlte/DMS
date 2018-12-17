@extends('app')

@section('header')

@endsection

@section('content')
<div class="box box-primary">
    <div class="row">
      	<div class="col-xs-12">
             <form id="lookupForm" action = "{{ URL::route('zone-post') }}" method="post">
				<div class="box-body">
					<div class="col-xs-4">
				        <div class="box-header">
				        	<h4>Create A category</h4>
				        </div>
						<div id="postMessage"></div>
	                    <div class="form-group">
	                    	<label for="exampleInputEmail1">Zone Name</label>
	                  		<input type="text" class="form-control" name="zone_name" id="zone_name" placeholder="Enter a name" required>
	                    </div>
	                    <div class="form-group">
	                    	<label for="exampleInputEmail1">Zone Code</label>
	                  		<input type="text" class="form-control" name="zone_code" id="zone_code" placeholder="Enter a code" required>
	                    </div>
		              <div class="box-footer pull-down">
		                <button type="submit" class="btn btn-primary" id="postZone">Add Zone</button>
		              </div>
	        		</div>
	        		<div class="col-xs-8" style="border-left:solid #ededed 1px;">
	        			<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="zone_lists">
	        				<thead>
	        					<th width="25%">Id</th><th>Zone Name</th><th>Zone Code</th>
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

	var catTable = $('#zone_lists').DataTable({
	    "ajax": {
	    	'url':'getZone',
	    	'dataType':'json'
	    },
          "columns":[
            {"data":"id"},
            {"data":"zone_name"},
            {"data":"zone_code"}
          ]
    });

// $('#postZone').on("click", function(e) { 
// 	e.preventDefault();
//     var name = $('#zone_name').val();
//     var code = $('#zone_code').val();
//     $.ajax({
//        type: "POST",
//        url: 'LookUp/Zone',
// 		cache: false,
//        data: {
//        			"zone_name": name,
//        			"zone_code" : code
//        		 },
//        success: function(data) {
//              // data is ur summary
//             $('#postMessage').html(data);
//             $('#zone_name').val('');
//             $('#zone_code').val('');
//      }
//    });
// });
}); 

$(document).ready(function() {
	    $('#lookupForm').bootstrapValidator({
	        message: 'This value is not valid',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        submitHandler: function(form) {
	            var name = $('#zone_name').val();
			    var code = $('#zone_code').val();
			    $.ajax({
			       type: "POST",
			       url: 'LookUp/Zone',
					cache: false,
			       data: {
			       			"zone_name": name,
			       			"zone_code" : code
			       		 },
			       success: function(data) {
			             // data is ur summary
			            $('#postMessage').html(data);
			            $('#zone_name').val('');
			            $('#zone_code').val('');
			     }
			   });
			   return false;
	        },
	        fields: {
	            zone_name: {
	                validators: {
	                    notEmpty: {
	                        message: 'The field is required'
	                    }
	                }
	            },
	            zone_code: {
	                validators: {
	                    notEmpty: {
	                        message: 'The field is required'
	                    }
	                }
	            }
	        }
	    });
});
</script>
@endsection