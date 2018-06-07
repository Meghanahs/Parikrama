<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-list"></i>  <?php echo lang('batch'); ?>
            </header>

            <style>

                .editable-table .search_form{
                    border: 0px solid #ccc !important;
                    padding: 0px !important;
                    background: none !important;
                    float: right;
                    margin-right: 14px !important;
                }


                .editable-table .search_form input{
                    padding: 6px !important;
                    width: 250px !important;
                    background: #fff !important;
                    border-radius: none !important;
                }

                .editable-table .search_row{
                    margin-bottom: 20px !important;
                }

                .panel-body {
                    padding: 15px 0px 15px 0px;
                    background: transparent;
                }

            </style>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix search_row">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button class="btn btn-info">
                                    <i class="fa fa-plus-circle"></i>  <?php echo lang('add_batch'); ?>
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                        <form action="batch/searchBatch" method="get" class="search_form">
                            <input type="text" name="key" placeholder="<?php echo lang('search'); ?> <?php echo lang('batch_id'); ?>" value='<?php
                            if (!empty($key)) {
                                echo $key;
                            }
                            ?>'>
                        </form>
                    </div>
                    <div class="space15">
                        <?php if (!empty($key)) { ?>
                            <p>Search Result For <?php echo $key; ?></p>
                        <?php } ?>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th> <?php echo lang('batch_id'); ?></th>
                                <th> <?php echo lang('course'); ?></th>
                                <th> <?php echo lang('instructor'); ?></th>
                                <th> <?php echo lang('start_date'); ?></th>
                                <th> <?php echo lang('end_date'); ?></th>
                                <th> <?php echo lang('students'); ?></th>
                                <th> <?php echo lang('status'); ?></th>
                                <th class="no-print"> <?php echo lang('options'); ?></th>
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

                        </style>
                        <?php
                        if ($settings->date_format == 1) {
                            $date_format = 'd-m-Y';
                        } else {
                            $date_format = 'm/d/Y';
                        }
                        ?>
                        <?php foreach ($batchs as $batch) { ?>
                            <tr class="">
                                <td><?php echo $batch->batch_id; ?></td>
                                <td> <?php echo $this->course_model->getCourseById($batch->course)->name; ?></td>
                                <td>
                                    <?php
                                    $instructor_name = $this->instructor_model->getInstructorById($batch->instructor);
                                    if (!empty($instructor_name)) {
                                        echo $instructor_name->name;
                                    }
                                    ?>
                                </td>
                                <td class="center"><?php echo date($date_format, $batch->start_date); ?></td>
                                <td><?php echo date($date_format, $batch->end_date); ?></td>

                                <td><span class="student_number"><?php echo $this->batch_model->getStudentsNumberByBatchId($batch->batch_id); ?> </span></td>
                                <td>
                                    <?php
                                    if (time() < $batch->start_date) {
                                        echo lang('upcoming');
                                    }
                                    if ((time() > $batch->start_date) && (time() < $batch->end_date)) {
                                        echo lang('running');
                                    }
                                    if (time() > $batch->end_date) {
                                        echo lang('completed');
                                    }
                                    ?>
                                </td>
                                <td class="no-print">
                                    <a class="btn btn-info btn-xs btn_width" href="batch/students?batch_id=<?php echo $batch->batch_id; ?>"><i class=""> </i> <?php echo lang('batch_details'); ?></a>
                                    <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $batch->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>   
                                    <?php if ($this->ion_auth->in_group('admin')) { ?> 
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="batch/delete?id=<?php echo $batch->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> </i> <?php echo lang('delete'); ?></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php if (empty($key)) { ?>

                        <div class="row no-print">
                            <div class="col-lg-6"><div class="dataTables_paginate paging_bootstrap pagination"><ul>
                                        <li class="next disabled"><a href="batch/batchByPageNumber?page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="batch/batchByPageNumber?page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="batch/batchByPageNumber?page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="batch/batchByPageNumber?page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="batch/batchByPageNumber?page_number=<?php
                                            if (!empty($pagee_number)) {
                                                echo $pagee_number + 1;
                                            } else {
                                                echo '1';
                                            }
                                            ?>">Next → </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="row no-print">
                            <div class="col-lg-6"><div class="dataTables_paginate paging_bootstrap pagination"><ul>
                                        <li class="next disabled"><a href="batch/searchBatch?key=<?php echo $key; ?>&page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="batch/searchBatch?key=<?php echo $key; ?>&page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="batch/searchBatch?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="batch/searchBatch?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="batch/searchBatch?key=<?php echo $key; ?>&page_number=<?php
                                            if (!empty($pagee_number)) {
                                                echo $pagee_number + 1;
                                            } else {
                                                echo '1';
                                            }
                                            ?>">Next → </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Batch Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add_batch'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="batch/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?></label>
                        <input type="text" class="form-control" name="batch_id" id="exampleInputEmail1" value='' placeholder="">
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
                        <input type="text" class="form-control default-date-picker" name="end_date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course_fee'); ?></label>
                        <input type="text" class="form-control" name="course_fee" id="exampleInputEmail1" placeholder="">
                    </div>

                    <input type="hidden" name="id" value=''>

                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Batch Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i>  <?php echo lang('edit_batch'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editBatchForm" action="batch/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?></label>
                        <input type="text" class="form-control" name="batch_id" id="exampleInputEmail1" value='' placeholder="">
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
                                    if ($batch->instructor == $instructor->id) {
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
                        <input type="text" class="form-control default-date-picker" name="end_date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course_fee'); ?></label>
                        <input type="text" class="form-control" name="course_fee" id="exampleInputEmail1" placeholder="">
                    </div>

                    <input type="hidden" name="id" value=''>

                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
                                            $(document).ready(function () {
                                                $(".editbutton").click(function (e) {
                                                    e.preventDefault(e);
                                                    // Get the record's ID via attribute  
                                                    var iid = $(this).attr('data-id');
                                                    $('#editBatchForm').trigger("reset");
                                                    $('#myModal2').modal('show');
                                                    $.ajax({
                                                        url: 'batch/editBatchByJason?id=' + iid,
                                                        method: 'GET',
                                                        data: '',
                                                        dataType: 'json',
                                                    }).success(function (response) {
                                                        var start = response.batch.start_date * 1000;
                                                        var end = response.batch.end_date * 1000;
                                                        var d_s = new Date(start);
                                                        var d_e = new Date(end);
<?php
$date_format = $settings->date_format;
if ($date_format == 1) {
    ?>
                                                            var da_start = d_s.getDate() + '-' + (d_s.getMonth() + 1) + '-' + d_s.getFullYear();
                                                            var da_end = d_e.getDate() + '-' + (d_e.getMonth() + 1) + '-' + d_e.getFullYear();
    <?php } else {
    ?>
                                                            var da_start =  (d_s.getMonth() + 1) + '/' + d_s.getDate()  + '/' + d_s.getFullYear();
                                                            var da_end = (d_e.getMonth() + 1) + '/' + d_e.getDate() + '/' + d_e.getFullYear();
<?php } ?>


 
                                                        // Populate the form fields with the data returned from server
                                                        $('#editBatchForm').find('[name="id"]').val(response.batch.id).end()
                                                        $('#editBatchForm').find('[name="batch_id"]').val(response.batch.batch_id).end()
                                                        $('#editBatchForm').find('[name="course"]').val(response.batch.course).end()
                                                        $('#editBatchForm').find('[name="course_fee"]').val(response.batch.course_fee).end()
                                                        $('#editBatchForm').find('[name="instructor"]').val(response.batch.instructor).end()
                                                        $('#editBatchForm').find('[name="start_date"]').val(da_start).end()
                                                        $('#editBatchForm').find('[name="end_date"]').val(da_end).end()
                                                    });
                                                });
                                            });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
