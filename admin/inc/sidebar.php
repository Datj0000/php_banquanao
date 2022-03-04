<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li style="margin-top: 20px;">
					<a href="index.php" class=""><i class="fa fa-area-chart" aria-hidden="true"></i>
						<span>Thống kê</span></a>
				</li>
				<li>
					<a href="commentlist.php" class=""><i class="fa fa-commenting-o" aria-hidden="true"></i>
						<span>Bình luận</span></a>
				</li>
				<li>
					<a href="couponlist.php" class=""><i class="fa fa-code" aria-hidden="true"></i>
						<span>Mã giảm giá</span></a>
				</li>
				<li>
					<a href="catlist.php" class=""><i class="fa fa-list" aria-hidden="true"></i>
						<span>Danh mục</span></a>
				</li>
				<li>
					<a href="productlist.php" class=""><i class="fa fa-product-hunt" aria-hidden="true"></i>
						<span>Sản phẩm</span></a>
				</li>
				<li>
					<a href="#subPages1" data-toggle="collapse" class=""><i class="fa fa-television" aria-hidden="true"></i>
						<span>Giao diện</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
					<div id="subPages1" class="collapse ">
						<ul class="nav">
						<li><a href="display.php" class="">Trang chủ</a></li>
							<li><a href="footer.php" class="">Footer</a></li>
							<li><a href="about.php" class="">Giới thiệu</a></li>
							<li><a href="sliderlist.php" class="">Slider</a></li>
							<li><a href="brandlist.php" class="">Tài trợ</a></li>
						</ul>
					</div>
				</li>
				<?php
				if ($adminRole == 0) {
				?>
					<li>
						<a href="#subPages2" data-toggle="collapse" class=""><i class="fa fa-user" aria-hidden="true"></i>
							<span>Nhân viên</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
						<div id="subPages2" class="collapse ">
							<ul class="nav">
								<li><a href="staffadd.php" class="">Tạo tài khoản</a></li>
								<li><a href="stafflist.php" class="">Danh sách nhân viên</a></li>
							</ul>
						</div>
					</li>
				<?php
				}
				?>
			</ul>
		</nav>
	</div>
</div>
<div class="main">
	<div class="main-content">
		<div class="container-fluid">