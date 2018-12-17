@extends('app')

@section('header')
<div class="row">
</div>
@endsection

@section('content')
<!-- <div class="col-xs-12"> -->
    <div class="row">
      <div class="col-md-3">
        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Folders</h3>
            <div class="box-tools">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body" style="overflow:auto;">
              <div class="has-feedback">
                <input type="text" class="form-control input-sm" id="search_q" placeholder="Search Folder">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
              </div>
              <!-- <input type="text" name="search_q" class="form-control" placeholder="Enter a folder name" /> -->
              <div id="tree-container">
                  
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
          <div class="box box-primary">
              <div class="box-header">
                  <!-- <h3>Title Goes here</h3> -->
              </div>
              <div class="box-body">
                  <ul class="nav nav-tabs">
                      <li class="active"><a href="#doc_detail" data-toggle="tab">Document Detail</a></li>
                      <li><a href="#upload_document" data-toggle="tab">Upload Docuement</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="doc_detail">
                          <div class="row">
                          <br>
                              <div class="col-xs-12">
                                  <table class="table table-striped table-bordered" cellspacing="0" width="100%"  id="file_list">
                                      <thead>
                                        <th></th>
                                        <th>Document Name</th>
                                        <th>Author Name</th>
                                        <th>Date Publication</th>
                                        <th>Tag Words</th>
                                      </thead>
                                  </table>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="upload_document">
                          <div class="row">
                              <div class="col-xs-12">
                              <br />
                              <div class="breadcrumb" id="whereIn"></div>
                              <div id="postMessage"></div>
                              <form role="files" action = "{{ URL::route('document-upload') }}" method="post" style="cursor:pointer">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Document Name</label>
                                        <input type="text" name="document_name" id="document_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Author Name</label>
                                        <input type="text" name="document_name" id="author_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Date Publication</label>
                                        <input type="text" class="form-control" id="date_publication" name="date_publication" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask="">
                                    </div>
                                    <div class="form-group">
                                      <label>Document Category</label>
                                      <select class="form-control" id="document_category" placeholder="Select Document Category">
                                        <?php
                                          $cats = Category::all();
                                          foreach($cats as $cat) {
                                              echo "<option value='$cat->id'>$cat->category</option>";
                                          }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tag Words</label>
                                        <textarea class="form-control" id="tag_words"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Authorization Level</label>
                                        <select class="form-control" id="auth_level" name="auth_level">
                                          <option value="public">Public</option>
                                          <option value="private">Private</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>File Input</label>
                                        <input type="file" name="docs" id="docs" />
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                  <div class="box-footer">
                                      <button type="button" class="btn btn-primary pull-right" id="uploadDocument">Upload Document</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          </div>
                      </div>                    
                </div> <!-- tab ends here -->
              </div>
          </div>
      </div>
    </div>
    <div class="row">
    <!-- <div class="col-xs-3"></div> -->
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="box-tools pull-right">
                  <h3></h3>
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
          </div>
          <div class="box-body">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#propertise" data-toggle="tab">Propertise</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                  <br />
                  <div class="tab-pane active in" id="propertise">
                      <div class="row">
                          <div class="col-xs-12">
                              
                          </div>
                      </div>
                  </div>                   
            </div> <!-- tab ends here -->
          </div>
      </div>
      </div>
    </div>
    <!-- <div class="row">
        <div class="col-xs-12 ">
            <div class="box box-primary">
                <div class="box-body">
                    
                    <div class="">
                      
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<!-- </div> -->
@endsection

@section('footer')
<script type="text/javascript">

