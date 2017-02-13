<header class="main-header">
	<!-- Logo -->
	<a class="logo" href="<?php echo base_url('admin/home/') ?>">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini">PLS</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg">Pulsa</span>
	</a>
	
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
    				<img alt="" src="<?php echo base_url() ?>/assets/images/<?php echo ($this->session->userdata('site_language') ? $this->session->userdata('site_language') : $this->config->item('language')) ?>.png">
    				<i class="fa fa-caret-down"></i>
    			</a>
                <ul class="dropdown-menu">
                    <li>
                        <ul class="menu">
                            <li><a href="<?php echo site_url('admin/language/switch_language/english') ?>"><img alt="" src="<?php echo base_url() ?>assets/images/english.png"> English</a></li>
                            <li><a href="<?php echo site_url('admin/language/switch_language/indonesian') ?>"><img alt="" src="<?php echo base_url() ?>assets/images/indonesian.png"> Indonesia</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img class="user-image" src="<?php echo base_url() ?>assets/images/placeholder_user.png">
					<span class="hidden-xs"><?php echo $this->session->userdata('email') ?></span>
                </a>
                <ul class="dropdown-menu">
					<!-- User image -->
					<li class="user-header">
                        <img class="img-circle" src="<?php echo base_url() ?>assets/images/placeholder_user.png">
                        <p>
                            <?php echo $this->session->userdata('email') ?>
                        </p>
                    </li>
					<!-- Menu Footer-->
					<li class="user-footer">
						<?php if ($_SERVER['HTTP_HOST'] == 'localhost') : ?>
							<div class="pull-left">
								<a class="btn btn-default btn-flat" href="<?php echo site_url('admin/profile/edit/'.$this->session->userdata('auth_id')) ?>"><?php echo lang('menu_nav_profile') ?></a>
							</div>
						<?php endif ?>
						<div class="pull-right">
							<a class="btn btn-default btn-flat" href="<?php echo site_url('admin/auth/logout') ?>" onclick="return confirm('<?php echo lang('menu_nav_logout_confirmation_message') ?>')"><i class="fa fa-sign-out fa-fw"></i> <?php echo lang('auth_sign_out') ?></a>
						</div>
					</li>
                </ul>
            </li>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="treeview">
				<a href="<?php echo base_url('admin/home/') ?>">
					<i class="fa fa-dashboard"></i> <span><?php echo lang('menu_nav_dashboard') ?></span></i>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-files-o"></i>
					<span><?php echo lang('menu_nav_transactions') ?></span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url('admin/transactions/list_all') ?>"><i class="fa fa-circle-o"></i> <?php echo lang('menu_nav_transactions_list_all') ?></a></li>
					<li><a href="<?php echo base_url('admin/transactions/add') ?>"><i class="fa fa-circle-o"></i> <?php echo lang('menu_nav_transactions_add') ?></a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-cog"></i>
					<span><?php echo lang('menu_nav_settings') ?></span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url('admin/operators/list_all') ?>"><i class="fa fa-circle-o"></i> <?php echo lang('menu_nav_operators') ?></a></li>
					<li><a href="<?php echo base_url('admin/prices/list_all') ?>"><i class="fa fa-circle-o"></i> <?php echo lang('menu_nav_prices') ?></a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
  </aside>