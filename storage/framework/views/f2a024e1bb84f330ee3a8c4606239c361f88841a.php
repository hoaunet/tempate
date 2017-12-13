<!DOCTYPE html>
<html lang="en">
<head>
<title>Chiroro Net</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo e(asset('')); ?>public/backend/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('')); ?>public/backend/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('')); ?>public/backend/css/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo e(asset('')); ?>public/backend/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo e(asset('')); ?>public/backend/css/matrix-media.css" />
<link href="<?php echo e(asset('')); ?>public/backend/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo e(asset('')); ?>public/backend/css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="">Chiroro</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome User</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>

<!--     <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li> -->
    <!-- <li class=""><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li> -->
  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch-->
<!--sidebar-menu-->

<?php echo $__env->make('backend.layouts.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!--<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class="active"><a href="index.html"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="<?php echo e(route('backend.company.index')); ?>"><i class="icon icon-signal"></i> <span>Customer</span></a> </li>
    <li> <a href="#"><i class="icon icon-inbox"></i> <span>Contract</span></a> </li>
    <li><a href="#"><i class="icon icon-th"></i> <span>Contact</span></a></li>
    <li><a href="#"><i class="icon icon-fullscreen"></i> <span>Meeting</span></a></li>    
  </ul>
</div>-->

<!--sidebar-menu-->

<!--Content-->
<?php echo $__env->yieldContent('content'); ?>
<!--End Content-->

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2017 &copy; Chiroro-Net Viet Co., Ltd. All Rights Reserved.</div>
</div>

<!--end-Footer-part-->

<script src="<?php echo e(asset('')); ?>public/backend/js/excanvas.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.ui.custom.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/bootstrap.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.flot.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.flot.resize.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.peity.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/fullcalendar.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/matrix.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/matrix.dashboard.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.gritter.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/matrix.interface.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/matrix.chat.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.validate.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/matrix.form_validation.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.wizard.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.uniform.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/select2.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/matrix.popover.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/jquery.dataTables.min.js"></script> 
<script src="<?php echo e(asset('')); ?>public/backend/js/matrix.tables.js"></script> 

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
