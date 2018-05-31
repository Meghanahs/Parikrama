<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($instructor->id))
                    echo '<i class="fa fa-edit"></i> '.lang('edit_instructor');
                else
                    echo '<i class="fa fa-plus-circle"></i> '.lang('add_instructor');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-md-6">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                            <?php echo validation_errors(); ?>
                                            <?php echo $this->session->flashdata('feedback'); ?>                              
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <form role="form" action="instructor/addNew" method="post" enctype="multipart/form-data">
                                        <div class="form-group">


                                            <label for="exampleInputEmail1"> <?php  echo lang('name'); ?></label>
                                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                            if (!empty($instructor->name)) {
                                                echo $instructor->name;
                                            }
                                            ?>' placeholder="">

                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('email'); ?></label>
                                            <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='<?php
                                            if (!empty($instructor->email)) {
                                                echo $instructor->email;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('password'); ?></label>
                                            <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('address'); ?></label>
                                            <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php
                                            if (!empty($instructor->address)) {
                                                echo $instructor->address;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('phone'); ?></label>
                                            <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?php
                                            if (!empty($instructor->phone)) {
                                                echo $instructor->phone;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('image'); ?></label>
                                            <input type="file" name="img_url">
                                        </div>

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($instructor->id)) {
                                            echo $instructor->id;
                                        }
                                        ?>'>


                                        <button type="submit" name="submit" class="btn btn-info"> <?php  echo lang('submit'); ?></button>
                                    </form>

                                </div>
                            </section>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
