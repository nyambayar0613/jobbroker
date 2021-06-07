<?php
		/*
		* /application/nad/member/process/search.php
		* @author Harimao
		* @since 2013/11/06
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Member Search
		* @Comment :: 회원 검색
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];

		$mb_type = $_POST['mb_type'];
		$search_keyword = $_POST['search_keyword'];


		switch($mode){

			## 회원 검색
			case 'search':

			$con = " where `mb_type` = '".$mb_type."' and ( INSTR(`mb_id`, '".$search_keyword."') or INSTR(`mb_name`, '".$search_keyword."') or INSTR(`mb_email`, '".$search_keyword."') ) and `mb_left` = 0 and `is_delete` = 0";
			$member_list = $member_control->member_list("","",$con);

			if($member_list['result']){
				foreach($member_list['result'] as $val){
?>
				<li style="line-height:20px" onMouseOver="this.className='bg hand'" onMouseOut="this.className=''" onClick="get_member('<?php echo $val['mb_id']?>');"><b>ㆍ</b><?php echo stripslashes($val['mb_name']);?>(<?php echo $val['mb_id'];?>) / <?php echo $val['mb_email'];?></li>
<?php
				}	// foreach end.
			} else {
?>
				<li style="line-height:20px"><b>ㆍ</b>검색 결과가 없습니다.</li>
<?php
			}	// if end.

			break;

			## 등록 공고 추출
			case 'alba_list':

				$mb_id = $_POST['mb_id'];

				$get_alba = $alba_control->get_alba_for_id($mb_id);

				$result  = "<select name='sel_alba' id='sel_alba' onchange=\"update_alba('load',this.value,'".$mb_id."');\">";
				$result .= "<option value=''>채용공고선택</option>";
				if($get_alba){
					foreach($get_alba as $val){
						$result .= "<option value='".$val['no']."'>".stripslashes($val['wr_subject'])."</option>";
					}
				}
				$result .= "</select>";
			
				echo $result;

			break;

			## 담당자 검색
			case 'managers':

				$manager_info = $company_manager_control->__ManagerList("",""," where `wr_id` = '".$mb_id."' ");

				$result = array();

				if($manager_info['result']){
					$result['result'] = true;
					$result['manager_list']  = "<select name=\"manager_sel\" id=\"manager_sel\" onchange=\"manager_sels(this);\">";
					$result['manager_list'] .= "<option value=\"\">담당자명</option>";
					foreach($manager_info['result'] as $val){
						$result['manager_list'] .= "<option value=\"".$val['no']."\">".stripslashes($val['wr_name'])."</option>";
					}
					$result['manager_list'] .= "</select>";
				} else {
					$result['result'] = false;
				}

				
				echo implode($result,"//");

			break;

			## 담당자 정보
			case 'manager_info':

				$no = $_POST['no'];

				$manager = $company_manager_control->get_manager($no);
				if($manager){
					$result = true;
				} else {
					$result = false;
				}

				echo $result."/".json_encode($manager);

			break;

			## 등록 이력서 추출
			case 'resume_list':
				
				$mb_id = $_POST['mb_id'];

				$get_resume = $alba_resume_control->get_resume_for_id($mb_id);

				$result  = "<select name='sel_resume' id='sel_resume' onchange=\"update_resume('load',this.value,'".$mb_id."');\">";
				$result .= "<option value=''>이력서선택</option>";
				if($get_resume){
					foreach($get_resume as $val){
						$result .= "<option value='".$val['no']."'>".stripslashes($val['wr_subject'])."</option>";
					}
				}
				$result .= "</select>";
			
				echo $result;

			break;

			## 회사정보 select 생성
			case 'company_info':

				$mb_id = $_POST['mb_id'];
			
				$page = ($page) ? $page : 1;
				$con = " where `mb_id` = '".$mb_id."' ";
				$company_list = $member_control->__CompanyList($page,"",$con);

				$result = "<select name=\"company_info\" onchange=\"company_info_load(this);\">";
				$result .= "<option value=\"\">기업정보 선택</option>";
				foreach($company_list['result'] as $val){
					$result .= "<option value=\"".$val['no']."\">".$val['mb_ceo_name']."/".$val['mb_company_name']."</option>";
				}
				$result .= "</select>";

				echo $result;

			break;

		}	// switch end.
?>