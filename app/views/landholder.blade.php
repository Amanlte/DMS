@extends('app')

@section('header')

@endsection

@section('content')
<div class="box box-primary">
    <div class="row">
      	<div class="col-xs-12">
             <form role="lhtForm" id="catForm" action = "{{ URL::route('land-holder-type-post') }}" method="post" data-toggle="validator">
				<div class="box-body">
					<div class="col-xs-5">
				        <div class="box-header">
				        	<h4>Create a Land Holder Type</h4>
				        </div>
						<div id="postMessage"></div>
	                    <div class="form-group">
	                    	<label for="exampleInputEmail1"></label>
	                  		<input type="text" class="form-control" name="type" id="type" placeholder="Enter a land holder type" required>
	                    </div>
		              <div class="box-footer pull-down">
		                <button type="button" class="btn btn-primary" id="postLandHolderType">Add Type</button>
		              </div>
	        		</div>
	        		<div class="col-xs-7" style="border-left:solid #ededed 1px;">
	        			<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="land_holder_lists">
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
	var dTable = $('#land_holder_lists').DataTable({
	    "ajax": {
	    	'url':'getLandHolderType',
	    	'dataType':'json'
	    },
          "columns":[
            {"data":"id"},
            {"data":"type"}
          ]
    });
});

$('#postLandHolderType').on("click", function() {

    var type = $('#type').val();
    $.ajax({
       type: "POST",
       url: '/LookUp/landHolderType',
		cache: false,
       data: {"type": type },
       success: function(data) {
             // data is ur summary
            $('#postMessage').html(data);
            $('#type').val('');
            
            $('#land_holder_lists').DataTable({
			    "ajax": {
			    	'url':'getLandHolderType',
			    	'dataType':'json'
			    },
		          "columns":[
		            {"data":"id"},
		            {"data":"type"}
		          ]
		    });
     }
   });
});


</script>
@endsection