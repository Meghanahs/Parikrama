<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-calendar"></i>  <?php echo lang('upcoming'); ?> <?php echo lang('events'); ?>
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
                                    <i class="fa fa-plus-circle"></i>  <?php echo lang('add_event'); ?>
                                </button>
                            </div>
                        </a>
                         <a href="event">
                            <div class="btn-group">
                                <button class="btn btn-info">
                                    <i class="fa fa-calendar"></i>  <?php echo lang('all'); ?> <?php echo lang('events'); ?>
                                </button>
                            </div>
                        </a>
                         <a href="event/ongoing">
                            <div class="btn-group">
                                <button class="btn btn-info">
                                    <i class="fa fa-calendar"></i>  <?php echo lang('ongoing'); ?>
                                </button>
                            </div>
                        </a>
                        
                        <a href="event/upcoming">
                            <div class="btn-group">
                                <button class="btn green">
                                    <i class="fa fa-calendar"></i>  <?php echo lang('upcoming'); ?>
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                        <form action="event/searchEvent" method="get" class="search_form">
                            <input type="text" name="key" placeholder="<?php echo lang('search_event_title'); ?>" value='<?php
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
                                <th> # </th>
                                <th> <?php echo lang('title'); ?></th>
                                <th> <?php echo lang('start'); ?></th>
                                <th> <?php echo lang('end'); ?></th>
                                <th> <?php echo lang('status'); ?></th>

                                <th> <?php echo lang('options'); ?></th>
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
                        $i = 0;

                        foreach ($events as $event) {
                            $i = $i + 1;
                            ?>
                            <?php
                            $start_string = explode('-', $event->start);
                            $start_time = implode(' ', $start_string);
                            $start_time = strtotime($start_time);

                            $end_string = explode('-', $event->end);
                            $end_time = implode(' ', $end_string);
                            $end_time = strtotime($end_time);

                            if ($start_time > time()) {
                                ?>
                                <tr class="">
                                    <td><?php echo $i; ?></td>
                                    <td> <?php echo $event->title; ?></td>
                                    <td><?php echo $event->start; ?></td>
                                    <td class="center"><?php echo $event->end; ?></td>

                                    <td class="center"> <?php echo lang('upcoming'); ?></td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $event->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>   
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="event/delete?id=<?php echo $event->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> </i> <?php echo lang('delete'); ?></a>
                                    </td>
                                </tr>
                            <?php }
                            ?>

                        <?php } ?>
                        </tbody>
                    </table>
                    <?php if (empty($key)) { ?>

                        <div class="row">
                            <div class="col-lg-6"><div class="dataTables_paginate paging_bootstrap pagination"><ul>
                                        <li class="next disabled"><a href="event/eventByPageNumber?page_number=<?php
                        if (($pagee_number > 1)) {
                            echo $pagee_number - 1;
                        }
                        ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="event/eventByPageNumber?page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="event/eventByPageNumber?page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="event/eventByPageNumber?page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="event/eventByPageNumber?page_number=<?php
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
                        <div class="row">
                            <div class="col-lg-6"><div class="dataTables_paginate paging_bootstrap pagination"><ul>
                                        <li class="next disabled"><a href="event/searchEvent?key=<?php echo $key; ?>&page_number=<?php
                        if (($pagee_number > 1)) {
                            echo $pagee_number - 1;
                        }
                        ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="event/searchEvent?key=<?php echo $key; ?>&page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="event/searchEvent?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="event/searchEvent?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="event/searchEvent?key=<?php echo $key; ?>&page_number=<?php
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




<!-- Add Event Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add_event'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="event/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="start" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('end'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="end" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>



                    <input type="hidden" name="id" value=''>


                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Event Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i>  <?php echo lang('edit_event'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editEventForm" action="event/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                    if (!empty($event->title)) {
                        echo $event->title;
                    }
                    ?>' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="start" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('end'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="end" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>



                    <input type="hidden" name="id" value=''>


                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min"></script>
<script type="text/javascript">
                                    $(document).ready(function () {
                                        $(".editbutton").click(function (e) {
                                            e.preventDefault(e);
                                            // Get the record's ID via attribute  
                                            var iid = $(this).attr('data-id');
                                            $('#editEventForm').trigger("reset");
                                            $('#myModal2').modal('show');
                                            $.ajax({
                                                url: 'event/editEventByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                $('#editEventForm').find('[name="id"]').val(response.event.id).end()
                                                $('#editEventForm').find('[name="title"]').val(response.event.title).end()
                                                $('#editEventForm').find('[name="start"]').val(response.event.start).end()
                                                $('#editEventForm').find('[name="end"]').val(response.event.end).end()
                                            });
                                        });
                                    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
