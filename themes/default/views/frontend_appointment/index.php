<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]-->


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">   
    
    <title>Appointments | TheInfinityUnisexSalon</title> 
    
    <meta name="description" content="">
    <meta name="author" content="">
    
    
    <!-- **Favicon** -->
    <link rel="shortcut icon" href="<?= $assets ?>appointments/favicon.ico" type="image/x-icon" />
    
    <link id="default-css" href="<?= $assets ?>appointments/style.css" rel="stylesheet" media="all" />
    <link href="<?= $assets ?>appointments/css/shortcode.css" rel="stylesheet" type="text/css" />
 
    <!-- **Additional - stylesheets** -->
    <link rel="stylesheet" href="<?= $assets ?>appointments/css/responsive.css" type="text/css" media="all"/>
    <link href="<?= $assets ?>appointments/css/animations.css" rel="stylesheet" media="all" />
    <link id="skin-css" href="<?= $assets ?>appointments/skins/red/style.css" rel="stylesheet" media="all" />
    <link rel="stylesheet" href="<?= $assets ?>appointments/css/meanmenu.css" type="text/css" media="all"/>
    <link rel="stylesheet" type="text/css" href="<?= $assets ?>appointments/css/pace-theme-loading-bar.css" /> 
        
    <!-- **Font Awesome** -->
    <link rel="stylesheet" href="<?= $assets ?>appointments/css/font-awesome.min.css">
    
    <!-- **Google - Fonts** -->
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,300,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css" />
    <![endif]-->
    
    <!-- jQuery -->
    <script src="<?= $assets ?>appointments/js/modernizr.custom.js"></script>
    
</head>

<body>
<div id="loader-wrapper"><!-- PreLoader -->
    <div class="loader">
        <div class="inner one"></div>
        <div class="inner two"></div>
        <div class="inner three"></div>
    </div>
    <h3 class="loader-text">
        The Infinity UniSex Salon
    </h3>
