<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">


            <header class="panel-heading">
                <i class="fa fa-table"></i>  <?php echo lang('routine'); ?>  <button class="export no-print" onclick="javascript:window.print();">Print</button>   <a type="button" class="btn btn-info btn-xs btn_width details export no-print"  href="routine/editRoutine?id=<?php
                if (!empty($routine_id)) {
                    echo $routine_id;
                }
                ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
            </header>





            <footer class="panel margin_top">
                <div class="text-center">
                    <?php echo lang('routine')?> <br> <?php echo lang('course')?> :  <?php
                    $batch_details = $this->batch_model->getBatchById($batch);
                    echo $this->course_model->getCourseById($batch_details->course)->name;
                    ?> <br> <?php echo lang('batch_id')?>: <?php echo $this->batch_model->getBatchById($batch_details->id)->batch_id; ?>

                </div>
            </footer>









            <table class="table table-striped table-hover table-bordered" id="">
                <thead>
                    <tr>
                        <th> <?php echo lang('weekday'); ?></th>
                        <th> <?php echo lang('start_time'); ?></th>
                        <th> <?php echo lang('end_time'); ?></th>
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
                if (!empty($routine->routine)) {
                    $routine_details = explode('*', $routine->routine);
                    ?>



                    <tr class="">

                        <td> 
                            <?php echo lang('monday'); ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'monday') {
                                    echo $weekDayDetail[1];
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'monday') {
                                    echo $weekDayDetail[2];
                                }
                            }
                            ?>
                        </td>

                    </tr>




                    <tr class="">
                        <td> 
                            <?php echo lang('tuesday'); ?>
                        </td>
                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'tuesday') {
                                    echo $weekDayDetail[1];
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'tuesday') {
                                    echo $weekDayDetail[2];
                                }
                            }
                            ?>
                        </td>

                    </tr>

                    <tr class="">
                        <td> 
                            <?php echo lang('wednesday'); ?>
                        </td>
                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'wednesday') {
                                    echo $weekDayDetail[1];
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'wednesday') {
                                    echo $weekDayDetail[2];
                                }
                            }
                            ?>
                        </td>

                    </tr>




                    <tr class="">

                        <td> 
                            <?php echo lang('thursday'); ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'thursday') {
                                    echo $weekDayDetail[1];
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'thursday') {
                                    echo $weekDayDetail[2];
                                }
                            }
                            ?>
                        </td>

                    </tr>




                    <tr class="">

                        <td> 
                            <?php echo lang('friday'); ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'friday') {
                                    echo $weekDayDetail[1];
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'friday') {
                                    echo $weekDayDetail[2];
                                }
                            }
                            ?>
                        </td>

                    </tr>




                    <tr class="">

                        <td> 
                            <?php echo lang('saturday'); ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'saturday') {
                                    echo $weekDayDetail[1];
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'saturday') {
                                    echo $weekDayDetail[2];
                                }
                            }
                            ?>
                        </td>

                    </tr>






                    <tr class="">

                        <td> 
                            <?php echo lang('sunday'); ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'sunday') {
                                    echo $weekDayDetail[1];
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            foreach ($routine_details as $routine_detail) {
                                $weekDayDetail = explode(',', $routine_detail);
                                if ($weekDayDetail[0] == 'sunday') {
                                    echo $weekDayDetail[2];
                                }
                            }
                            ?>
                        </td>

                    </tr>

                <?php } ?>
                </tbody>
            </table>


        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->








<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
                    $(document).ready(function () {
                        $('#acourse').on('change', function () {
                            // Get the record's ID via attribute                 
                            var iid = $(this).find(':selected').data('id');
                            $('#abatch').find('option').remove();
                            $.ajax({
                                url: 'batch/getBatchByCourseIdByJason?id=' + iid,
                                method: 'GET',
                                data: '',
                                dataType: 'json',
                            }).success(function (response) {
                                var batchs = response.batches;
                                $.each(batchs, function (key, value) {
                                    $('#abatch').append($('<option>').text(value.batch_id).val(value.id)).end();
                                });
                            });
                        });
                    });

                    $(document).ready(function () {
                        // Get the record's ID via attribute                 
                        var iid = $(this).find(':selected').data('id');
                        $('#abatch').find('option').remove();
                        $.ajax({
                            url: 'batch/getBatchByCourseIdByJason?id=' + iid,
                            method: 'GET',
                            data: '',
                            dataType: 'json',
                        }).success(function (response) {
                            var batchs = response.batches;
                            $.each(batchs, function (key, value) {
                                $('#abatch').append($('<option>').text(value.batch_id).val(value.id)).end();
                            });
                        });
                    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
