<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-tasks"></i>   <?php echo lang('my'); ?>  <?php echo lang('tasks'); ?>
            </header>
            <div class="panel-body"> 
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                       
                        <a href="task/myTask">
                            <div class="btn-group">
                                <button id="" class="btn green">
                                    <i class="fa fa-tasks"></i> <?php echo lang('my'); ?> <?php echo lang('all'); ?> <?php echo lang('tasks'); ?>
                                </button>
                            </div>
                        </a>
                        <a href="task/myOpen">
                            <div class="btn-group">
                                <button id="" class="btn btn-info">
                                    <i class="fa fa-tasks"></i> <?php echo lang('my'); ?> <?php echo lang('open'); ?> <?php echo lang('tasks'); ?>
                                </button>
                            </div>
                        </a>
                        <a href="task/myDone">
                            <div class="btn-group">
                                <button id="" class="btn btn-info">
                                    <i class="fa fa-tasks"></i> <?php echo lang('my'); ?> <?php echo lang('done'); ?> <?php echo lang('tasks'); ?>
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th> <?php echo lang('status'); ?></th>
                                <th> <?php echo lang('date'); ?></th>
                                <th> <?php echo lang('requested_by'); ?></th>
                                <th> <?php echo lang('requested_for'); ?></th>
                                <th> <?php echo lang('task'); ?></th>
                                <th> <?php echo lang('timeline'); ?></th>
                                <th> <?php echo lang('report'); ?></th>  
                            </tr>
                        </thead>
                        <tbody>

                        <style>

                            .img_url{
                                height:20px;
                                width:20px;
                                background-size: contain; 
                                max-height:20px;
                                border-radius: 100px;
                            }

                            .load{
                                float: right !important;
                            }

                        </style>
                        
                        <?php $current_user = $this->ion_auth->get_user_id(); ?>
                        <?php
                        foreach ($tasks as $task) {
                            if ($task->requested_for == $current_user) {
                                ?>
                                <tr class="">
                                    <td class="medici_name"> 
                                        <?php
                                        if ($task->status == 1) {
                                            echo lang('open');
                                        } else {
                                            echo lang('completed');
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $task->date; ?></td>
                                    <td> <?php echo $this->employee_model->getEmployeeByIonUserId($task->requested_by)->name; ?></td> 
                                    <td> <?php echo $this->employee_model->getEmployeeByIonUserId($task->requested_for)->name; ?></td>  
                                    <td>  <button type="button" class="btn btn-info btn-xs btn_width see_to_do" data-toggle="modal" data-id="<?php echo $task->id; ?>"><i class="fa fa-eye"></i>  <?php echo lang('see'); ?></button>   </td>
                                    <td> <?php echo $task->timeline; ?></td>
                                    <td>
                                        <?php if (!empty($task->to_do_report)) { ?>
                                            <button type="button" class="btn btn-info btn-xs btn_width see_to_do_report" data-toggle="modal" data-id="<?php echo $task->id; ?>"><i class="fa fa-eye"></i>  <?php echo lang('see'); ?></button> 
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-info btn-xs btn_width addreport" data-toggle="modal" data-id="<?php echo $task->id; ?>"><i class="fa fa-plus-circle"></i>  <?php echo lang('add'); ?> <?php echo lang('report'); ?></button>
                                        <?php } ?>
                                    </td>

                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->





<!-- Add Task Report-->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add_report'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="task/addReport" id="addReportForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label"> <?php echo lang('report'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="to_do_report" value="<?php
                            if (!empty($task->to_do_report)) {
                                echo $task->to_do_report;
                            }
                            ?>" rows="10">
                            </textarea>
                        </div>
                    </div>
                    <input type="hidden" name="task_id" value="">
                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Accountant Modal-->






<!-- See The Task -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-tasks"></i>  <?php echo lang('task'); ?></h4>
            </div>
            <div class="modal-body task">


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Load Task -->






<!-- See The Task Report -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-file-text"></i>   <?php echo lang('task'); ?>  <?php echo lang('report'); ?> </h4>
            </div>
            <div class="modal-body task_report">


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Load Task -->












<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".see_to_do").click(function (e) {
            e.preventDefault(e);
            $(".task").html("");
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal3').modal('show');
            $.ajax({
                url: 'task/editTaskByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var task = response.task.to_do;
                $(".task").append(task);
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".see_to_do_report").click(function (e) {
            e.preventDefault(e);
            $(".task_report").html("");
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal4').modal('show');
            $.ajax({
                url: 'task/editTaskByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json'
            }).success(function (response) {
                var task_report = response.task.to_do_report;
                $(".task_report").append(task_report);
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".addreport").click(function (e) {
            e.preventDefault(e);
            $('#addReportForm').trigger("reset");
            ;
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal5').modal('show');

            $('#addReportForm').find('[name="task_id"]').val(iid).end()

        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

