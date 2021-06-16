<?php
// : $com_member 변수는 /job/detail.php에 있음
$mb_id = $get_alba['wr_id'];
$no = $get_alba['no'];
$category_list = $category_control->category_codeList('company_form', " `rank` asc ");

$photo_list = $user_control->member_photo_list($mb_id," and `company_no` = " . $no," order by `no` asc ");
$mb_homepage = $com_member['mb_homepage'];
$mb_address = $com_member['mb_biz_address0']." ".$com_member['mb_biz_address1'];
$mb_phone = $com_member['mb_biz_phone'];
$mb_hphone = $com_member['mb_biz_hphone'];
$mb_fax = $com_member['mb_biz_fax'];
$mb_biz_no = $com_member['mb_biz_no'];
$mb_email = $com_member['mb_biz_email'];

$fax_arr = explode("-", $mb_fax);
$hphone_arr = explode("-", $mb_hphone);
$biz_no_arr = explode("-", $mb_biz_no);

$service_check = $service_control->service_check('etc_alba');
$open_is_pay = $service_check['is_pay'];
$service_open = $utility->valid_day($member_service['mb_service_alba_open']);	// 공고 열람 서비스 기간 체크
// 열람권 기간/건수 확인
$is_open_service = false;
if( $utility->valid_day($member_service['mb_service_alba_open']) ){
	$is_open_service = $member_service['mb_service_alba_open'];
}
$is_open_count = false;
if( $utility->valid_day($member_service['mb_service_alba_open']) && $member_service['mb_service_alba_count'] ){	// 건수 사용이 가능하다면
	$is_open_count = $member_service['mb_service_alba_count'];
}
// 채용공고 열람 정보 저장
if($is_open_service && !$is_open_count)	// 열람 기간은 있고, 열람 건수는 없는 경우
	$alba_individual_control->open_insert($no,$get_alba['wr_id'],"alba");

$is_open_alba = $alba_resume_user_control->is_open_resume('alba',$member['mb_id'],$get_alba['wr_id'], $no);	// 열람한 정보가 있는지

$wr_is_open = false;
$wr_mb_address = $wr_mb_phone = $wr_mb_hphone = $wr_mb_fax = "";
if($open_is_pay){	// 열람서비스를 사용한다면 
	if($is_open_count && !$is_open_alba){	 // 열람 건수가 있다면
		//$wr_mb_phone = $wr_mb_fax = $wr_mb_address = "<a href=\"javascript:void(0);\" onclick=\"open_alba('".$no."','".$get_alba['wr_id']."','alba', '".$is_open_count."');\"><img alt=\"열람권사용\" src=\"../images/icon/icon_used.gif\"></a>";
		$wr_mb_address = $wr_mb_phone = $wr_mb_hphone = $wr_mb_fax = "<img alt=\"Үйлчилгээ ашиглах\" src=\"../images/icon/icon_used.gif\">";
	} else if( $service_open || $is_open_alba ) {
		$wr_mb_address = $mb_address;
		$wr_mb_phone = $mb_phone;
		$wr_mb_hphone = $mb_hphone;
		$wr_mb_fax = $mb_fax;
	} else {
		$wr_mb_address = $wr_mb_phone = $wr_mb_hphone = $wr_mb_fax = "<img width=\"41\" height=\"14\" alt=\"Private\" src=\"../images/icon/icon_closed.gif\">";
	}
} else {
	$wr_mb_address = $mb_address;
	$wr_mb_phone = $mb_phone;
	$wr_mb_hphone = $mb_hphone;
	$wr_mb_fax = $mb_fax;
}

