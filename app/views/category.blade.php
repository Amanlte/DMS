@extends('app')

@section('header')

@endsection

@section('content')
<div class="box box-primary">
    <div class="row">
      	<div class="col-xs-12">
             <form role="catForm" id="cat-form" action = "{{ URL::route('category-post') }}" method="post">
				<div class="box-body">
					<div class="col-xs-6">
				        <div class="box-header">
				        	<h4>Create A category</h4>
				        </div>
						<div id="postMessage"></div>
	                    <div class="form-group">
	                    	<label for="exampleInputEmail1">Name</label>
	                  		<input type="text" class="form-control" name="name" id="name" placeholder="Enter a name" required>
	                    </div>
		              <div class="box-footer pull-down">
		                <button type="submit" class="btn btn-primary" id="postCategotry">Add Category</button>
		              </div>
	        		</div>
	        		<div class="col-xs-6" style="border-left:solid #ededed 1px;">
	        			<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="category_lists">
	        				<thead>
	        					<th width="25%">Id</th><th>Category</th>
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

	var catTable = $('#category_lists').DataTable({
	    "ajax": {
	    	'url':'getCategory',
	    	'dataType':'json'
	    },
          "columns":[
            {"data":"id"},
            {"data":"category"}
          ]
    });

$('#postCategotry').on("click", function(e) { 
	e.preventDefault();
    var name = $('#name').val();
    $.ajax({
       type: "POST",
       url: '/DMS/add/category',
		cache: false,
       data: {"name": name },
       success: function(data) {
             // data is ur summary
            $('#postMessage').html(data);
            $('#name').val('');
            catTable.fnReloadAjax();
            catTable.fnDraw();
     }
   });
});
}); 

$(document).ready(function() {
	    $('#cat-form').bootstrapValidator({
	        message: 'This value is not valid',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	            name: {
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