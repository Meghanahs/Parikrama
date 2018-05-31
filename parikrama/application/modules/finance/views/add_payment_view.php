<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-user"></i>  <?php
                if (!empty($attendence->attendence)) {
                    echo lang('edit_payment');
                } else {
                    echo lang('add_payment');
                }
                ?>
            </header>


            <div class="panel-body">
                <form role="form" action="finance/addPayment" method="post" enctype="multipart/form-data">
                    <div class="attendence_top">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('course'); ?></label>
                            <select class="form-control" name="course" id="acourse"> 
                                <?php foreach ($courses as $course) { ?>
                                    <option value="<?php echo $course->id; ?>" data-id="<?php echo $course->id; ?>" <?php
                                    if (!empty($attendence->attendence)) {
                                        if ($course->id == $attendence->course) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> ><?php echo $course->name; ?> 
                                    </option>
                                <?php } ?>
                            </select> 
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('batch'); ?></label>
                            <select class="form-control" name="batch_id" id="abatch"> 
                                <option value="none">select ---</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('student'); ?></label>
                            <select class="form-control" name="student" id="astudent"> 
                                <option value="none">select ---</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('Due'); ?> <?php echo lang('amount'); ?></label>
                            <input type="text" class="form-control" name="amount" id="exampleInputEmail1" value='' placeholder="<?php echo $settings->currency; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('discount'); ?></label>
                            <input type="text" class="form-control" name="discount" id="exampleInputEmail1" value='' placeholder="<?php echo $settings->currency; ?>">
                        </div>

                    </div>

                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>

                </form>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->








<script src="common/js/ajaxrequest-codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#acourse').on('change', function () {
            // Get the record's ID via attribute                 
            var iid = $(this).find(':selected').data('id');
            $('#abatch').find('option').remove();
            $('#abatch').append($('<option>').text('Select --- '));
            $.ajax({
                url: 'batch/getBatchByCourseIdByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var batchs = response.batches;
                $.each(batchs, function (key, value) {
                    $('#abatch').append($('<option>').attr('data-id', value.id).text(value.batch_id).val(value.id)).end();
                });
            });
        });
    });

    $(document).ready(function () {
        // Get the record's ID via attribute                 
        var iid = $(this).find(':selected').data('id');
        $('#abatch').find('option').remove();
        $('#abatch').append($('<option>').text('Select --- '));
        $.ajax({
            url: 'batch/getBatchByCourseIdByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var batchs = response.batches;
            $.each(batchs, function (key, value) {
                $('#abatch').append($('<option>').attr('data-id', value.id).text(value.batch_id).val(value.id)).end();
            });
        });
    });

    $(document).ready(function () {
        $('#abatch').on('change', function () {
            // Get the record's ID via attribute                 
            var iid = $(this).find(':selected').data('id');
            $('#astudent').find('option').remove();
            $('#astudent').append($('<option>').text('Select --- '));
            $.ajax({
                url: 'batch/getStudentsByBatchIdByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var student = response.students;
                $.each(student, function (key, value) {
                    $('#astudent').append($('<option>').text(value.name).val(value.id)).end();
                });
            });
        });
    });


    $(document).ready(function () {
        // Get the record's ID via attribute                 
        var iid = $(this).find(':selected').data('id');
        $('#astudent').find('option').remove();
        $('#astudent').append($('<option>').text('Select --- '));
        $.ajax({
            url: 'batch/getStudentsByBatchIdByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var student = response.students;
            $.each(student, function (key, value) {
                $('#astudent').append($('<option>').text(value.name).val(value.id)).end();
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
