<?php
		/*
		* /application/nad/board/views/_load/layer.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Board load process
		* @Comment :: SMS, Email 등 발송을 위한 폼, 기타 레이어 로드
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];	// 여기에서 no 는 alice_cs 테이블의 주키 no 값이다
	
		switch($mode){

			## 게시판 카테고리(분류) 설정
			case 'board_category':

				$board = $board_config_control->get_board($no);	// 게시판 정보 (no 기준 추출)
				$bo_table = $board['bo_table'];
				$get_category = $category_control->pcode_List($bo_table);
?>
				<div id="board_category" class="bocol lnb_col" style="top:5%;left:33%;display:none;">
					<dl class="ntlt lnb_col m0 hand" id="categoryFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">게시판 분류설정
						<a onClick="MM_showHideLayers('board_category','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table class="ttlt" width="700">
					<col span="2" width="40"><col><col width="70"><col span="2" width="56">
					<tr class="bg">
						<td>출력</td>
						<td>순서</td>  
						<td>분류명</td>
						<td>게시물수</td>
						<td>수정</td>
						<td class="e">삭제</td>
					</tr>					
						<tbody id='category_lists'>
						<?php if(!$get_category){?>
						<tr><td colspan="6" class="stlt"></td></tr>
						<?php } else { ?>
						<?php 
							foreach($get_category as $category){ 
							$name = $utility->remove_quoted($category['name']);	 // (쌍)따옴표 등록시 필터링
						?>
						<tr class='category_lists' no='<?php echo $category['no'];?>'>
							<td><input name="view" type="checkbox" value="yes" <?php echo ($category['view']=='yes')?'checked':'';?> id="cateView_<?php echo $category['no'];?>" onclick="cate_view('<?php echo $category['no']?>');"></td>
							<td class="none num3">
								<a onclick="change_cate_rank('up',this);">▲</a>
								<a onclick="change_cate_rank('down',this);">▼</a>
							</td>
							<td class="tl"><input name="name" type="text" class="txt w100" value="<?php echo $name;?>" id="cateName_<?php echo $category['no'];?>"></td>
							<td class="num3"><?php echo number_format($category['hit']);?></td>
							<td><a onClick="cate_update('<?php echo $category['no'];?>');"><img src="../../images/btn/19_05.gif"></a></td>
							<td class="e"><a onClick="cate_delete('<?php echo $category['no'];?>','<?php echo $category['p_code'];?>');"><img src="../../images/btn/19_06.gif"></a></td>
						</tr>
						<?php } // foreach end.?>
						<?php } // if end.?>
						</tbody>

						<form name="boardCategoryFrm" method="post" id="boardCategoryFrm" action="./process/cate.php">
						<input type="hidden" name="mode" value="insert"/><!-- 카테고리 mode -->
						<input type="hidden" name="type" value="board" id="category_type"/>
						<input type="hidden" name="p_code" value="<?php echo $bo_table?>"/>
						<input type="hidden" name="ajax" value="1"/>
						<input type="hidden" name="no" value="<?php echo $no;?>"/>
						<tr class="bg_col" id="category_input">
							<td><input name="view" type="checkbox" value="yes" checked></td>
							<td class="tl" colspan="3"><input name="name" type="text" class="txt w100" hname="분류명" required></td>
							<td><a onClick="cate_insert();"><img src="../../images/btn/19_01.gif"></a></td>
							<td class="e"><a onClick="cate_close();"><img src="../../images/btn/19_02.gif"></a></td>
						</tr>
						</form>

					</table>

					<dl class="pbtn">  
						<a onClick="MM_showHideLayers('board_category','','hide');"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>
				</div>
<?php
			break;

			## 메모 정보
			case 'memo':

				$member = $member_control->get_memberNo($no);
?>
				<div id="pop_memo" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1003">
				<form name="MemberMemoFrm" method="post" id="MemberMemoFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="memo"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>

					<dl class="ntlt lnb_col m0 hand" id="memoFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">관리자메모
						<a onClick="MM_showHideLayers('pop_memo','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<dl class="twrap"><textarea style="height:100px;width:690px" name="mb_memo"><?php echo stripslashes($member['mb_memo']);?></textarea></dl>  

					<dl class="pbtn">
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_memo','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>

				</form>
				</div>
<?
			break;

			## 이메일
			case 'email':

				$get_cs = $cs_control->get_cs($no);

				$wr_type = $_POST['wr_type'];
				$wr_subject  = "[" . $env['site_name'] . "] ";
				$wr_subject .= ($wr_type) ? "광고/제휴문의" : "고객문의";
				$wr_subject .= " '" . stripslashes($get_cs['wr_subject']) . "' 에 대한 답변을 드립니다.";
				
				// 메일 스킨
				$skin_name = ($wr_type) ? "concert" : "qna";
				$mail_skin = $design_control->get_mail_skin($skin_name);
				
				$_replaces = $cs_control->_replaces($no,$mail_skin['content']);	// 메일 내용 치환

				$vals['wr_aid'] = $admin_info['uid'];
				$vals['wr_aname'] = $admin_info['name'];
				$vals['wr_adate'] = $now_date;
				$cs_control->update_cs($vals,$no);	 // 답변 정보 업데이트
?>
				<div id="pop_mail" class="bocol lnb_col" style="top:5%;left:33%;display:none;z-index:1001">
				<form name="emailFrm" method="post" id="emailFrm" action="./process/cs.php">
				<input type="hidden" name="mode" value="email_send"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<input type="hidden" name="send_email" value="<?php echo $env['email'];?>"/>
				<input type="hidden" name="no" value="<?php echo $no;?>"/><!-- cs no 값을 넘겨야 한다. -->

					<dl class="ntlt lnb_col m0 hand" id="emailFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">메일보내기
						<a onClick="MM_showHideLayers('pop_mail','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="700" class="bg_col">
					<col width="60"><col>
					<tr>
						<td class="pdlnb1 ctlt">제목</td>
						<td class="pdlnb2"><input type="text" class="txt w100" name="subject" required hname="메일 제목" value="<?php echo $wr_subject;?>"></td>
					</tr>
					<tr>
						<td class="pdlnb1 ctlt">받는사람</td>
						<td class="pdlnb2">
							<input type="text" class="txt w50" name="receive_mail" required hname="받는사람 메일주소" value="<?php echo stripslashes($get_cs['wr_email']);?>">
						</td>
					</tr>
					<tr>
						<td class="pdlnb1 ctlt">내용</td>
						<td class="pdlnb2" id="contentBlock">
							<?php echo $utility->make_cheditor('content', $_replaces);	// 에디터 생성?>
						</td>
					</tr>  
					</table>

					<dl class="pbtn">  
						<img  src="../../images/btn/b23_07.png" class="ln_col hand" id="mailSendBtn">&nbsp;
						<a onClick="MM_showHideLayers('pop_mail','','hide')"><img src="../../images/btn/23_10.gif"></a>
					</dl>  

				</form>
				</div>
<?
			break;

			## POLL 등록/수정
			case 'poll_insert':
			case 'poll_update':
				$get_poll = $poll_control->get_poll($no);
				$poll_subject = stripslashes($get_poll['poll_subject']);
?>
				<div id="pop_poll" class="bocol lnb_col" style="top:5%;left:28%;display:none;">
				<form name="pollFrm" method="post" id="pollFrm" action="./process/poll.php">
				<input type="hidden" name="mode" value="<?php echo $mode;?>"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
				<?php if($mode=='poll_update'){ // 수정일때만 사용?> 
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<?php } ?>

					<dl class="ntlt lnb_col m0 hand" id="pollFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">설문조사 <?php echo ($mode=='poll_insert')?"등록":"수정";?>
						<span>응답항목은 입력된 항목만큼 출력됩니다.</span>
						<a onClick="MM_showHideLayers('pop_poll','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<table width="750" class="bg_col">
					<col width=80><col>
					<tr>
						<td class="ctlt">투표기간</td>
						<td class="pdlnb2">
							<input name="poll_wdate" type="text" class="tday" value="<?php echo ($mode=='poll_update')?$get_poll['poll_wdate']:'0000-00-00';?>" id="poll_wdate"> ~ 
							<input name="poll_edate" type="text" class="tday" value="<?php echo ($mode=='poll_update')?$get_poll['poll_edate']:'0000-00-00';?>" id="poll_edate">
						</td>
					</tr>
					<tr>
						<td class="ctlt">투표자</td>
						<td class="pdlnb2">
							<label><input name="poll_member" type="radio" value="0" class="radio" checked>회원 + 비회원</label> &nbsp;
							<label><input name="poll_member" type="radio" value="1" class="radio" <?php echo ($get_poll['poll_member']=='1')?'checked':'';?>>회원(로그인후 투표)</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">중복투표여부</td>
						<td class="pdlnb2">
							<label><input name="poll_overlap" type="radio" value="0" class="radio" checked>중복투표 불가</label> &nbsp;
							<label><input name="poll_overlap" type="radio" value="1" class="radio" <?php echo ($get_poll['poll_overlap']=='1')?'checked':'';?>>중복투표 가능</label>
						</td>
					</tr>
					<tr>
						<td class="ctlt">주제</td>
						<td class="pdlnb2"><input name="poll_subject" type="text" class="txt w100" style="ime-mode:active;" value="<?php echo $poll_subject;?>" required hname="주제"></td>
					</tr>
					<tr>
						<td class="ctlt">응답항목</td>
						<td class="pdlnb2">
							<ol class="ml20 pl2" id='poll_lists'>
								<?php 
									if($mode=='poll_update'){	// 수정일때 
										$poll_content = explode('|&|',$get_poll['poll_content']);
										$poll_content_cnt = count($poll_content);
										for($i=0;$i<$poll_content_cnt;$i++){
											$field_id = ($i >= 1) ? "id='field_".($i+1)."'" : "";	 // 1이 아닐때만
								?>
									<li <?php echo $field_id;?>><input name="content[]" type="text" class="txt w100" value="<?php echo stripslashes($poll_content[$i]);?>"></li>
								<?php 
										}
									} else {
								?>
								<li><input name="content[]" type="text" class="txt w100"></li>
								<?php } ?>
							</ol>
							<dd style='float:right'>
								<a onClick="field_add();" class="btn"><h1 class="btn23"><strong class="col">O</strong>추가</h1></a>
								<a onClick="field_remove();" class="btn"><h1 class="btn23"><strong>X</strong>제거</h1></a>
							</dd>
						</td>
					</tr>
					</table>

					<dl class="pbtn">  
						<input type="image" src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_poll','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

				</form>
				</div>

<?
			break;

			## POLL 결과보기
			case 'poll_view':
				$get_poll = $poll_control->get_poll($no);
				$poll_content = explode('|&|',$get_poll['poll_content']);
				$poll_content_cnt = count($poll_content);
				$poll_answer = explode('|&|',$get_poll['poll_answer']);
				$poll_answer_cnt = count($poll_answer);
				$answer_cnt = array_sum(array_slice($poll_answer, 0, count($poll_content)));

				$page = ($page) ? $page : 1;
				$page_rows = 12;
				$_add = " where `p_no` = '".$no."' ";
				$pollComment_list = $poll_control->__PollcommentList($page, $page_rows, $_add);
				$total_count = $pollComment_list['total_count'];
				$total_page = $pollComment_list['total_page'];
				
				// ajax paging
				$totalpages = ceil($total_count/$page_rows);

?>
				<div id="pop_poll" class="bocol lnb_col" style="top:5%;left:28%;display:none;width:600px;">
					<dl class="ntlt lnb_col m0 hand" id="pollFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">설문조사 결과보기
						<a onClick="MM_showHideLayers('pop_poll','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<dl class="blnb mt5">
						<dl class="pcont">
							<dl class="lnb_col col pd1 bdot"><h1 class="ln_col bg90 pd7 ds3 h17">Q.<?php echo stripslashes($get_poll['poll_subject']);?></h1></dl>
							<p class="tr" style="margin:10px 3px"><b class="col">ㆍ</b>총투표수 : <b class="col"><?php echo number_format($answer_cnt);?>표</b></p>
							<dl class="larea p0">
							<?php 
								for($i=0;$i<$poll_content_cnt;$i++){
									$pert = ($answer_cnt) ? sprintf("%.2f%%", ($poll_answer[$i]/$answer_cnt) * 100) : "0.0%";
							?>
							<ul class="lnb pb3" style="height:auto;min-height:21px">
								<li style="width:55.5%;margin-left:0.5%"><?php echo stripslashes($poll_content[$i]);?></li>
								<li style="width:25%;margin-left:1%"><img src="../images/comn/b.gif" width="<?php echo $pert;?>" height="13" class="ln_col grf25"></li>
								<li style="width:17.5%;margin-right:0.5%" class="f11 num3 ddgr b tr"><?php echo $pert;?> (<span class="col"><?php echo $poll_answer[$i];?></span>)</b></li>  
							</ul>
							<?php } ?>
							</dl>
							
							<?php if($total_count){ ?>
							<dl class="ntlt bno"><img src="../../images/comn/bul_10.png" class="ln_col t">나도 한마디…</dl>
							<table width="100%" class="mt10">
							<col width=20%><col><col width=5%>

							<tbody id='pollComment_list'>
							<?php foreach($pollComment_list['result'] as $val){?>
							<tr height="21" class="vt dot h16">
								<td class="f11"><?php echo stripslashes($val['mb_name']);?></td>
								<td class="f11 pb3"><?php echo stripslashes($val['content'])." ".$val['no'];;?>
									<a onClick="delete_pollComment('<?php echo $val['no'];?>','<?php echo $page;?>');"><img src="../../images/btn/del.gif" alt="삭제"></a>
								</td>
								<td class="num3 f11"><?=strtr(substr($val['wdate'],5,6),'-',',');?></td>
							</tr>
							<?php } ?>
							</tbody>

							</table>
							<!-- ajax paging -->
							<dt class="mt10">
								<dl class="paging">
									<?php for($j=1;$j<=$totalpages;$j++){?>
									<a class="<?php echo ($j==1)?'col':'';?>" page_no='<?php echo $j;?>' p_no='<?php echo $no;?>'><?php echo $j;?></a>&nbsp;
									<?php } ?>
								</dl> 
							</dt>
							<!-- //ajax paging -->
							<?php } ?>
						</dl>
					</dl>
				</div>

<?
			break;

		}
?>