<?php
		/*
		* /application/nad/alba/process/comment.php
		* @author Harimao
		* @since 2013/10/21
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Alba comment process
		* @Comment :: 알바 댓글 처리 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		switch($mode){

			## 댓글 등록
			case 'insert':
			break;

			## 댓글 수정
			case 'update':
			
				$wr_content = $_POST['wr_content'];
				$vals['wr_content'] = $wr_content;

				$result = $comment_control->comment_update($vals,$no);

				echo $result;

			break;

			## 댓글 삭제 (단수)
			case 'delete':

				$result = $comment_control->comment_delete($no,true);

				echo $result;

			break;

			## 댓글 공고 기준 삭제 (복수)
			case 'sel_comment_delete':
				/*
				 delete from `alice_comment` where `wr_parent` = '49' 
				 delete from `alice_comment` where `wr_no` = '49' 
				*/
				
				print_R($_POST);

				$nos = explode(',',$no);

				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $comment_control->comment_delete($nos[$i],true);
				}

				echo $result;

			break;

			## 댓글 삭제 (복수)
			case 'sel_delete':

				$nos = explode(',',$no);

				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $comment_control->comment_delete($nos[$i],true,true);
				}
			
				echo $result;

			break;
		}
?>