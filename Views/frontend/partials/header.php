<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <nav>
            <ul class="header__left nav-bar">
                <li class="nav-bar__item"><a href="?controller=product&action=index">Trang chủ</a></li>
                <li style="margin-right: 186px;" class="nav-bar__item"><a href="?controller=cart&action=index">Giỏ hàng</a></li>
                <li class="nav-bar__item">
					<label style="font-size: 20px;margin-right: 10px;" for="search">Tìm kiếm</label>
					<input style="padding: 8px 12px; font-size: 16px; " id="search" type="text" name="search" value="<?php if(isset($_GET['search'])) {echo $_GET['search'];}else {echo '';}?>">
				</li>  
            </ul>
            <ul class="header__right nav-bar">
                <?php
                // Kiểm tra xem session 'user' đã được thiết lập hay chưa
                if (isset($_SESSION['user'])) {
                    echo '<li style="position: relative;" class="nav-bar__item header__user" id="userDropdown"><a href="#">Welcome ' . $_SESSION['user'] . '</a>
							<div class="dropdown-content" id="userDropdownContent">
								<ul>
									<li>
										<a href="?controller=payment&action=index">Đơn mua của tôi</a>
									</li>
									<li><a href="#">Tài khoản</a></li>
								</ul>
							</div>
						</li>';
					
					echo '<li class="nav-bar__item"><a href="?controller=login&action=logout">Đăng xuất</a></li>';
                } else {
                    echo '<li class="nav-bar__item"><a href="?controller=login&action=index">Đăng nhập</a></li>';
                    echo '<li class="nav-bar__item"><a href="?controller=register&action=index">Đăng ký</a></li>';
                }
                ?>
            </ul>
        </nav>        
    </div>
</nav>


<!-- <nav class="navbar navbar-expand-lg bg-light">
	<div class="container">
		<a class="navbar-brand" href="#">Trang chủ</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
				<a class="nav-link active" aria-current="page" href="#">Giỏ hàng</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
				</li>
				
			</ul>
		</div>
		<ul class="ml-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					Dropdown
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="#">Action</a></li>
					<li><a class="dropdown-item" href="#">Another action</a></li>
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="#">Something else here</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav> -->