</div><!-- PreLoader -->
<div class="wrapper"><!-- Wrapper -->
    <div class="inner-wrapper"><!-- Inner-Wrapper -->
        <div class="top-bar"><!-- Top Bar -->
            <div class="container">
                <p>Beauty is in the Hands of Your Stylist</p>
                <div class="top-right">
                    <ul>
                        <li>
                            <span class="fa fa-phone-square"></span>
                            +91 8970048000 | 8970047000
                        </li>
                    </ul>        
                </div>
            </div>
        </div><!-- End of Top Bar -->
        <header id="header" class="dt-sticky-menu type2"><!-- Header -->
            <div id="logo"><!-- Logo -->
                <a title="TrendSalon" href="http://theinfinityunisexsalon.com"><img title="TheInfinityUnisexSalon" alt="Trendy" src="http://www.theinfinityunisexsalon.com/wp-content/uploads/2019/02/infinity-salon-1.png"></a>
            </div><!-- End of Logo -->
            <div id="menu-container">
                <div class="container">
                    <nav id="main-menu"><!-- Nav - Starts -->
                        <div id="dt-menu-toggle" class="dt-menu-toggle">
                            Menu
                            <span class="dt-menu-toggle-icon"></span>
                        </div>
                        <a title="TheInfinityUnisexSalon" href="http://theinfinityunisexsalon.com" class="sticky-logo"><img title="TrendSalon" alt="Trendy" src="http://www.theinfinityunisexsalon.com/wp-content/uploads/2019/02/infinity-salon-1.png"></a>
                        <ul class="menu">
                            <li class="menu-item-simple-parent"><a href="http://theinfinityunisexsalon.com">Home</a>
                                
                            </li>
                            <li class="menu-item-simple-parent"><a href="http://theinfinityunisexsalon.com/about-us">About Us</a>
                                
                            </li>
                            <li class=""><a href="http://theinfinityunisexsalon.com/services">Service</a></li>
                            <li class="menu-item-simple-parent"><a href="http://theinfinityunisexsalon.com/blog">Blog</a>
                            </li>
                            <li class="menu-item-simple-parent"><a href="http://theinfinityunisexsalon.com/offers">Offers</a>
                            </li>
                            <li class="menu-item-simple-parent"><a href="http://theinfinityunisexsalon.com/portfolio">Gallery</a>
                            </li>
                            <li class="menu-item-simple-parent"><a href="http://theinfinityunisexsalon.com/contact">Contacts</a>
                            </li>
                        </ul>
                    </nav><!-- End of Nav -->
                </div>
            </div>
        </header>

        <div id="main"><!-- Main -->
            <div class="hr-invisible-small"></div>
            <section class="fullwidth-background">
                <div class="breadcrumb-wrapper">
                    <div class="container">
                        <h4> Appointments </h4>
                        <h6><a href="http://theinfinityunisexsalon.com">Home</a> / Appointments</h6>
                    </div>
                </div>                
            </section>
            <div class="hr-invisible-very-small"></div>
            <div class="clear"></div>
            <section id="primary" class="content-full-width"><!-- Primary Section -->
                <form class="form-event" action="javascript:;">

                <div class="container" id="schedule-data">
                
                <?php if($this->session->flashdata('c_data')){
                    echo $this->session->flashdata('c_data');
                }?>
                </div>    
                        
                <div class="container">
                    <div class="hr-invisible-very-small"></div>
                    <div class="clear"></div>
            
                    <div class="column dt-sc-one-third first">
                        <label class="dt-sc-margin10">Location</label>
                        <div class="selection-box">
                                
                            <select required="required" class="form-control select2" name="location" placeholder="Location" id="location" onchange="selectStaff()" autofocus>
                            <option value=''>Select Location</option>
                                   <?php foreach($warehouses as $warehouse): ?>
                                   <option value="<?php echo $warehouse->id; ?>"><?php echo $warehouse->name; ?></option>
                                   <?php endforeach; ?>
                            </select>        
                        </div>
                    </div>
                    <div class="column dt-sc-one-third">
                        <label class="dt-sc-margin10">Services</label>
                        <div class="selection-box">
                                
                            <select required="required" class="form-control select2" name="service" placeholder="service" id="service">
                            <option value=''>Select Service</option>
                                   <?php foreach($services as $service): ?>
                                   <option value="<?php echo $service->id; ?>"><?php echo $service->name; ?></option>
                                   <?php endforeach; ?>
                            </select>        
                                  
                        </div>
                    </div>
                    <div class="column dt-sc-one-third">
                        <label class="dt-sc-margin10">Staffs</label>
                        <div class="selection-box">
                                
                            <select required="required" class="form-control select2" name="staff" placeholder="staff" id="staff">
                            <option value=''>Select Staff</option>
                            </select>        
                    
                        </div>
                    </div>
                </div>   
                <div class="container">
                    <div class="hr-invisible"></div>
                    <div class="clear"></div>
                      <div class="column dt-sc-one-third first" style="width:100%;height: 100%;">
                        <label class="dt-sc-margin10">Notes</label>
                             <textarea name="description" id="description" class="form-control textArea" placeholder="Notes(Regarding Services, staffs etc)..." rows="2" style="height: 100%;"></textarea>
                    
                    </div>
                 
                   
                </div>
                
                <div class="container"  id="datepicker-div">
                    <div class="hr-invisible"></div>
                    <div class="clear"></div>
                    <h4>Available Dates and Slots</h4>
                    <div class="column dt-sc-one-third first">
                        <label class="dt-sc-margin10">Available Dates</label>
                                <input type="text" id="datepicker" class="form-control" name="available">
                    </div>
                    <div class="column dt-sc-one-third slot-div">
                        <label class="dt-sc-margin10">Available Slots</label>
                             <select required="required" class="form-control select2" name="availableslots" placeholder="Slots" id="availableslots">
                            <option value=''>Select Slots</option>
                            </select>        
                      
                    
                    </div>
                    
                    
                </div>
                <div class="container slot-div">
                    <div class="hr-invisible"></div>
                    <div class="clear"></div>
                    <h4>Contact Details</h4>
                    <div class="column dt-sc-one-third first">
                        <label class="dt-sc-margin10">Mobile No</label>
                               <div> <input type="text" id="phone" class="form-control" name="phone" placeholder="Mobile No" style="width:70%;float:left;"><input class="search" value="search" type="button" style="padding: 12px;height: 43px;width: 30%;    margin: 0px 0 23px;"></div>

                      <span style="color:red;" id="phone-error"></span>
                    
                    
                      <span>Please enter your mobile no, If already registered then Customer data will be prepopulated</span>
                    
                    </div>
                    
            
                    <div class="column dt-sc-one-third customer-div">
                        <label class="dt-sc-margin10">Name</label>
                                <input type="text" id="name" class="form-control" name="name">
                    </div>
                    
                    <div class="column dt-sc-one-third customer-div">
                        <label class="dt-sc-margin10">Email</label>
                                <input type="text" id="email" class="form-control" name="email" placeholder="Email">
                      
                    
                    </div>
            
                
                   
                </div>
                
                <div class="container customer-div">
                    <div class="hr-invisible-very-small"></div>
                    <div class="clear"></div>
                    <input class="generate-timeslot" value="submit" type="button" style="width:100%">

                </div>    
                </form>
                <div class="clear"></div>
                <div class="hr-invisible"></div>
                <div class="hr-invisible"></div>
                    <div class="clear"></div>
                    <div class="hr-invisible"></div>
                    <div class="clear"></div>
                    

                
            </section> <!-- End of Primary Section -->   
        </div><!-- End of Main -->
        <footer id="footer">
        <div class="hr-invisible"></div>
            <div class="footer-widgets-wrapper" style="display: none;">
                <div class="container">
                    <div class="column dt-sc-one-fourth first">
                        <aside class="widget widget_text">
                            <h4 class="widgettitle"> Location </h4>
                            <div class="dt-sc-contact-info address">
                                <p>#92, 1st Floor,Opp. Federal Bank, <br>Sarjapura Main Road, Chambenahalli, <br>Dommasandra,Bangalore- 562125</p>
                            </div>
                            <div class="hr-invisible-very-very-small"></div>
                            <h4 class="widgettitle"> Telephone Enquiry </h4>
                            <div class="dt-sc-contact-info">
                                <p class="dt-sc-clr num"> +91 8970048000 | 8970047000 </p>
                            </div>
                            
                        </aside>
                    </div>
                    <div class="column dt-sc-one-fourth">
                        <aside class="widget widget_text">
                            <h4 class="widgettitle"> About Us </h4>
                            <div class="textwidget">
                                <ul>
                                    <li><a href="#"> About Us</a></li>
                                    <li><a href="#"> Salons </a></li>
                                    <li><a href="#"> Giftcards </a></li>
                                    <li><a href="#"> Terms & Conditions </a></li>
                                    <li><a href="#"> Work With Us </a></li>
                                </ul>
                            </div>     
                        </aside>
                    </div>
                    <div class="column dt-sc-one-fourth">
                        <aside class="widget widget_tweetbox">
                                 
                        </aside>
                    </div>
                    <div class="column dt-sc-one-fourth">
                        <aside class="widget widget_newsletter">
                            <div class="hr-invisible-very-very-small"></div>
                            <h4 class="widgettitle"> Follow Us </h4>
                            <ul class="footer-icons">
                                <li><a href="#" class="fa fa-facebook"></a></li>
                                <li><a href="#" class="fa fa-twitter"></a></li>
                                <li><a href="#" class="fa fa-youtube"></a></li>
                                <li><a href="#" class="fa fa-google-plus"></a></li>
                                <li><a href="#" class="fa fa-rss"></a></li>
                            </ul>
                        </aside>
                    </div>    
                </div>
                <div class="hr-invisible-medium"></div>
            </div>
            <div class="copyright">
                <div class="container">
                    <p> © 2019 The Infinity Unisex Salon . Designed by <a href="http://indocweb.com">Indoc Solutions</a></p>
                </div>
            </div>
        </footer>
    </div><!-- End of Inner-Wrapper -->
