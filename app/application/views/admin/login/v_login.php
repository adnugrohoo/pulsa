<div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <h2> Admin : Login</h2>
               
                <h5>( Login yourself to get access )</h5>
                 <br />
            </div>
        </div>
         <div class="row ">
               
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>   Enter Details To Login </strong>  
                            </div>
                            <div class="panel-body">
                            <?php 
                              echo form_open('admin/login'); 
                            ?>
                                <form role="form">
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Your E-mail" required />
                                      </div>
                                      <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" id="_strpass" name="_strpass" class="form-control"  placeholder="Your Password" required />
                                      </div>
                                    <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" /> Remember me
                                            </label>
                                            <span class="pull-right">
                                                   <a href="#" >Forget password ? </a> 
                                            </span>
                                        </div>
                                     
                                     <button class="btn btn-primary" value="Login">Login Now</button>
                                    <hr />
                                    <!--Not register ? <a href="registeration.html" >click here </a> -->
                                    </form>
                            <?php echo form_close();?>
                            </div>
                           
                        </div>