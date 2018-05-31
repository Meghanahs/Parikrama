<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($task->id))
                    echo '<i class="fa fa-edit-circle"></i> ' . lang('edit_task');
                else
                    echo ' <i class="fa fa-plus-circle"></i> ' . lang('add_task');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-md-6">
                            <section class="panel">
                                <div class = "panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="task/addNewTask" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='<?php
                                            if (!empty($task->name)) {
                                                echo $task->name;
                                            }
                                            ?>' placeholder="">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('requested_by'); ?></label>
                                            <select class="form-control" name="requested_by" value=''> 
                                                <?php
                                                if (!$this->ion_auth->in_group(array('admin'))) {
                                                    foreach ($employees as $employee) {
                                                        if ($current_user == $employee->ion_user_id) {
                                                            ?>
                                                            <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                                            if (!empty($task->requested_by)) {
                                                                if ($task->requested_by == $employee->ion_user_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> >
                                                                <?php echo $employee->name; ?> </option>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    foreach ($employees as $employee) {
                                                        ?>
                                                        <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                                        if (!empty($task->requested_by)) {
                                                            if ($task->requested_by == $employee->ion_user_id) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> >
                                                            <?php echo $employee->name; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('requested_for'); ?></label>
                                            <select class="form-control" name="requested_for" value=''> 
                                                <?php
                                                if (!$this->ion_auth->in_group(array('admin'))) {
                                                    foreach ($employees as $employee) {
                                                        if ($current_user != $employee->ion_user_id) {
                                                            ?>
                                                            <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                                            if (!empty($task->requested_for)) {
                                                                if ($task->requested_for == $employee->ion_user_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> >
                                                                <?php echo $employee->name; ?> </option>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    foreach ($employees as $employee) {
                                                        ?>
                                                        <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                                        if (!empty($task->requested_for)) {
                                                            if ($task->requested_for == $employee->id) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> >
                                                            <?php echo $employee->name; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label"><?php echo lang('task'); ?></label>
                                            <div class="">
                                                <textarea class="ckeditor form-control" name="to_do" value="<?php
                                                if (!empty($department->to_do)) {
                                                    echo $department->to_do;
                                                }
                                                ?>" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('timeline'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="timeline" id="exampleInputEmail1" value='<?php
                                            if (!empty($task->client_phone)) {
                                                echo $task->client_phone;
                                            }
                                            ?>' placeholder="">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php echo lang('status'); ?> </label>
                                            <select class="form-control" name="status"> 

                                                <option value="1"  <?php
                                                if (!empty($task->status)) {
                                                    if ($task->status == 1) {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> ><?php echo lang('open'); ?> 
                                                </option>
                                                <option value="2"  <?php
                                                if (!empty($task->status)) {
                                                    if ($task->status == 2) {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> ><?php echo lang('completed'); ?> 
                                                </option>

                                            </select> 
                                        </div> 


                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($task->id)) {
                                            echo $task->id;
                                        }
                                        ?>'>
                                        <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                                    </form>

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
