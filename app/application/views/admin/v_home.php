        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h4>Table Examples</h4>   
                        <h5>Welcome Jhon Deo , Love to see you back. </h5>
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Users Tables 
                             <a type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#add"><i class="glyphicon glyphicon-plus"></i> Add Person</a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>E-mail</th>
                                            <th>Full Name</th>
                                            <th>Member Code</th>
                                            <th>No Tlpn</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php
                                        $no = 1;
                                        foreach ($show_user as $users) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $users['email'];?></td>
                                            <td><?php echo $users['contact_name'];?></td>
                                            <td><?php echo $users['contact_prefix_no'];?></td>
                                            <td><?php echo $users['contact_phone_no'];?></td>
                                            <td>
                                            <button type="button" data-toggle="modal" data-target="#editUser" data-userid="<?php echo $users['user_id']; ?>"> <span class="fa fa-pencil"></span> </button>
                                            <button type="button" data-toggle="modal" data-target="#delconfirmIssue" data-issueid="<?php echo $users['user_id']; ?>"> <span class="fa fa-remove"></span> </button>
                                            </td>


                                        </tr>


                                    <?php
                                    $no++;
                                        }
                                    ?>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>     
    </div>
    <!-- Bootstrap modal -->

<div class="modal fade" id="add" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add User</h4>
      </div>
      <form id='data_form_add'>
      <div class="modal-body">
        
                        <div class="form-group">
                            <label class="control-label col-md-3">User ID</label>
                            <div class="col-md-9">
                                <input name="user_id" placeholder="User ID" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="email" placeholder="E-mail" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Full Name</label>
                            <div class="col-md-9">
                                <input name="contact_name" placeholder="Full Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Member Code</label>
                            <div class="col-md-9">
                                <textarea name="contact_prefix_no" placeholder="Member Code" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">No Tlpn</label>
                            <div class="col-md-9">
                                <textarea name="contact_phone_no" placeholder="No Tlpn" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
     
      </div>

      <div class="modal-footer">
        <button type="submit"  class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
</div>

<div class="modal fade" id="editUser" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Issue</h4>
            </div>
            <div class="modal-body">
                <div id='formedituser'>

                </div>
            </div>
        </div>
    </div>
</div>


        <div class="modal fade" id="delconfirmIssue" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                  <p>Do you want to delete this Issue? </p>
                </div>
                <div class="modal-footer">
                  <a id="hrefdelissue" class="btn btn-info">yes</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">no</button>
                </div>
              </div>
            </div>
          </div>
              

  <script>
    $('#delconfirmIssue').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
            var issueid = button.data('issueid');
                 document.getElementById("hrefdelissue").href="<?php echo base_url(); ?>index.php/Admin/deleteUser/"+issueid;
                     });
        </script>





<script>$("#data_form_add").submit( function() {
  $('#add').modal('hide');
  $.ajax( {
    type :"post",
    url : "<?php echo site_url() . '/Admin/simpan_tambah' ?>",
    cache :false,
    data :$(this).serialize(),
    success : function(data) {
      $(".sukses").html(data);
      setTimeout(function(){
        
        $('#message').remove();
        location.reload();
      },1500);
    },
    error : function() {
      alert("Data gagal dimasukkan.");
    }
  });
  return false;
});

var dataTable = $('#tabel_menu').dataTable();
$("#searchbox").keyup(function() {
  dataTable.fnFilter(this.value);
  var myHilitor = new Hilitor("tabel_menu");
  myHilitor.setMatchType("left");
  myHilitor.apply(this.value);
} );
</script>

<script>
$('#editUser').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var userid = button.data('userid');
        $.ajax( {
            type :"get",
            url : "<?php echo site_url() . '/Admin/editUser/' ?>"+userid,
            cache :false,
            success : function(data) {
            $("#formedituser").html(data);
            },
            error : function() {
            alert("Error");
            }
        });
    });
</script>


<!-- 
<script>
    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        var end =setInterval(function () {
            minutes = parseInt(timer / 60, 10)
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                window.location = "http://www.goal.com";
                clearInterval(end);
            }
        }, 1000);
    }

    window.onload = function () {
        var fiveMinutes = 5,
            display = document.querySelector('#time');
        startTimer(fiveMinutes, display);
    };
</script>

<div>Registration closes in <span id="time">05:00</span></div>
<form id="form1" runat="server">

</form>
-->