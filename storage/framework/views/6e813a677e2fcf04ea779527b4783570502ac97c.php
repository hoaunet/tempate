<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Company</a>
  <ul>
    <li class="<?php if(curr_page() == 'dashboard'): ?> active <?php endif; ?>" ><a href="<?php echo e(route('backend.dashboard.index')); ?>"><i class="icon icon-dashboard"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"><a href="<?php echo e(route('backend.company.index')); ?>"><i class="icon icon-home"></i> <span>Company</span> </a>
      <ul>
        <li><a href="<?php echo e(route('backend.company.index')); ?>">Company List</a></li>
        <li><a href="#">Company Regist</a></li>
      </ul>
    </li>
    <li class="submenu <?php if(curr_page() == 'contract'): ?> active <?php endif; ?>"> <a href="<?php echo e(route('backend.contract.index')); ?>"><i class="icon icon-book"></i> <span>Contract</span></a>
      <ul>
        <li><a href="<?php echo e(route('backend.contract.index')); ?>">Contracts List</a></li>
        <li><a href="#">Contract Regist</a></li>
      </ul>
    </li>
    <li class="submenu <?php if(curr_page() == 'meeting'): ?> active <?php endif; ?>"> <a href="<?php echo e(route('backend.meeting.index')); ?>"><i class="icon icon-group"></i> <span>Meeting</span></a>
      <ul>
        <li><a href="<?php echo e(route('backend.meeting.index')); ?>">Meeting List</a></li>
        <li><a href="#">Meeting Regist</a></li>
      </ul>
    </li>
    <li class="submenu <?php if(curr_page() == 'users'): ?> active <?php endif; ?>"> <a href="<?php echo e(route('backend.users.index')); ?>"><i class="icon icon-user"></i> <span>Users</span> </a>
      <ul>
        <li><a href="<?php echo e(route('backend.users.index')); ?>">User List</a></li>
        <li><a href="#">User Regist</a></li>
      </ul>
    </li>
    <!-- <li class="content"></li>  -->   
  </ul>
</div>