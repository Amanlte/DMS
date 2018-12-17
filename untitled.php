@extends('app')

@section('header')
<!-- <div class="row"> -->
    <div class="box box-primary">
        <div class="box-body">
            body goes here
        </div>
    </div>
<!-- </div> -->
@endsection

@section('content')
<!-- <div class="col-xs-12"> -->
    <div class="row">
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-header">
            <input type="text" name="search_q" id="search_q" />
          </div>
          <div id="tree-container" class="box-body" style="overflow:auto;">

          </div>
        </div>
      </div>
      <div class="col-md-9">
          <div class="box box-primary">
              <div class="box-header">
                  <h3>Title Goes here</h3>
              </div>
              <div class="box-body">
                  
              </div>
          </div>
      </div>
    </div>
<!-- </div> -->
@endsection

@section('footer')

<!-- jsTree
<script src="{{ asset('/dist/js/jquery-1.8.2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/dist/js/jstree.min.js') }}" type="text/javascript"></script> -->
<script type="text/javascript">

$(document).ready(function(){ 
    //fill data to tree  with AJAX call
    $('#tree-container').jstree({
        'core' : {
            'data' : {
                "url" : "getAllTreeNodes",
                'data' : function (node) {
                    return { 'id' : node.id };
                },
                "type": "POST",
                "dataType" : "json" // needed only if you do not supply JSON headers
            },
            'check_callback' : function(o, n, p, i, m) {
              if(m && m.dnd && m.pos !== 'i') { return false; }
              if(o === "move_node" || o === "copy_node") {
                if(this.get_node(n).parent === this.get_node(p).id) { return false; }
              }
              return true;
            },
            'themes': {
                'name': 'proton',
                'responsive': true
            }
        },
        'unique' : {
          'duplicate' : function (name, counter) {
            return name + ' ' + counter;
          }
        },
      'plugins' : ["state","contextmenu","dnd","search", "unique"]
    }).on('create_node.jstree', function (e, data) {
          $.post('operateTree', { 'id' : data.node.parent, 'text' : data.node.text, 'operation' : 'create_node' })
            .done(function (d) {
              data.instance.set_id(data.node, d.id);
            })
            .fail(function () {
              data.instance.refresh();
            });
        }).on('rename_node.jstree', function (e, data) {
          $.post('operateTree', { 'rid' : data.node.id, 'text' : data.text, 'operation' : 'rename_node' })
            .fail(function () {
              data.instance.refresh();
            });
        }).on('delete_node.jstree', function (e, data) {
          $.post('operateTree', { 'did' : data.node.id, 'operation' : 'delete_node' })
            .fail(function () {
              data.instance.refresh();
            });
        })
        ; 
        var to = false;
        $('#search_q').keyup(function () {
            if(to) { clearTimeout(to);}
            to = setTimeout(function () {
              var v = $('#search_q').val();
              $('#tree-container') .jstree(true).search(v);
            }, 250);
        });
});
</script>
@endsection