</div><!-- End of Wrapper -->

<!-- **jQuery** -->    
<script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    
<script type="text/javascript" src="<?= $assets ?>js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>availability-calendar/scripts/components/jquery.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>appointments/js/jquery.sticky.min.js"></script> 
<script src="<?= $assets ?>appointments/js/jsplugins.js" type="text/javascript"></script>
<script src="<?= $assets ?>appointments/js/jquery.meanmenu.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>appointments/js/custom.js"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<style type="text/css">
    .custom-control-input.is-invalid~.custom-control-label, .form-check-input.is-invalid~.form-check-label, .form-group.has-error .help-block, .form-group.has-error label.dt-sc-margin10, .has-error .custom-control-label, .was-validated .custom-control-input:invalid~.custom-control-label, .was-validated .form-check-input:invalid~.form-check-label {
    color: #ff5c75;
    }
    .has-error .form-control {
    border: 1px solid #ff5c75;
    }
    .ui-datepicker-year{
        height: 32px;
    }
    .ui-datepicker-month{
        height: 32px;
    }
    .ui-datepicker .ui-datepicker-title{
        line-height: 6px;
    }
    #dt-sc-schedule-details >ul >li {
        padding-bottom: 10px;
    }
    #dt-sc-contact-info >ul >li {
        padding-bottom: 10px;
    }
    .mb:before {
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-top: 7px solid #ccc;
    bottom: 0;
    height: 0;
    margin: auto;
    right: 17px;
    top: 3px;
    z-index: 1;
    }
    .mb:after {
    height: 50px;
    right: 0;
    top: 0px;
    width: 50px;
    border-left: 1px solid #ccc;
    }
    .mb:before, .mb:after {
    content: "";
    pointer-events: none;
    position: absolute;
    }
</style>
<script type="text/javascript">

    function selectStaff() {

      var location = jQuery('#location').val();

      jQuery.get("<?php echo site_url('Appointment/get_staffs');?>",
      {
          location: location
      },

      function (data) {

          jQuery('#staff').html(data);

      });
    } 
    function selectAvailableSlots(selected) {

      var id = jQuery("#staff").val();
        
      jQuery.get("<?php echo site_url('Appointment/get_slots');?>",
      {
          id: id,selected:selected
      },

      function (data) {

          jQuery('#availableslots').html(data);
          jQuery(".slot-div").css('display','block');
      
      });
    }



