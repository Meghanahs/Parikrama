<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-user"></i>  <?php echo lang('employee'); ?>
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
                                    <i class="fa fa-plus-circle"></i>  <?php echo lang('add_employee'); ?>
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                        <form action="employee/searchEmployee" method="get" class="search_form">
                            <input type="text" name="key" placeholder="<?php echo lang('search_name_or_phone'); ?>" value='<?php
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
                                <th> <?php echo lang('image'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('designation'); ?></th>
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
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
                        <?php foreach ($employees as $employee) { ?>
                            <tr class="">
                                <td style="width:10%;"><img style="width:95%;" src="<?php echo $employee->img_url; ?>"></td>
                                <td> <?php echo $employee->name; ?></td>
                                <td> <?php echo $employee->designation; ?></td>
                                <td><?php echo $employee->email; ?></td>
                                <td class="center"><?php echo $employee->address; ?></td>
                                <td><?php echo $employee->phone; ?></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $employee->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>   
                                    <a class="btn btn-info btn-xs btn_width delete_button" href="employee/delete?id=<?php echo $employee->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> </i> <?php echo lang('delete'); ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php if (empty($key)) { ?>

                        <div class="row">
                            <div class="col-lg-6"><div class="dataTables_paginate paging_bootstrap pagination"><ul>
                                        <li class="next disabled"><a href="employee/employeeByPageNumber?page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="employee/employeeByPageNumber?page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="employee/employeeByPageNumber?page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="employee/employeeByPageNumber?page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="employee/employeeByPageNumber?page_number=<?php
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
                                        <li class="next disabled"><a href="employee/searchEmployee?key=<?php echo $key; ?>&page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="employee/searchEmployee?key=<?php echo $key; ?>&page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="employee/searchEmployee?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="employee/searchEmployee?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="employee/searchEmployee?key=<?php echo $key; ?>&page_number=<?php
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




<!-- Add Employee Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add_employee'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="employee/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value=''>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('designation'); ?></label>
                        <input type="text" class="form-control" name="designation" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('image'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="id" value=''>


                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Employee Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i>  <?php echo lang('edit_employee'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editEmployeeForm" action="employee/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('designation'); ?></label>
                        <input type="text" class="form-control" name="designation" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('image'); ?></label>
                        <input type="file" name="img_url">
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
                                                $('#editEmployeeForm').trigger("reset");
                                                $('#myModal2').modal('show');
                                                $.ajax({
                                                    url: 'employee/editEmployeeByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    // Populate the form fields with the data returned from server
                                                    $('#editEmployeeForm').find('[name="id"]').val(response.employee.id).end()
                                                    $('#editEmployeeForm').find('[name="name"]').val(response.employee.name).end()
                                                    $('#editEmployeeForm').find('[name="password"]').val(response.employee.password).end()
                                                    $('#editEmployeeForm').find('[name="email"]').val(response.employee.email).end()
                                                    $('#editEmployeeForm').find('[name="address"]').val(response.employee.address).end()
                                                    $('#editEmployeeForm').find('[name="phone"]').val(response.employee.phone).end()
                                                });
                                            });
                                        });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
