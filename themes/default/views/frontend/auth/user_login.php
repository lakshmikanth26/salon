<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title><?= $title ?></title>

    <script type="text/javascript">if (parent.frames.length !== 0) {

            top.location = '<?=site_url('pos')?>';

        }</script>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>

    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>

    <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>

    <link href="<?= $assets ?>styles/helpers/login.css" rel="stylesheet"/>

    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>

    <!--[if lt IE 9]>

    <script src="<?= $assets ?>js/respond.min.js"></script>

    <![endif]-->



</head>



<body class="login-page">

<noscript>

    <div class="global-site-notice noscript">

        <div class="notice-inner">

            <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in

                your browser to utilize the functionality of this website.</p>

        </div>

    </div>

</noscript>

<div class="page-back">

    
    <div id="login">



        <div class=" container">



            <div class="login-form-div">
                <div class="text-center"><?php if ($Settings->logo2) {

                    echo '<img src="' . base_url('assets/uploads/logos/' . $Settings->logo2) . '" alt="' . $Settings->site_name . '" style="margin-bottom:10px;" />';

                } ?></div>

                <div class="login-content">

                    <?php if ($Settings->mmode) { ?>

                        <div class="alert alert-warning">

                            <button data-dismiss="alert" class="close" type="button">×</button>

                            <?= lang('site_is_offline') ?>

                        </div>

                    <?php }

                    if ($error) { ?>

                        <div class="alert alert-danger">

                            <button data-dismiss="alert" class="close" type="button">×</button>

                            <ul class="list-group"><?= $error; ?></ul>

                        </div>

                    <?php }

                    if ($message) { ?>

                        <div class="alert alert-success">

                            <button data-dismiss="alert" class="close" type="button">×</button>

                            <ul class="list-group"><?= $message; ?></ul>

                        </div>

                    <?php } ?>

                    <?php echo form_open("user/user_login", 'class="login" data-toggle="validator"'); ?>

                    <div class="div-title">

                        <h3 class="text-primary"><?= lang('login_with_your_registered_mobile_no') ?></h3>

                    </div>

                    <div class="textbox-wrap">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                            <?php echo form_input($identity); ?>
                        </div>

                    </div>

                    <div class="textbox-wrap">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-password"></i></span>

                            <?php echo form_input($password); ?>
                    
                        </div>

                    </div>
                    


                    <div class="form-action clearfix">


                        <button type="submit" class="btn btn-success pull-right"><?= lang('login') ?> &nbsp; <i

                                class="fa fa-sign-in"></i></button>

                    </div>

                    <?php echo form_close(); ?>

                </div>

<!--                 <div class="login-form-links link2">

                    <h4 class="text-danger"><?= lang('forgot_your_password') ?></h4>

                    <span><?= lang('dont_worry') ?></span>

                    <a href="#forgot_password" class="text-danger forgot_password_link"><?= lang('click_here') ?></a>

                    <span><?= lang('to_rest') ?></span>

                </div>
 -->
                <?php if ($Settings->allow_reg) { ?>

                    <div class="login-form-links link1">

                        <h4 class="text-info"><?= lang('dont_have_account') ?></h4>

                        <span><?= lang('no_worry') ?></span>

                        <a href="#register" class="text-info register_link"><?= lang('click_here') ?></a>

                        <span><?= lang('to_register') ?></span>

                    </div>

                <?php } ?>

            </div>



        </div>

    </div>





</div>



<script src="<?= $assets ?>js/jquery.js"></script>

<script src="<?= $assets ?>js/bootstrap.min.js"></script>

<script src="<?= $assets ?>js/jquery.cookie.js"></script>

<script src="<?= $assets ?>js/login.js"></script>

<script type="text/javascript">

    $(document).ready(function () {

        var hash = window.location.hash;

        if (hash && hash != '') {

            $("#login").hide();

            $(hash).show();

        }

    });

</script>

</body>

</html>

