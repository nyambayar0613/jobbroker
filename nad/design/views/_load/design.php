<?php
		/*
		* /application/nad/design/views/_load/design.php
		* @author Harimao
		* @since 2014/03/07
		* @last update 2015/04/02
		* @Module v3.5 ( Alice )
		* @Brief :: Design info
		* @Comment :: 디자인 설정 정보 레이어
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$type = $_POST['type'];

		switch($mode){

			## 각종 서비스 안내
			case 'service_content':
				$content_arr = array( 
					"main_platinum_content" => "플래티넘 서비스 내용", "main_prime_content" => "프라임 서비스 내용", "main_grand_content" => "그랜드 서비스 내용", "main_banner_content" => "배너형 서비스 내용", "main_list_content" => "리스트형 서비스 내용",
					"main_busy_content" => "급구 서비스 내용", "main_focus_content" => "포커스 서비스 내용", "sub_platinum_content" => "플래티넘 서비스 내용", "sub_banner_content" => "배너형 서비스 내용", "sub_list_content" => "리스트형 서비스 내용",
					"sub_focus_content" => "포커스 인재정보 서비스 내용", "sub_busy_content" => "급구 인재정보 서비스 내용", "alba_jump_content" => "채용공고 점프 서비스 내용", "resume_jump_content" => "이력서 점프 서비스 내용", "alba_open_content" => "채용공고 열람 서비스 내용", "resume_open_content" => "이력서 열람 서비스 내용", "alba_free_content" => "채용공고 무료등록 서비스안내", "resume_free_content" => "이력서 무료등록 서비스안내", "main_basic_content" => "채용 리스트 서비스안내", "main_rbasic_content" => "인재 리스트 서비스안내", 
					"sub_basic_content" => "일반리스트 서비스안내", "sub_rbasic_content" => "일반리스트 서비스안내", "sub_rbasic_content" => "일반리스트 서비스안내", "etc_alba_sms_content" => "기업회원 SMS 충전 서비스안내", "etc_resume_sms_content" => "개인회원 SMS 충전 서비스안내",
				);
?>
				<div id="pop_content" class="bocol lnb_col" style="top:10%;left:33%;display:;">
				
				<form name="ServiceContentRegistFrm" method="post" id="ServiceContentRegistFrm" action="./process/design.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="service_update" id="mode"/><!-- 팝업 등록 -->
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="uid" value="<?php echo $admin_info['uid'];?>"/>
				<input type="hidden" name="no" value="<?=$design['no']?>"/><!-- 현재 설정 no -->
				<input type="hidden" name="service" value="<?php echo $type;?>"/>

					<dl class="ntlt lnb_col m0 hand" id="addFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t"><?php echo $content_arr[$type];?> 수정
						<a onClick="MM_showHideLayers('pop_content','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<table width="750" class="bg_col">
					<col>
					  <tr>
						<td class="pdlnb2"><?php echo $utility->make_cheditor($type, $design[$type]);	// 에디터 생성?></td>
					  </tr>
					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_content','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>

			</div>
<?php
			break;
		}

?>