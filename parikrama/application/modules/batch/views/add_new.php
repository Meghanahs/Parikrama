<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($batch->id))
                    echo '<i class="fa fa-edit"></i> ' . lang('edit_batch');
                else
                    echo '<i class="fa fa-plus-circle"></i> ' . lang('add_batch');
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
                                    <form role="form" action="batch/addNew" method="post" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?></label>
                                            <input type="text" class="form-control" name="batch_id" id="exampleInputEmail1" value='<?php
                                            if (!empty($batch->batch_id)) {
                                                echo $batch->batch_id;
                                            }
                                            ?>' placeholder="">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('course'); ?></label>
                                            <select class="form-control" name="course" value=''> 
                                                <?php foreach ($courses as $course) { ?>
                                                    <option value="<?php echo $course->id; ?>" <?php
                                                    if (!empty($batch->course)) {
                                                        if ($batch->course == $course->id) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> ><?php echo $course->name; ?> </option>
                                                        <?php } ?>
                                            </select>
                                        </div>




                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('instructor'); ?></label>
                                            <select class="form-control" name="instructor" value=''> 
                                                <?php foreach ($instructors as $instructor) { ?>
                                                    <option value="<?php echo $instructor->id; ?>" <?php
                                                    if (!empty($batch->instructor)) {
                                                        if ($batch->instructor == $course->id) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> ><?php echo $instructor->name; ?> </option>
                                                        <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('start_date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="start_date" id="exampleInputEmail1" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('end_date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="end_date" id="exampleInputEmail1" value='<?php
                                            if (!empty($batch->address)) {
                                                echo $batch->address;
                                            }
                                            ?>' placeholder="">
                                        </div>

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($batch->id)) {
                                            echo $batch->id;
                                        }
                                        ?>'>

                                        <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
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
