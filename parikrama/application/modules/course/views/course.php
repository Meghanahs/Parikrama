<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-list"></i>  <?php echo lang('courses'); ?>
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
                                    <i class="fa fa-plus-circle"></i>  <?php echo lang('add_course'); ?>
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                        <form action="course/searchCourse" method="get" class="search_form">
                            <input type="text" name="key" placeholder="<?php echo lang('search_id_name_or_topic'); ?>" value='<?php
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
                                <th> <?php echo lang('course_id'); ?></th>
                                <th>  <?php echo lang('course'); ?> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('course'); ?>  <?php echo lang('topic'); ?></th>
                                <th> <?php echo lang('duration'); ?></th>
                                <th> <?php echo lang('course_fee'); ?></th>
                                <th> <?php echo lang('batch'); ?> <?php echo lang('number'); ?></th>
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
                        <?php foreach ($courses as $course) { ?>
                            <tr class="">
                                <td><?php echo $course->course_id; ?></td>
                                <td> <?php echo $course->name; ?></td>
                                <td><?php echo $course->topic; ?></td>
                                <td class="center"><?php echo $course->duration; ?></td>
                                <td class="center"><?php echo $settings->currency; ?> <?php echo $course->course_fee; ?></td>
                                <td class="center"><?php echo $this->batch_model->getBatchQuantityByCourseId($course->id); ?></td>
                                <td class="no-print">
                                    <a class="btn btn-info btn-xs btn_width details" href="course/course_details?course_id=<?php echo $course->id; ?>"> <?php echo lang('details'); ?></a>
                                    <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $course->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>  
                                    <?php if ($this->ion_auth->in_group('admin')) { ?> 
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="course/delete?id=<?php echo $course->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> </i> <?php echo lang('delete'); ?></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php if (empty($key)) { ?>

                        <div class="row no-print">
                            <div class="col-lg-6"><div class="dataTables_paginate paging_bootstrap pagination"><ul>
                                        <li class="next disabled"><a href="course/courseByPageNumber?page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="course/courseByPageNumber?page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="course/courseByPageNumber?page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="course/courseByPageNumber?page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="course/courseByPageNumber?page_number=<?php
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
                                        <li class="next disabled"><a href="course/searchCourse?key=<?php echo $key; ?>&page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="course/searchCourse?key=<?php echo $key; ?>&page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="course/searchCourse?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="course/searchCourse?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="course/searchCourse?key=<?php echo $key; ?>&page_number=<?php
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




<!-- Add Course Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add_course'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="course/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('id'); ?></label>
                        <input type="text" class="form-control" name="course_id" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?>  <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('topic'); ?></label>
                        <input type="text" class="form-control" name="topic" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('duration'); ?></label>
                        <input type="text" class="form-control" name="duration" id="exampleInputEmail1" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course_fee'); ?></label>
                        <input type="text" class="form-control" name="course_fee" id="exampleInputEmail1" placeholder="<?php echo $settings->currency; ?>">
                    </div>

                    <input type="hidden" name="id" value=''>


                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Course Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i>  <?php echo lang('edit_course'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editCourseForm" action="course/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('id'); ?></label>
                        <input type="text" class="form-control" name="course_id" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?>  <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('topic'); ?></label>
                        <input type="text" class="form-control" name="topic" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('duration'); ?></label>
                        <input type="text" class="form-control" name="duration" id="exampleInputEmail1" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course_fee'); ?></label>
                        <input type="text" class="form-control" name="course_fee" id="exampleInputEmail1" placeholder="<?php echo $settings->currency; ?>">
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
                                                $('#editCourseForm').trigger("reset");
                                                $('#myModal2').modal('show');
                                                $.ajax({
                                                    url: 'course/editCourseByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    // Populate the form fields with the data returned from server
                                                    $('#editCourseForm').find('[name="id"]').val(response.course.id).end()
                                                    $('#editCourseForm').find('[name="course_id"]').val(response.course.course_id).end()
                                                    $('#editCourseForm').find('[name="name"]').val(response.course.name).end()
                                                    $('#editCourseForm').find('[name="topic"]').val(response.course.topic).end()
                                                    $('#editCourseForm').find('[name="duration"]').val(response.course.duration).end()
                                                    $('#editCourseForm').find('[name="course_fee"]').val(response.course.course_fee).end()
                                                });
                                            });
                                        });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
