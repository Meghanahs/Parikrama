<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">

            <?php
            $date_format = $settings->date_format;
            if ($date_format == 1) {
                $date_format = 'd-m-Y';
            } else {
                $date_format = 'm/d/Y';
            }
            ?>

            <header class="panel-heading">
                <i class="fa fa-list-alt"></i> <?php echo lang('batch_id'); ?> : <?php
                $batch_details = $this->batch_model->getbatchById($batch_id);
                echo $batch_details->batch_id;
                ?>
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
            <section class="panel post-wrap col-md-4">
                <aside>
                    <div class="post-info">
                        <span class="arrow-pro right"></span>
                        <div class="panel-body">
                            <h1><strong><?php echo lang('batch_details'); ?> </strong></h1>
                            <div class="desk yellow">
                                <h3><?php echo lang('course_name'); ?> </h3>  <?php
                                $course_id = $this->batch_model->getbatchById($batch_id)->course;
                                $couse_details = $this->course_model->getcourseById($course_id);
                                echo $couse_details->name;
                                ?>
                                <h3><?php echo lang('batch_id'); ?> </h3> <?php echo $this->batch_model->getbatchById($batch_id)->batch_id; ?>
                                <h3><?php echo lang('instructor'); ?> </h3> <?php echo $this->instructor_model->getInstructorById($batch_details->instructor)->name; ?>
                                <h3>
                                    <?php echo lang('start_date'); ?> </h3> <?php echo date($date_format, $batch_details->start_date); ?>
                                <h3><?php echo lang('end_date'); ?> </h3>
                                <?php echo date($date_format, $batch_details->end_date); ?>
                                <h3><?php echo lang('course_fee'); ?> </h3> <?php echo $settings->currency; ?> <?php
                                echo $batch_details->course_fee;
                                ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </section>

            <div class="panel-body col-md-8">
                <div class="adv-table editable-table ">
                    <div class="clearfix search_row">

                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button class="btn green">
                                    <i class="fa fa-plus-circle"></i>  <?php echo lang('add_student_to_this_batch'); ?>
                                </button>
                            </div>
                        </a>

                        <button class="export" onclick="javascript:window.print();">Print</button>  



                    </div>
                    <header class="panel-heading">
                        <div class=""> <?php echo lang('students_of_this_batch'); ?> </div>
                    </header>
                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th> <?php echo lang('image'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
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
                        foreach ($students as $key => $value) {

                            $student = $this->student_model->getStudentById($value)
                            ?>
                            <tr class="">
                                <td style="width:10%;"><img style="width:95%;" src="<?php echo $student->img_url; ?>"></td>
                                <td> <?php echo $student->name; ?></td>
                                <td><?php echo $student->email; ?></td>
                                <td class="center"><?php echo $student->address; ?></td>
                                <td><?php echo $student->phone; ?></td>
                                <td class="no-print">
                                    <a class="btn btn-info btn-xs btn_width delete_button" href="batch/deleteStudentFromBatch?student_id=<?php echo $student->id; ?>&batch_id=<?php echo $batch_id; ?>" onclick="return confirm('Are you sure you want to remove this student from the batch?');"><i class="fa fa-trash-o"> </i> <?php echo lang('remove'); ?></a>
                                </td>
                            </tr>
                        <?php } ?>
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




<!-- Add Student Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add_student'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="batch/addStudentToBatch" method="post" enctype="multipart/form-data">
                     <div class="form-group">
                    <input type="text" name="search-students" class="search-students" placeholder=" <?php echo lang('search_student')?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('student'); ?> <?php echo lang('name'); ?></label>
                        <select name="student" class="form-control ajaxoption"></select>
                    </div>

                    <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>">





                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Student Modal-->








<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
                                        $(document).ready(function () {
                                            $(".search-students").keyup(function () {

                                                var keyword = this.value;
                                                $('.ajaxoption option').remove();

                                                $.ajax({
                                                    url: 'batch/getStudentByKey?keyword=' + keyword,
                                                    method: 'POST',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {

                                                    $.each(response.opp, function (key, value) {
                                                        $(".ajaxoption").append(value);
                                                    });
                                                });


                                            });
                                        });

</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
