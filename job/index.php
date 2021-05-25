<?php
$head_title = "구인정보";
if($_GET['code']=='hurry') $head_title = "급구 구인정보";
if($_GET['code']=='area') $head_title = "지역별 구인정보";
if($_GET['code']=='job_type') $head_title = "업직종별 구인정보";
if($_GET['code']=='subway') $head_title = "역세권별 구인ррлл";
if($_GET['code']=='univ') $head_title = "대학가별 구인정보";
if($_GET['code']=='date') $head_title = "기간별 구인정보";
if($_GET['code']=='pay') $head_title = "급여별 구인정보";
if($_GET['code']=='etc') $head_title = "대상별 구인정보";
if($_GET['code']=='search') $head_title = "상세검색 구인정보";
include_once "../include/top.php";

// : 급구는 이 함수안에서 검색합니다.
$job_where = $netfu_mjob->job_search_func();
?>


<!-- 검색 -->
<?php
// : 상세검색폼
include NFE_PATH.'/include/inc/job_search.detail.php';
// : 일반검색
//else include NFE_PATH.'/include/inc/job_search.inc.php';




// : 플래티넘
$_banner = 'alba_platinum';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service1.inc.php';



// : 그랜드
$_banner = 'alba_grand';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service2.inc.php';



// : 스페셜
$_banner = 'alba_special';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service3.inc.php';



// : 일반 리스트
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