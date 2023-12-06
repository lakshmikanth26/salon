<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <base href="<?= site_url() ?>"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $page_title ?> - <?= $Settings->site_name ?></title>

    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>

    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>

    <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>

    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    
    <script type="text/javascript" src="<?= $assets ?>js/jquery-migrate-1.2.1.min.js"></script>
    
    
    
    <!--[if lt IE 9]>

    <script src="<?= $assets ?>js/jquery.js"></script>
    
    <![endif]-->

    <noscript><style type="text/css">#loading { display: none; }</style></noscript>

    <?php if ($Settings->rtl) { ?>

        <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>

        <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>

        <script type="text/javascript">

            $(document).ready(function () { $('.pull-right, .pull-left').addClass('flip'); });

        </script>

    <?php } ?>

    <script type="text/javascript">

        $(window).load(function () {

            $("#loading").fadeOut("slow");

        });

    </script>

</head>



<body>

<noscript>

    <div class="global-site-notice noscript">

        <div class="notice-inner">

            <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in

                your browser to utilize the functionality of this website.</p>

        </div>

    </div>

</noscript>

<div id="loading"></div>

<div id="app_wrapper">

    <header id="header" class="navbar">

        <div class="container">

            <a class="navbar-brand" href="<?= site_url() ?>"><span class="logo"><?= $Settings->site_name ?></span></a>



            <div class="btn-group visible-xs pull-right btn-visible-sm">

                <button class="navbar-toggle btn" type="button" data-toggle="collapse" data-target="#sidebar_menu"><span

                        class="fa fa-bars"></span></button>

                <a href="<?= site_url('user/logout'); ?>" class="btn"><span class="fa fa-sign-out"></span></a>


            </div>

            <div class="header-nav">

                <ul class="nav navbar-nav pull-right">

                    <li class="dropdown">

                        <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">

                            <img alt=""

                                 src="<?= $this->session->userdata('avatar') ? site_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : base_url('assets/images/' . $this->session->userdata('gender') . '.png'); ?>"

                                 class="mini_avatar img-rounded">



                            <div class="user">

                                <span><?= lang('welcome') ?> <?= ucwords($this->session->userdata('user_name')); ?></span>

                            </div>

                        </a>

                        <ul class="dropdown-menu pull-right">

                          
                            <li><a href="<?= site_url('logout'); ?>"><i

                                        class="fa fa-sign-out"></i> <?= lang('logout'); ?></a></li>

                        </ul>

                    </li>

                </ul>

                <ul class="nav navbar-nav pull-right">

                
                    <?php if ($info) { ?>

                        <li class="dropdown hidden-sm"><a class="btn tip" title="<?= lang('notifications') ?>"

                                                          data-placement="left" href="#" data-toggle="dropdown"><i

                                    class="fa fa-info-circle"></i><span

                                    class="number blightOrange black"><?= sizeof($info) ?></span></a>

                            <ul class="dropdown-menu pull-right content-scroll">

                                <li class="dropdown-header"><i

                                        class="fa fa-info-circle"></i> <?= lang('notifications'); ?></li>

                                <li class="dropdown-content">

                                    <div class="scroll-div">

                                        <div class="top-menu-scroll">

                                            <ol class="oe">

                                                <?php foreach ($info as $n) {

                                                    echo '<li>' . $n->comment . '</li>';

                                                } ?>

                                            </ol>

                                        </div>

                                    </div>

                                </li>

                            </ul>

                        </li>

                    <?php } ?>

                
                </ul>

            </div>

        </div>

    </header>



    <div class="container bblack" id="container">

        <div class="row" id="main-con">

            <div id="sidebar-left" class="col-lg-2 col-md-2">

                <div class="sidebar-nav nav-collapse collapse navbar-collapse" id="sidebar_menu">

                    <ul class="nav main-menu">

                        <li class="mm_welcome"><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i><span

                                    class="text"> <?= lang('dashboard'); ?></span></a></li>


                        <li class="mm_welcome"><a href="<?= site_url('dashboard/recent_bills') ?>"><i class="fa fa-dashboard"></i><span

                                    class="text"> <?= lang('Recent Bills'); ?></span></a></li>
            
                        <li class="mm_welcome"><a href="<?= site_url('dashboard/appointments') ?>"><i class="fa fa-dashboard"></i><span

                                    class="text"> <?= lang('Appointments'); ?></span></a></li>
            
                        <li class="mm_welcome"><a href="<?= site_url('dashboard/wallets') ?>"><i class="fa fa-dashboard"></i><span

                                    class="text"> <?= lang('Wallets'); ?></span></a></li>
                        
                        <li class="mm_welcome"><a href="<?= site_url('dashboard/coupons') ?>"><i class="fa fa-dashboard"></i><span

                                    class="text"> <?= lang('Coupons'); ?></span></a></li>
                                    
                           


                    </ul>

                </div>

                <a href="#" id="main-menu-act" class="full visible-md visible-lg"><i

                        class="fa fa-angle-double-left"></i></a>

            </div>



            <div id="content" class="col-lg-10 col-md-10">

                <div class="row">

                    <div class="col-sm-12 col-md-12">

                        <ul class="breadcrumb">

                            <?php

                            foreach ($bc as $b) {

                                if ($b['link'] === '#') {

                                    echo '<li class="active">' . $b['page'] . '</li>';

                                } else {

                                    echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';

                                }

                            }

                            ?>

                            <li class="right_log hidden-xs">

                                <?= lang('your_ip') . ' ' . $ip_address . " <span class='hidden-sm'>( " . lang('last_login_at') . ": " . date($dateFormats['php_ldate'], $this->session->userdata('user_old_last_login')) . " " . ($this->session->userdata('last_ip') != $ip_address ? lang('ip:') . ' ' . $this->session->userdata('last_ip') : '') . " )</span>" ?>

                            </li>

                        </ul>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-12">

                        <?php if ($message) { ?>

                            <div class="alert alert-success">

                                <button data-dismiss="alert" class="close" type="button">×</button>

                                <?= $message; ?>

                            </div>

                        <?php } ?>

                        <?php if ($error) { ?>

                            <div class="alert alert-danger">

                                <button data-dismiss="alert" class="close" type="button">×</button>

                                <?= $error; ?>

                            </div>

                        <?php } ?>

                        <?php if ($warning) { ?>

                            <div class="alert alert-warning">

                                <button data-dismiss="alert" class="close" type="button">×</button>

                                <?= $warning; ?>

                            </div>

                        <?php } ?>

                        <?php

                        if ($info) {

                            foreach ($info as $n) {

                                if (!$this->session->userdata('hidden' . $n->id)) {

                                    ?>

                                    <div class="alert alert-info">

                                        <a href="#" id="<?= $n->id ?>" class="close hideComment external"

                                           data-dismiss="alert">&times;</a>

                                        <?= $n->comment; ?>

                                    </div>

                                <?php }

                            }

                        } ?>

                        <div id="alerts"></div>

