<?php
$head_title = "Ажлын байрны мэдээлэл";
if($_GET['code']=='hurry') $head_title = "Яаралтай ажилд авна";
if($_GET['code']=='area') $head_title = "Ажлын байрны мэдээлэл байршилаар";
if($_GET['code']=='job_type') $head_title = "Ажлын байрны мэдээлэл салбараар";
if($_GET['code']=='subway') $head_title = "Автобусны буудалтай ойр";
if($_GET['code']=='univ') $head_title = "Их сургуультай ойр";
if($_GET['code']=='date') $head_title = "Ажлын байрны мэдээлэл хугацаагаар";
if($_GET['code']=='pay') $head_title = "Цалин, хөлс";
if($_GET['code']=='etc') $head_title = "Ажлын байрны нөхцөл мэдээлэл";
if($_GET['code']=='search') $head_title = "Дэлгэрэнгүй";
include_once "../include/top.php";

// : 'Яаралтай' утгыг энэ функцээс хайж болно .
$job_where = $netfu_mjob->job_search_func();
?>

<!-- JOB LIST START -->
<section class="section pt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="section-title text-center mb-4 pb-2">
                    <h4 class="title title-line pb-5">Available job for you</h4>
                    <p class="text-muted para-desc mx-auto mb-1">Post a job to tell us about your project. We'll quickly match you with the right freelancers.</p>
                </div>
            </div>
        </div>



<!-- хайх -->
<?php
// : дэлгэрэнгүй хайлтын өнгө
include NFE_PATH.'/include/inc/job_search.detail.php';
// : энгийн өнгө
//else include NFE_PATH.'/include/inc/job_search.inc.php';




// : платинум
$_banner = 'alba_platinum';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service1.inc.php';



// : grand
$_banner = 'alba_grand';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service2.inc.php';



// : онцгой
$_banner = 'alba_special';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service3.inc.php';



// : энгийн лист
$_banner = 'alba_job_list';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/em_list.inc.php';
?>


<?php
$_banner = 'alba_job_list_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';


include "../include/job_detail.box.php";
include "../include/tail.php";
?>

    </div>
</section>
