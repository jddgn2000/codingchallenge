<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Sources</title>
    <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <link href="../../css/style.css" rel="stylesheet" type="text/css"/>
      <?php $this->load->view('header'); ?>
  <div class="container">
    <h1>Data Sources</h1>
</center>
    <h3>Data Source Catalog</h3>
    <br />
    <button class="btn btn-success" onclick="add_ds()"><i class="glyphicon glyphicon-plus"></i>Add Data Source</button>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
			<th>dsID</th>
			<th>Source</th>
                        <th>Url</th>
                        <th>Key1</th>
          <th style="width:150px;">Action
          </p></th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($sources as $sc){?>
				     <tr>
				         <td><?php echo $sc->dsID;?></td>
				         <td><?php echo $sc->source;?></td>
                                         <td><?php echo $sc->url;?></td>
                                         <td><?php echo $sc->key1;?></td>
						<td>
							<button class="btn btn-warning" onclick="edit_ds(<?php echo $sc->dsID;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
							<button class="btn btn-danger" disabled value="true" onclick="delete_ds(<?php echo $sc->dsID;?>)"><i class="glyphicon glyphicon-remove"></i></button>
                                                        <button class="btn btn-warning" ><a href="<?php echo site_url('index.php/Ds/setup/')?><?php echo $sc->dsID;?>"><i class="glyphicon glyphicon-list-alt"></i></button>
                                                </td>
				      </tr>
				     <?php }?>



      </tbody>

      <tfoot>
        <tr>
         <th>dsID</th>
         <th>Source</th>
         <th>Url</th>
         <th>Key1</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>
        <br />
        <button class="btn btn-success"><a href="<?php echo base_url('User/nav_menu'); ?>"><i class="glyphicon glyphicon-arrow-left"></i>Menú</a> </button>
        <br />
  </div>
      
    
    
  <script src="<?php echo base_url('assests/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assests/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assests/datatables/js/dataTables.bootstrap.js')?>"></script>


  <script type="text/javascript">
//  $(document).ready( function () {
//      $('#table_id').DataTable();
//      cargarGrados();
//      cargarMaestros();
//  } );
    var save_method; //for save method string
    var table;
    
//    function cargarMaestros(){
//      //Ajax Load data from ajax
//      $.ajax({
//        url : "<?php echo site_url('index.php/curso/cargar_maestros')?>",
//        type: "GET",
//        dataType: "JSON",
//        success: function(data)
//        {
//            $.each(data,function(key, registro) {
//                $("#maestro_obtener").append("<option value="+registro.maestroID+">"+registro.maestro+"</option>");
//            })
//
//        },
//        error: function (jqXHR, textStatus, errorThrown)
//        {
//            alert('Error get data from ajax');
//        }
//    });
//    }
//    
//    function cargarGrados(){
//      //Ajax Load data from ajax
//      $.ajax({
//        url : "<?php echo site_url('index.php/curso/cargar_grados')?>",
//        type: "GET",
//        dataType: "JSON",
//        success: function(data)
//        {
//            $.each(data,function(key, registro) {
//                $("#grado_obtener").append("<option value="+registro.gradoID+">"+registro.grado+"</option>");
//            })
//
//        },
//        error: function (jqXHR, textStatus, errorThrown)
//        {
//            alert('Error get data from ajax');
//        }
//    });
//    }
    
    function add_ds()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
    function edit_ds(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('index.php/ds/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="dsID"]').val(data.dsID);
            $('[name="source"]').val(data.source);
            $('[name="url"]').val(data.url);
            $('[name="key1"]').val(data.key1);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Ds'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }
    function save()
    {
//      if($(".validar").val()!= "")
//      {
        var url;
        if(save_method == 'add')
        {
            url = "<?php echo site_url('index.php/ds/ds_add') ?>";
        }
        else
        {
          url = "<?php echo site_url('index.php/ds/ds_update') ?>";
        }

         // ajax adding data to database
            $.ajax({
              url : url,
              type: "POST",
              data: $('#form').serialize(),
              dataType: "JSON",
              success: function(data)
              {
                 //if success close modal and reload ajax table
                 if(data.status){ //SI INSERTO
                      $('#modal_form').modal('hide');
                      location.reload();// for reload a page
                      alert('Register added successfully');
                 }
                 else{ //NO INSERTO
                      alert('Required Filds');
                 }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error adding / update data');
              }
          });
//       }
//       else
//       {
//        alert('Revisar datos requeridos');
//       }
    }

    function delete_ds(id)
    {
      if(confirm('Are you sure?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('index.php/ds/ds_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

      }
    }

  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Data Source Form </h3>
              </div>
              <div class="modal-body form">
                  <form action="#" id="form" class="form-horizontal">
                      <input type="hidden" value="" name="dsID"/>
                      <div class="form-body">
                              <div class="form-group">
                                  <input class="form-control" name="source" placeholder="Source" type="text" autofocus > 
                                  <input class="form-control" name="url" placeholder="Url" type="text" > 
                                  <input class="form-control" name="key1" placeholder="Key1" type="text" > 
                              </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
<?php $this->load->view('footer'); ?>
  </body>
  </html>
