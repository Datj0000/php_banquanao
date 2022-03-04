<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "110172217964491");
  chatbox.setAttribute("attribution", "biz_inbox");
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v11.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
<div class="footer" style="width: 100%;">
<div class="container">
    <div class="row" style="display: flex;">
        <?php
        $get_footer = $footer->show_footer();
        if ($get_footer) {
            while ($result = $get_footer->fetch_assoc()) {
        ?>
                <div class="footer-col-1">
                    <h3>Thông tin liên hệ</h3>
                    <ul>
                        <li class="footer__link">Email: <a class="footer__item" href="mailto:<?php echo $result['mail'] ?>"><?php echo $result['mail'] ?></a></li>
                        <li class="footer__link">Số điện thoại: <a class="footer__item" href="tel:+<?php echo $result['phone'] ?>"><?php echo $result['phone'] ?></a></li>
                        <li class="footer__link">Địa chỉ: <a class="footer__item" href="http://" target="_blank" hrel="noopener noreferrer"><?php echo $result['address'] ?></a></li>
                    </ul>
                </div>
                <div class="footer-col-2">
                    <img src="admin/uploads/<?php echo $result['image'] ?>">
                    <p style="max-width: 600px; display:block; margin: 0 auto"><?php echo $result['title'] ?></p>
                </div>
                <div class="footer-col-3">
                    <h3>Follow us</h3>
                    <ul style="text-align: justify;">
                        <li class="footer__link"><a class="footer__item" target="_blank" href="<?php echo $result['facebook'] ?>"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a></li>
                        <li class="footer__link"><a class="footer__item" target="_blank" href="<?php echo $result['youtube'] ?>"><i class="fa fa-youtube-play" aria-hidden="true"></i></i> Youtube</a></li>
                        <li class="footer__link"><a class="footer__item" target="_blank" href="<?php echo $result['twitter'] ?>"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</a></li>
                        <li class="footer__link"><a class="footer__item" target="_blank" href="<?php echo $result['instagram'] ?>"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>
                    </ul>
                </div>
    </div>
    <hr>
    <!-- <p class="Copyright">Copyright 2021 - By HaiDang</p> -->
<?php
            }
        }
?>
</div>
</div>
<style>
.footer__item {
    display: inline-block;
}


.footer__link {
    color: #f7f7f7;
    text-decoration: none;
    border-radius: 5rem;
    transition: all .2s;
    z-index: 100;
}
.footer__item:hover,
.footer__item:hover .footer__link, 
.footer__item:active .footer__link{
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.4);
    transform: rotate(5deg) scale(1.05);
    background-color: #000;
}
</style>
<script type="text/javascript" src="js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>

</html>