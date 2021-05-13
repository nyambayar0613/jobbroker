<?php
$_banner = $banner_control->get_banner_for_position($_banner);
if($_banner) {
?>
<div class="banner01">
<!-- <a href="#"><img src="images/banner4.jpg" alt=""></a> -->
<?=$_banner;?>
</div>
<!-- 일반형 구인정보 -->
<?php
}
unset($_banner);
?>