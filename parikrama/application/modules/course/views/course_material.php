<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-list"></i>  <?php echo lang('course_name'); ?> : <?php echo $course->name; ?>
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
                            <h1><strong><?php echo lang('course_details'); ?> </strong></h1>
                            <div class="desk yellow">
                                <h3><?php echo lang('course_name'); ?> </h3>  <?php echo $course->name; ?>
                                <h3><?php echo lang('course_id'); ?> </h3> <?php echo $course->course_id; ?>
                                <h3><?php echo lang('topic'); ?> </h3> <?php echo $course->topic; ?>
                                <h3><?php echo lang('duration'); ?> </h3> <?php
                                echo $course->duration;
                                ;
                                ?>
                                <h3><?php echo lang('course_fee'); ?> </h3> <?php echo $settings->currency; ?> <?php
                                echo $course->course_fee;
                                ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </section>

            <div class="panel-body col-md-8">
                <div class="adv-table editable-table ">

                    <div class="panel">
                        <a class="btn btn-info btn-xs btn_width" data-toggle="modal" href="#myModal">
                            <i class=""> </i> <?php echo lang('add'); ?> <?php echo lang('material'); ?>
                        </a>
                    </div>
                    <header class="panel-heading">
                        <?php echo lang('course'); ?>  <?php echo lang('material'); ?> 
                    </header>

                    <div class="panel-body">
                        <?php foreach ($course_materials as $course_material) { ?>

                            <div class="panel col-md-4">
                                <a class="btn btn-info btn-xs btn_width" href="course/deleteCourseMaterial?id=<?php echo $course_material->id; ?>"onclick="return confirm('Are you sure you want to delete this item?');"> X </a>
                                <div class="post-info">
                                    <img src="<?php echo $course_material->url; ?>" width="100%">
                                </div>
                                <div class="post-info">
                                    <?php
                                    if (!empty($course_material->title)) {
                                        echo $course_material->title;
                                    }
                                    ?>
                                </div>

                                <div class="post-info">
                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $course_material->url; ?>" download> <?php echo lang('download'); ?> </a>
                                    <hr>
                                </div>



                            </div>
                        <?php } ?>
                    </div>




                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->







<!-- Add Course Material Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add'); ?> <?php echo lang('files'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="course/addCourseMaterial" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="course" value='<?php echo $course->id; ?>'>


                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Course Modal-->





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
                                     $(document).ready(function () {
                                         $(".search-batchs").keyup(function () {

                                             var keyword = this.value;
                                             $('.ajaxoption option').remove();

                                             $.ajax({
                                                 url: 'course/getBatchByKey?keyword=' + keyword,
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
