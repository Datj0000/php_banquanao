<div class="small-container" style="margin-bottom: 100px;">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <?php
                $idcus = Session::get('customer_id');
                $get_customers = $cs->show_customers($idcus);
                if ($get_customers) {
                    while ($result = $get_customers->fetch_assoc()) {
                ?>
                        <div class="profile-userpic">
                            <?php
                            if ($result['image']) {
                            ?>
                                <img src="admin/uploads/<?php echo $result['image'] ?>" class="img-responsive" alt="">
                            <?php
                            } else {
                            ?>
                                <img style="border: 1px black solid;" src="images/user.jpg" class="img-responsive" alt="">
                            <?php
                            }
                            ?>
                        </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?php echo $result['name'] ?>
                            </div>
                            <!-- <div class="profile-usertitle-job">
                                Developer
                            </div> -->
                        </div>

                <?php
                    }
                }
                ?>
                <div style="" class="profile-usermenu">
                    <ul class="nav">
                        <a href="ho-so.html">
                            <li class="">
                                <i class="fa fa-user"></i>
                                <span>Hồ sơ</span>
                            </li>
                        </a>
                        <a href="don-hang.html">
                            <li>
                                <i class="fa fa-list"></i>
                                <span>Đơn hàng</span>
                            </li>
                        </a>
                        <a href="yeu-thich.html">
                            <li>
                                <i class="fa fa-heart-o"></i>
                                <span>Yêu thích</span>
                            </li>
                        </a>
                        <a href="dang-nhap.html?customer_id=<?php Session::get('customer_id') ?>">
                            <li>
                                <i class="fa fa-sign-out"></i>
                                <span>Đăng xuất</span>
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(
                function() {
                    //sticky nav
                    $('.title2').waypoint(
                        function(direction) {
                            if (direction == "down") {
                                $('.navbar').addClass('sticky');
                            } else {
                                $('.navbar').removeClass('sticky');
                            }
                        }, {
                            offset: '100px'
                        });
                }
            );
        </script>
        <div class="col-md-9">
            <div class="profile-content">