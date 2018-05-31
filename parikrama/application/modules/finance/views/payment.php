<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-money"></i>   <?php echo lang('all'); ?> <?php echo lang('payments'); ?> 
            </header>

             <?php
            $date_format = $settings->date_format;
            if ($date_format == 1) {
                $date_format = 'd-m-Y';
            } else {
                $date_format = 'm/d/Y';
            }
            ?>

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
                <div class="adv-table editable-table">
                    <div class="clearfix search_row">
                        <a href="finance/addPaymentView">
                            <div class="btn-group">
                                <button class="btn btn-info">
                                    <i class="fa fa-plus-circle"></i>  <?php echo lang('add_payment'); ?>
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                        <form action="finance/searchPayment" method="get" class="search_form">
                            <input type="text" name="key" placeholder="<?php echo lang('search_invoice_id_or_student_id'); ?>" value='<?php
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
                    <table class="table table-striped table-hover table-bordered" id="editable-sample_disable">
                        <thead>
                            <tr>
                                <th> <?php echo lang('invoice_id'); ?> </th>
                                <th> <?php echo lang('student'); ?> </th>
                                 <th> <?php echo lang('student'); ?> <?php echo lang('id'); ?> </th>
                                <th> <?php echo lang('date'); ?> </th>
                                <th> <?php echo lang('sub_total'); ?> </th>
                                <th> <?php echo lang('discount'); ?> </th>
                                <th> <?php echo lang('grand_total'); ?> </th>
                                <th class="option_th"> <?php echo lang('options'); ?> </th>
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
                            .option_th{
                                width:18%;
                            }

                        </style>

                        <?php foreach ($payments as $payment) { ?>
                            <?php $student_info = $this->db->get_where('student', array('id' => $payment->student))->row(); ?>

                            <tr class="">
                                <td><?php echo $payment->id; ?> </td>
                                <td><?php echo $student_info->name; ?></td>
                                <td><?php echo $student_info->id; ?></td>
                                <td><?php echo date($date_format, $payment->date + 11 * 60 * 60); ?></td>
                                <td><?php echo $settings->currency; ?> <?php echo number_format($payment->amount, 2, '.', ','); ?></td>              
                                <td><?php echo $settings->currency; ?> <?php
                                    if (!empty($payment->discount)) {
                                        echo number_format($payment->discount, 2, '.', ',');
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total, 2, '.', ','); ?></td>
                                <td> 

                                    <a class="btn btn-xs invoicebutton width_auto" style="color: #fff;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-text"></i>  <?php echo lang('invoice'); ?></a>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?> 
                                        <a class="btn btn-info btn-xs delete_button width_auto" href="finance/delete?id=<?php echo $payment->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i>  <?php echo lang('delete'); ?></a>
                                    <?php } ?>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>



                    <?php if (empty($key)) { ?>

                        <div class="row">
                            <div class="col-lg-6"><div class="dataTables_paginate paging_bootstrap pagination"><ul>
                                        <li class="next disabled"><a href="finance/paymentByPageNumber?page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="finance/paymentByPageNumber?page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="finance/paymentByPageNumber?page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="finance/paymentByPageNumber?page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="finance/paymentByPageNumber?page_number=<?php
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
                                        <li class="next disabled"><a href="finance/searchPayment?key=<?php echo $key; ?>&page_number=<?php
                                            if (($pagee_number > 1)) {
                                                echo $pagee_number - 1;
                                            }
                                            ?>"><-- Prev</a>
                                        </li>

                                        <?php
                                        if ($pagee_number < 5) {
                                            for ($pagee = 1; $pagee < 6; $pagee++) {
                                                ?>
                                                <li class="active"><a href="finance/searchPayment?key=<?php echo $key; ?>&page_number=<?php echo $pagee; ?>"><?php echo $pagee; ?></a></li>
                                                <?php
                                            }
                                        }

                                        if ($pagee_number >= 5) {
                                            for ($x = 3; $x > 0; $x--) {
                                                ?>
                                                <li class="active"><a href="finance/searchPayment?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number - $x; ?>"><?php echo $pagee_number - $x; ?></a></li>
                                                <?php
                                            }
                                            for ($x = 0; $x < 4; $x++) {
                                                ?>
                                                <li class="active"><a href="finance/searchPayment?key=<?php echo $key; ?>&page_number=<?php echo $pagee_number + $x; ?>"><?php echo $pagee_number + $x; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="next disabled"><a href="finance/searchPayment?key=<?php echo $key; ?>&page_number=<?php
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


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
                                    $(document).ready(function () {
                                        $(".flashmessage").delay(3000).fadeOut(100);
                                    });
</script>