</script>
<script type="text/javascript">

jQuery(document).ready(function()
{
    $(window).scrollTop(0);
    $("#datepicker-div").css('display','none');
    $(".slot-div").css('display','none');
    $(".customer-div").css('display','none');
    var base_url = "<?php echo base_url(); ?>";
    var unavailableDates;
    jQuery("#datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        beforeShowDay: unavailable,
        minDate: 0,
        firstDay: 1, // rows starts on Monday
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        onSelect: function(selected,evnt) {
         selectAvailableSlots(selected);
        }
        });

     $('#staff').on('change', function() {
   
        var id = jQuery("#staff").val();
        jQuery.ajax({
        url: base_url +'appointment/get_staffs_unavailable_dates/'+id,
        dataType: 'json',
        success: function(data)
        {
         unavailableDates = data;
         $("#datepicker-div").css('display','block');
        }
        });
    });
   
    function unavailable(date) {
        var yr      = date.getFullYear();
        var month   = date.getMonth() < 10 ? '0' + (parseInt(date.getMonth())+1) : (parseInt(date.getMonth())+1);
        var day     = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate();

        dmy = day + "-" + month + "-" + yr;
        if (jQuery.inArray(dmy, unavailableDates) == -1) {
            return [true, ""];
        } else {
            return [false, "Unavailable"];
        }
    }

    $(".search").click(function(){
        $('.search').css('display','none');
        
        var phone = $("#phone").val();
        var filter = /^[0]?[6789]\d{9}$/;
        if (filter.test(phone)) {
        $('#phone-error').text("Loading...");
           
        $.get('<?php echo base_url('appointment/get_customer_details'); ?>',
        {
            phone: phone
        },

        function (data) {
            var obj = JSON.parse(data);
            $('#name').val(obj.name);
            $('#email').val(obj.email);
            $('.customer-div').css('display','block');
            $('#phone-error').text(""); 
            $('.search').css('display','block');
        });

        }else{
            $('#phone-error').text("Invalid Mobile number... Enter to digit mobile number");
            $('.search').css('display','block');
        }
        
    });


    $(document).on('click', '.generate-timeslot', function() {
            var location = $('#location').val();
            var service = $('#service').val();
            var staff = $('#staff').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var name = $('#name').val();
            var description = $('#description').val();
            var availabledate = $('#datepicker').val();
            var availableslot = $('#availableslots').val();
            
            
            console.log(description);

            if((location == 0 || location == '') || (staff == 0 || staff == '') || (service == 0 || service == '') || (phone == '') || (name == null || name == '') ||  (availabledate == null || availabledate == '') ||  (availableslot == null || availableslot == '') ||  (email == null || email == '')) {

                if(name == '' || name == null){
                    $('#name').closest('.column').addClass('has-error');
                    $('#name').focus();   
                }
                if(email == '' || email == null){
                    $('#email').closest('.column').addClass('has-error');
                    $('#email').focus();   
                }
                    
                if(phone == '' || phone == null){
                    $('#phone').closest('.column').addClass('has-error');
                    $('#phone').focus();  
                }if(availabledate == ''){
                    $('#datepicker').closest('.column').addClass('has-error');
                    $('#datepicker').focus();  
                }if(availableslot == 0 || availableslot == ''){
                    $('#availableslots').closest('.column').addClass('has-error');
                    $('#availableslots').focus();    
                }if(service == 0){
                    $('#service').closest('.column').addClass('has-error');
                    $('#service').focus();   
                }
                if(location == 0){
                    $('#location').closest('.column').addClass('has-error');
                    $('#location').focus();   
                }
                if(staff == 0){
                    $('#staff').closest('.column').addClass('has-error');
                    $('#staff').focus();   
                }
                console.log("b");
            } else {
                console.log("a");

                    

                var decision = confirm("Are you Sure?");

                    if (decision) {

                        jQuery('#generate-timeslot').css('display', 'none');
            

                        jQuery.ajax({

                          type: "POST",

                          dataType: "json",

                          url: base_url+'appointment/add_appointments',

                          data : { name : name,email:email, phone : phone, location : location, description : description, staff : staff, service : service, availableslot : availableslot,availabledate : availabledate},
                          success: function (response) {
                                alert('Appointment Done successfully');
                                jQuery('#generate-timeslot').css('display', 'block');
                                window.location.reload();

                          }

                        });

                    }

                    

            }
        });
    

    
});





</script>


</body>

</html>
