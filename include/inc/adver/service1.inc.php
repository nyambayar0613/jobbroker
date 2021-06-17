<?php
if(!$design['main_platinum_use']) return false;

$_width = $design['main_platinum_row'];
$_height = $design['main_platinum_row2'];
$_total = $design['main_platinum_total'];
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = " and `wr_service_platinum` >= curdate()";
$con .= $job_where['where'];
$q = "alice_alba where " . $netfu_mjob->job_where . $con;
$query = sql_query("select * from ".$q." order by wr_jdate desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = sql_num_rows($query);
$_total = $netfu_util->get_remain($list_num, $_box_num, $_width);

$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($list_num/($_width*$_height));

//$_count = '<em>'.$netfu_util->start_slide_num($total['c']).'</em>/'.$paging_group.'건';
$_count = '';
if($total['c']>0) { ?>
<!--<style type="text/css">
.service1__ li { border:1px solid #<?/*=$design['main_platinum_border_color'];*/?> !important; }
.service1__ .bg_ { background-color:#<?/*=$design['main_platinum_background_color'];*/?>; }
.service1__ a,
.service1__ div,
.service1__ span,
.service1__ p { color:#<?/*=$design['main_platinum_font_color'];*/?>; }


.service1__ ul li.gold2 { border:1px solid #<?/*=$design['main_platinum_border_gold_color'];*/?> !important; z-index:99 !important; }
.service1__ ul li.gold2 .bg_ { background-color:#<?/*=$design['main_platinum_background_gold_color'];*/?>; }
.service1__ ul li.gold2 a,
.service1__ ul li.gold2 div,
.service1__ ul li.gold2 span,
.service1__ ul li.gold2 p { color:#<?/*=$design['main_platinum_font_gold_color'];*/?>; }
</style>-->
<?php } ?>
<section class="service1__ cont_box platinum_con">
	<!--<h2>
        <span class="tit_ico">
            <img src="/images/<?/*=$netfu_util->icon_tit('title_icon01');*/?>.png" alt="">
        </span>
        Пилатинум ажлын зар
        <span class="bt_box"><?/*=$_count;*/?>
            <a href="<?/*=NFE_URL;*/?>/etc/adver.php">
                <span class="btn">광고안내
                    <img src="<?/*=NFE_URL;*/?>/images/chevron.png" alt="광고안내">
                </span>
            </a>
        </span>
    </h2>-->
	<div class="cycle-slideshow" 
	data-cycle-pause-on-hover="true"
	data-cycle-slides="ul.platinum_box"
	data-cycle-timeout=0
	data-cycle-swipe=true
	data-cycle-swipe-fx=scrollHorz
	data-cycle-pager="#platinum_con-page"
	data-cycle-pager-template="<a> {{slideNum}} </a>"
	>
	<?php
	// li의ㅣ class ->  class="gold1",  class="gold2"
        switch($total['c']<=0) {
            case true: ?>
                <li>
                    <div class="text_box2">
                        <div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
                    </div>
                </li>
            <?php
            break;

            default:
                for($i=0; $i<$_total; $i++) {
                    $row = sql_fetch_array($query);
                    echo $i%$_box_num==0 ? '<ul class="platinum_box cont_box_inner" style="width:100% !important;">'."\n" : '';
                    $_gold = $row['wr_service_platinum_main_gold']>=date("Y-m-d") ? 'gold2' : 'gold1'; // : 골드 클래스값
                ?>
                <li style="width:<?=$_li_width;?>%" class="<?=$_gold;?>">
                    <?php include NFE_PATH."/include/inc/job_box1.inc.php"; ?>
                </li>
                <?php echo $i%$_box_num==$_box_num-1 ? '</ul>'."\n" : ''; }
                break;
        }
	?>
	</div>
	<div class="paging_con cf"><div id="platinum_con-page" class="paging center"></div></div>
</section>
<!-- //플래티넘 -->

<div class="col-lg-12 mt-4 pt-2">
    <div class="job-list-box border rounded">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="company-logo-img">
                        <img src="/images/featured-job/img-1.png" alt="" class="img-fluid mx-auto d-block">
                    </div>
                </div>
                <div class="col-lg-7 col-md-9">
                    <div class="job-list-desc">
                        <h6 class="mb-2"><a href="#" class="text-dark">Web Designer, Graphic Designer, UI/UX Designer & Art</a></h6>
                        <p class="text-muted mb-0"><i class="mdi mdi-bank mr-2"></i>Web Themes.pvt.Ltd</p>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item mr-3">
                                <p class="text-muted mb-0"><i class="mdi mdi-map-marker mr-2"></i>Confederate Drive Potsdam, NY 13676</p>
                            </li>

                            <li class="list-inline-item">
                                <p class="text-muted mb-0"><i class="mdi mdi-clock-outline mr-2"></i>1 Minute ago</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="job-list-button-sm text-right">
                        <span class="badge badge-success">Full-Time</span>

                        <div class="mt-3">
                            <a href="#" class="btn btn-sm btn-primary">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>