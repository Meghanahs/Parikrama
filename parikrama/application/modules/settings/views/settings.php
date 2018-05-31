<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div  class="panel">
            <section class="panel">
                <header class="panel-heading">
                    <i class="fa fa-gear"></i>  <?php echo lang('settings'); ?>
                </header>
                <div class="col-md-6">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <div class="">
                                <section class="panel">
                                    <div class="panel-body">
                                        <?php echo validation_errors(); ?>
                                        <form role="form" action="settings/update" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('organization_name'); ?></label>
                                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->system_vendor)) {
                                                    echo $settings->system_vendor;
                                                }
                                                ?>' placeholder="system name">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                                                <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->title)) {
                                                    echo $settings->title;
                                                }
                                                ?>' placeholder="title">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                                                <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->address)) {
                                                    echo $settings->address;
                                                }
                                                ?>' placeholder="address">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                                                <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->phone)) {
                                                    echo $settings->phone;
                                                }
                                                ?>' placeholder="phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('admin_email'); ?></label>
                                                <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->email)) {
                                                    echo $settings->email;
                                                }
                                                ?>' placeholder="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('currency'); ?></label>
                                                <input type="text" class="form-control" name="currency" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->currency)) {
                                                    echo $settings->currency;
                                                }
                                                ?>' placeholder="currency">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('date_format'); ?></label>
                                                <select class="form-control m-bot15" name="date_format" value=''>
                                                    <option value="1" <?php
                                                    if (!empty($settings->date_format)) {
                                                        if ($settings->date_format == 1) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>><?php echo lang('dd-mm-yyyy'); ?></option>
                                                    <option value="2" <?php
                                                    if (!empty($settings->date_format)) {
                                                        if ($settings->date_format == 2) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>><?php echo lang('mm/dd/yyyy'); ?></option>
                                                </select>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('login_title'); ?></label>
                                                <input type="text" class="form-control" name="login_title" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->login_title)) {
                                                    echo $settings->login_title;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            
                                              <div class="form-group">
                                                <label for="exampleInputEmail1">Login Logo</label>
                                                <input type="file" class="form-control" name="img_url" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->login_logoo)) {
                                                    echo $settings->login_logoo;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            
                                          
                                            
                                            <div class="form-group hidden">
                                                <label for="exampleInputEmail1">Buyer</label>
                                                <!--<input type="hidden" class="form-control" name="buyer" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->codec_username)) {
                                                    echo $settings->buyer;
                                                }
                                                ?>' placeholder="codec_username">-->
                                            </div>
                                            <div class="form-group hidden">
                                                <label for="exampleInputEmail1">Purchase Code</label>
                                                <!--<input type="hidden" class="form-control" name="p_code" id="exampleInputEmail1" value='<?php
                                                if (!empty($settings->codec_purchase_code)) {
                                                    echo $settings->phone;
                                                }
                                                ?>' placeholder="codec_purchase_code">-->
                                            </div>
                                            <input type="hidden" name="id" value='<?php
                                            if (!empty($settings->id)) {
                                                echo $settings->id;
                                            }
                                            ?>'>
                                            <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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