$(document).ready(function() {
  var id= "";
    $('#tree-container').on("select_node.jstree",function(e,data) {
      var id = data.node.id;
      var type = data.node.type;

      $('#file_list').dataTable().fnDestroy();
      var table = $('#file_list').DataTable({
          "processing":true,
          "serverSide":true,
          "ajax": {
            "url":"getFilesFor",
            "type":"POST",
            "data": {
                      "id":id,
                      "type":type
                    }
          },
          "columns":[
            {"data":"extension"},
            {"data":"document_name"},
            {"data":"author_name"},
            {"data":"date_publication"},
            {"data":"tag_words"}
          ]
      });

      $('#file_list tbody').on( 'click', 'tr', function () {

          var doc_name = table.cell(this, 1).data();

          $.ajax({
             type: "POST",
             url: '/DMS/Document/getDocumentURL',
             data: {'doc_name': doc_name}
             })  .done(function(data) {
                alert(data);
                $('#viewer').html(data);

          });

          $.ajax({
             type: "POST",
             url: '/DMS/Document/getDocumentDetail',
             data: {'doc_name': doc_name}
             })  .done(function(data) {
                $('#propertise').html(data);

           });


      }); 

      if(type != 'folder') { 
          
        $('#uploadDocument').prop('disabled', true);
      } else {
        $('#uploadDocument').prop('disabled', false);
      }
      //upload doc ...
        $("#uploadDocument").click(function(){

            var formData = new FormData();
            formData.append('file', $('#docs')[0].files[0]);
            formData.append('document_name', $('#document_name').val());
            formData.append('author_name', $('#author_name').val());
            formData.append('date_publication', $('#date_publication').val());
            formData.append('category_id', $('#document_category').val());
            formData.append('tag_words', $('#tag_words').val());
            formData.append('auth_level', $('#auth_level').val());
            formData.append('category_name', $('#document_category option:selected').text());
            formData.append('folder_in', id);
            formData.append('type', type);

            $.ajax({
                 type: "POST",
                 url: '/DMS/Document/upload',
                 data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                  

                })  .done(function(data) {
                        $('#postMessage').html(data);
                        $('#tree_menu').jstree('refresh');
               });

        });
    });
});

$(document).ready(function(){
    var to = false;
    $('#search_q').keyup(function () {
        if(to) { clearTimeout(to);}
        to = setTimeout(function () {
          var v = $('#search_q').val();
          $('#tree-container') .jstree(true).search(v);
        }, 250);
    });

    $('#tree-container').jstree({
        'core' : {
            'data' : {
                "url" : "getAllTreeNodes",
                'data' : function (node) {
                  return { 'id' : node.id };
                },
                "type": "POST",
                "dataType" : "json" // needed only if you do not supply JSON headers
            }
            ,'check_callback' : function (op, node, par, pos, more) {
                                  if(op === "delete_node") { 
                                    return confirm("Are you sure you want to delete?"); 
                                  } 
            },
            'themes': {
                'responsive': false,
                'stripes' : true
            },
          },
          'sort' : function(a, b) {
            return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
          },
          'contextmenu' : {
            'items' : function(node) {
              var tmp = $.jstree.defaults.contextmenu.items();
              delete tmp.create.action;
              tmp.create.label = "New";
              tmp.create.submenu = {
                "create_folder" : {
                  "separator_after" : true,
                  "label"       : "Folder",
                  "action"      : function (data) {
                    var inst = $.jstree.reference(data.reference),
                      obj = inst.get_node(data.reference);
                    inst.create_node(obj, { type : "default" }, "last", function (new_node) {
                      setTimeout(function () { inst.edit(new_node); },0);
                    });
                  }
                }
              };
              if(this.get_type(node) === "file") {
                delete tmp.create;
                delete tmp.ccp;
              } else if(this.get_type(node) === 'folder') {
                delete tmp.ccp;
              }
              return tmp;
            }
          },
          "types" : {
              "file" : {
                  "icon" : "glyphicon glyphicon-file"
              },
              "folder" : {
                  "icon" : "glyphicon glyphicon-folder-open"
              }
          },
          'unique' : {
            'duplicate' : function (name, counter) {
              return name + ' ' + counter;
            }
          },
      'plugins' : ["state","contextmenu","dnd","search","unique","types"]
    }).on('create_node.jstree', function (e, data) {
      $.post('operateTree', { 'id' : data.node.parent, 'position' : data.position,  'text' : data.node.text, 'operation' : 'create_node' })
        .done(function (d) {
          data.instance.set_id(data.node, d.id);
          data.instance.set_icon(data.node, "glyphicon glyphicon-folder-close");
        })
        .fail(function () {
          data.instance.refresh();
        });
    }).on('rename_node.jstree', function (e, data) {
      $.post('operateTree', { 'id' : data.node.id, 'text' : data.text, 'type' : data.node.type, 'operation' : 'rename_node' })
        .fail(function () {
          data.instance.refresh();
        });
    }).on('delete_node.jstree', function (e, data) {
      $.post('operateTree', { 'id' : data.node.id, 'type' : data.node.type, 'operation' : 'delete_node' })
         .done(function (d) {
          data.instance.refresh();
        })
         .fail(function () {
          data.instance.refresh();
        });
    });

    $('#tree-container').on('open_node.jstree', function (e, data) { data.instance.set_icon(data.node, "glyphicon glyphicon-folder-open"); });
    $('#tree-container').on('close_node.jstree', function (e, data) { data.instance.set_icon(data.node, "glyphicon glyphicon-folder-close"); });
    // $('#tree-container').jstree(options).on('loaded.jstree', function() {$('#tree-container').jstree('open_all');});
});
</script>
@endsection