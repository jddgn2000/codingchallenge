<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Implementation</title>
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
    <h1>Books API</h1>
</center>
    <h3>Get Best Sellers list names.</h3>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
			<th>List_name</th>
			<th>Display_name</th>
                        <th>List_name_encoded</th>
                        <th>Oldest_published_date</th>
                        <th>Newest_published_date</th>
                        <th>updated</th>
        </tr>
      </thead>
      <tbody>
                                
				<?php 
//                                        var_dump($data); exit; 
                                        foreach($data['results'] as $variable){?>
				     <tr>
                                         <td><?php echo $variable['list_name'];?></td>
				         <td><?php echo $variable['display_name'];?></td>
                                         <td><?php echo $variable['list_name_encoded'];?></td>
                                         <td><?php echo $variable['oldest_published_date'];?></td>
                                         <td><?php echo $variable['newest_published_date'];?></td>
                                         <td><?php echo $variable['updated'];?></td>
				      </tr>
				     <?php }?>
      </tbody>

      <tfoot>
        <tr>
			<th>list_name</th>
			<th>display_name</th>
                        <th>list_name_encoded</th>
                        <th>oldest_published_date</th>
                        <th>newest_published_date</th>
                        <th>updated</th>
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
  $(document).ready( function () {
      $('#table_id').DataTable();
  } );
    var save_method; //for save method string
    var table;
   
    function add_api()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
    function edit_api(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('index.php/api/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="methodID"]').val(data.methodID);
            $('[name="desc"]').val(data.desc);
            $('[name="http"]').val(data.http);
            $('[name="dsID"]').val(data.dsID);

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
            url = "<?php echo site_url('index.php/api/api_add') ?>";
        }
        else
        {
          url = "<?php echo site_url('index.php/api/api_update') ?>";
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

    function delete_api(id)
    {
      if(confirm('Are you sure?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('index.php/api/api_delete')?>/"+id,
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
                  <h3 class="modal-title">Methods </h3>
              </div>
              <div class="modal-body form">
                  <form action="#" id="form" class="form-horizontal">
                      <input type="hidden" value="" name="methodID"/>
                      <div class="form-body">
                              <div class="form-group">
                                  <input class="form-control" name="desc" placeholder="desc" type="text" autofocus > 
                                  <input class="form-control" name="http" placeholder="http" type="text" > 
                                  <input class="form-control" name="dsID" placeholder="dsID" type="text" value="<?php echo $dsID; ?>"> 
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