$mb_biz_type = $category_control->get_categoryCodeName($com_member['mb_biz_type']);
$mb_biz_form = $category_control->get_categoryCodeName($com_member['mb_biz_form']);
$mb_biz_success = $category_control->get_categoryCodeName($com_member['mb_biz_success']);
?>
<div class="tab-box tab4-box job_tab4">
	<div>
		<table>
		<tr>
			<th>Байгуулагын нэр</th>
			<td><?=stripslashes($com_member['mb_company_name']);?></td>
		</tr>
		<tr>
			<th>Захирлын нэр</th>
			<td><?php echo $com_member['mb_ceo_name'];?></td>
		</tr>
		<tr>
			<th>Байгууллагын төрөл</th>
			<td><?php echo $mb_biz_type;?></td>
		</tr>
		<tr>
			<th>Холбогдох дугаар</th>
			<td><?=$wr_mb_phone;?></td>
		</tr>
		<tr>
			<th>Утасны дугаар</th>
			<td><?=$wr_mb_hphone;?></td>
		</tr>
		<tr>
			<th>Байгууллагын хаяг</th>
			<td><?=trim($wr_mb_address);?></td>
		</tr>
		<?php
		if(is_array($category_list)) { foreach($category_list as $k=>$v) {

			if($v['view']=='no') continue; // : 사용안함

			switch($v['name']) {
				case "Компанийн бүртгэлийн дугаар":
		?>
		<tr>
			<th>Компанийн бүртгэлийн дугаар</th>
			<td><?php echo $utility->make_pass_($mb_biz_no);?></td>
		</tr>
		<?php
					break;


				case "Шуудангын дугаар":
					if(!preg_replace("/-/", "", $wr_mb_fax)) break;
		?>
		<tr>
			<th>Шуудангын дугаар</th>
			<td><?php if(preg_replace("/-/", "", $wr_mb_fax)) echo $wr_mb_fax;?></td>
		</tr>
		<?php
					break;


				case "Вэбсайтын хаяг":
					if(!$mb_homepage) break;
		?>
		<tr>
			<th>Нүүр хуудас</th>
			<td><a href="<?=$netfu_util->get_homepage($mb_homepage);?>" target="_blank"><?=$netfu_util->get_homepage($mb_homepage);?></a></td>
		</tr>
		<?php
					break;


				case "И-мэйл":
					$_mb_email = explode("@", $mb_email);
					if(!$_mb_email[0]) break;
		?>
		<tr>
			<th>И-мэйл</th>
			<td><?=$mb_email;;?></td>
		</tr>
		<?php
					break;


				case "Жагсаалтанд орсон эсэх":
		?>
		<tr>
			<th>Жагсаалтанд орсон эсэх</th>
			<td><?php echo $mb_biz_success;?></td>
		</tr>
		<?php
					break;


				case "Байгуулагын төрөл":
		?>
		<tr>
			<th>Байгуулагын төрөл</th>
			<td><?php echo $mb_biz_form;?></td>
		</tr>
		<?php
					break;


				case "Бизнесийн үндсэн мэдээлэл":
		?>
		<tr>
			<th>Бизнесийн үндсэн мэдээлэл</th>
			<td><?php echo $com_member['mb_biz_content'];?></td>
		</tr>
		<?php
					break;


				case "Байгуулагдсан он":
					if(!$com_member['mb_biz_foundation']) break;
		?>
		<tr>
			<th>Байгуулагдсан он</th>
			<td><?=$com_member['mb_biz_foundation'];?>жил</td>
		</tr>
		<?php
					break;


				case "Ажилчдын тоо":
					if(!$com_member['mb_biz_member_count']) break;
		?>
		<tr>
			<th>Ажилчдын тоо</th>
			<td><?=$com_member['mb_biz_member_count'];?>хүн</td>
		</tr>
		<?php
					break;


				case "Үндсэн хөрөнгө":
					if(!$com_member['mb_biz_stock']) break;
		?>
		<tr>
			<th>Үндсэн хөрөнгө</th>
			<td><?php echo $com_member['mb_biz_stock'];?></td>
		</tr>
		<?php
					break;


				case "Ашиг":
					if(!$com_member['mb_biz_sale']) break;
		?>
		<tr>
			<th>Ашиг</th>
			<td><?php echo $com_member['mb_biz_sale'];?></td>
		</tr>
		<?php
					break;
			}
		} }
		?>
		</table>
	</div>



	<?php
	if($com_member['mb_biz_vision'] || $com_member['mb_biz_vision']) {
	?>
	<div class="tab4-box2 cf">
		<?php
		if($com_member['mb_biz_vision']) {
		?>
		<dl>
			<dt class="intro">Байгууллагын тухай, алсын хараа</dt>
			<dd>
				<?php echo nl2br(stripslashes($com_member['mb_biz_vision']));?>
			</dd>
		</dl>
		<?php }
		if($com_member['mb_biz_vision']) {
		?>
		<dl>
			<dt class="intro">Компанийн түүх, гүйцэтгэл</dt>
			<dd>
				<?php echo nl2br(stripslashes($com_member['mb_biz_result']));?>
			</dd>
		</dl>
		<?php
		}?>
	</div>
	<?php }?>
</div>