<?php
		/*
		* /application/nad/board/views/_load/board.php
		* @author Harimao
		* @since 2013/05/29
		* @last update 2015/03/06
		* @Module v3.5 ( Alice )
		* @Brief :: Board list
		* @Comment :: 게시판 리스트
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$code = $_POST['code'];
		$no = $_POST['no'];

		$get_category = $category_control->get_categoryCode($code);

		$board = $board_config_control->get_board($no);	// 게시판 정보 (no 기준 추출)

		$alice['images_path'] = "../../images";

		switch($mode){

			## 상위 code 에 따른 게시판 리스트
			case 'board_list' :

				if($code){	// code 가 있는 경우 상위 메뉴가 있는 거다.

					$board_list = $board_config_control->boCode_list($code);

					if($board_list){

						foreach($board_list as $board){
							$_code = $category_control->get_categoryCode($board['code']);
							if($_code['p_code'])	// 2단 하위 메뉴가 있다면
								$board_code = $_code['p_code'];
							else
								$board_code = $_code['code'];
							$_category = $category_control->get_categoryPCode($board['bo_table']);
?>
						<tr class='board_list' no="<?php echo $board['no'];?>" code="<?php echo $board['code'];?>">
							<td><input type='checkbox' name="no[]" class='check_all' value="<?php echo $board['no'];?>"></td>
							<td class="none num3">
								<a class="none" onclick="change_board_rank('up',this);">▲</a>
								<a class="none" onclick="change_board_rank('down',this);">▼</a>
							</td>
							<td class="tl"><span id='board_name_<?php echo $board['no'];?>'><?php echo stripslashes($board['bo_subject']);?></span> (<span class="num3"><?php echo $board['bo_table'];?></span>)</td>
							<td class="num3"><?php echo number_format($board['bo_write_count']);?></td>
							<td>
								<?//php echo $board_config_control->board_skins[$board['bo_skin']];?>
								<select name="bo_skin" onchange="board_skins(this,'<?php echo $board['no'];?>');">
									<option value="default" <?php echo ($board['bo_skin']=='default')?'selected':'';?>>텍스트형</option>
									<option value="image" <?php echo ($board['bo_skin']=='image')?'selected':'';?>>이미지형</option>
									<option value="webzine" <?php echo ($board['bo_skin']=='webzine')?'selected':'';?>>웹진형</option>
									<!-- <option value="mix" <?php echo ($board['bo_skin']=='mix')?'selected':'';?>>혼합형</option> -->
									<option value="on2on" <?php echo ($board['bo_skin']=='on2on')?'selected':'';?>>1:1상담형</option>
								</select>
							</td>
							<!-- <td><input name="bo_board_view" type="checkbox" value="1" <?php echo ($board['bo_board_view'])?'checked':'';?> onclick="board_views(this,'<?php echo $board['no'];?>');"></td> -->
							<!-- <td><input name="bo_main_count[]" type="text" class="tnum tc" style="width:50%;" id="main_count_<?php echo $board['no'];?>" value="<?php echo $board['bo_main_count'];?>"/> 건</td> -->
							<!-- <td><input name="bo_main_view" type="checkbox" value="1" <?php echo ($board['bo_main_view'])?'checked':'';?> onclick="board_prints(this,'<?php echo $board['no'];?>');"></td> -->
							<td>
								<a onClick="board_levels('<?php echo $board['code'];?>','<?php echo $board['no']?>');" class="btn" id="level_<?php echo $board['no'];?>">
								<?php if(!$board['bo_list_level'] && !$board['bo_read_level'] && !$board['bo_write_level'] && !$board['bo_reply_level'] && !$board['bo_comment_level']){?>
									<h1 class="btn19"><strong>X</strong>권한</h1>
								<?php } else {?>
									<h1 class="btn19 col"><strong>O</strong>권한</h1>
								<?php } ?>
								</a>
							</td>
							<td>
								<a onClick="board_categories('<?php echo $board['no']?>');" class="btn" id="cate_<?php echo $board['no'];?>">
								<?php if($_category){ ?>
								<h1 class="btn19 col"><strong>O</strong>분류</h1>
								<?php } else {?>
								<h1 class="btn19"><strong>X</strong>분류</h1>
								<?php } ?>
								</a>
							</td>
							<td><a href="../../board/board.php?code=<?php echo $board['code'];?>&bo_table=<?php echo $board['bo_table'];?>" target="_blank"><img src="../../images/btn/19_12.gif"></a></td>
							<td><a onClick="board_form('board_update','<?php echo $board['no'];?>');"><img src="../../images/btn/19_05.gif"></a></td>
							<td class="e"><a onClick="board_delete('<?php echo $board['no'];?>');"><img src="../../images/btn/19_06.gif"></a></td>
						</tr>
<?php
						}	// foreach end.

					} else {	 // 게시판이 없다면
?>
						<tr>
							<td colspan='13' height='30' id="board_none" class="e">[<b><?php echo stripslashes($get_category['name']);?></b>] 메뉴에 생성된 게시판이 없습니다.</td>
						</tr>
<?php
					}

				} else {	 // 없다면 전체 게시판 리스팅
				
					$board_list = $board_control->__BoardList("","",""," `no` desc ");

					if($board_list['total_count']){

						foreach($board_list['result'] as $board){
							$_code = $category_control->get_categoryCode($board['code']);
							if($_code['p_code']){	// 2단 하위 메뉴가 있다면
								$board_code = $_code['p_code'];
							} else {
								$board_code = $_code['code'];
							}
							$_category = $category_control->get_categoryP_code($board['bo_table']);
?>
							<tr class='board_list' no="<?php echo $board['no'];?>" code="<?php echo $board['code'];?>">
								<td><input type='checkbox' name="no[]" class='check_all' value="<?php echo $board['no'];?>"></td>
								<td class="none num3">
									<a class="none" onclick="change_board_rank('up',this);">▲</a>
									<a class="none" onclick="change_board_rank('down',this);">▼</a>
								</td>
								<td class="tl"><span id='board_name_<?php echo $board['no'];?>'><?php echo stripslashes($board['bo_subject']);?></span> (<span class="num3"><?php echo $board['bo_table'];?></span>)</td>
								<td class="num3"><?php echo number_format($board['bo_write_count']);?></td>
								<td>
									<?//php echo $board_config_control->board_skins[$board['bo_skin']];?>
									<select name="bo_skin" onchange="board_skins(this,'<?php echo $board['no'];?>');">
										<option value="default" <?php echo ($board['bo_skin']=='default')?'selected':'';?>>텍스트형</option>
										<option value="image" <?php echo ($board['bo_skin']=='image')?'selected':'';?>>이미지형</option>
										<option value="webzine" <?php echo ($board['bo_skin']=='webzine')?'selected':'';?>>웹진형</option>
										<option value="mix" <?php echo ($board['bo_skin']=='mix')?'selected':'';?>>혼합형</option>
										<!-- <option value="on2on" <?php echo ($board['bo_skin']=='on2on')?'selected':'';?>>1:1상담형</option> -->
									</select>
								</td>
								<td><input name="bo_board_view" type="checkbox" value="1" <?php echo ($board['bo_board_view'])?'checked':'';?> onclick="board_views(this,'<?php echo $board['no'];?>');"></td>
								<td><input name="bo_main_count[]" type="text" class="tnum tc" style="width:50%;" id="main_count_<?php echo $board['no'];?>" value="<?php echo $board['bo_main_count'];?>"/> 건</td>
								<td><input name="bo_main_view" type="checkbox" value="1" <?php echo ($board['bo_main_view'])?'checked':'';?> onclick="board_prints(this,'<?php echo $board['no'];?>');"></td>
								<td>
									<a onClick="board_levels('<?php echo $board['code'];?>','<?php echo $board['no']?>');" class="btn" id="level_<?php echo $board['no'];?>">
									<?php if(!$board['bo_list_level'] && !$board['bo_read_level'] && !$board['bo_write_level'] && !$board['bo_reply_level'] && !$board['bo_comment_level']){?>
										<h1 class="btn19"><strong>X</strong>권한</h1>
									<?php } else {?>
										<h1 class="btn19 col"><strong>O</strong>권한</h1>
									<?php } ?>
									</a>
								</td>
								<td>
									<a onClick="board_categories('<?php echo $board['no']?>');" class="btn" id="cate_<?php echo $board['no'];?>">
									<?php if($_category){ ?>
									<h1 class="btn19 col"><strong>O</strong>분류</h1>
									<?php } else {?>
									<h1 class="btn19"><strong>X</strong>분류</h1>
									<?php } ?>
									</a>
								</td>
								<td><a onclick="alert('죄송합니다.\n\n준비중입니다.');return false;" target="_blank"><img src="../../images/btn/19_12.gif"></a></td>
								<td><a onClick="board_form('board_update','<?php echo $board['no'];?>');"><img src="../../images/btn/19_05.gif"></a></td>
								<td class="e"><a onClick="board_delete('<?php echo $board['no'];?>');"><img src="../../images/btn/19_06.gif"></a></td>
							</tr>
<?php
						}	// foreach end.

					} else {	 // 게시판이 없다면
?>
						<tr>
							<td colspan='13' height='30' class="e">생성된 게시판이 없습니다.</td>
						</tr>
<?php
					}
				}

			break;

			## 게시판 소속 카테고리(분류)
			case 'board_cate':
			
				$get_category = $category_control->pcode_List($code);
				foreach($get_category as $category){
				$name = $utility->remove_quoted($category['name']);	 // (쌍)따옴표 등록시 필터링
?>
				<tr class='category_lists' no='<?php echo $category['no'];?>'>
					<td><input name="view" type="checkbox" value="yes" <?php echo ($category['view']=='yes')?'checked':'';?> id="cateView_<?php echo $category['no'];?>" onclick="board_cate_view(this,'<?php echo $category['no']?>');"></td>
					<td class="none num3">
						<a onclick="change_cate_rank('up',this);">▲</a>
						<a onclick="change_cate_rank('down',this);">▼</a>
					</td>
					<td class="tl"><input name="name[]" type="text" class="txt w100" value="<?php echo $name;?>" id="cateName_<?php echo $category['no'];?>" no="<?php echo $category['no'];?>"></td>
					<td class="num3"><?php echo number_format($category['hit']);?></td>
					<td><a onClick="board_cate_update('<?php echo $category['no'];?>');"><img src="../../images/btn/19_05.gif"></a></td>
					<td class="e"><a onClick="board_cate_delete('<?php echo $category['no'];?>','<?php echo $category['p_code'];?>');"><img src="../../images/btn/19_06.gif"></a></td>
				</tr>
<?php
				}	// foreach end.

			break;
			
			## 게시판 추가/수정
			case 'board_insert':
			case 'board_update':

				if($mode=='board_insert'){
					$menu_0 = $_POST['menu_0'];
					$menu_1 = $_POST['menu_1'];
					$get_category = ($menu_1) ? $category_control->get_category($menu_1) : $category_control->get_category($menu_0);
					$code = $get_category['code'];
				} else {
					$code = $board['code'];
				}

				$level_category = $category_control->__CategoryList("mb_level"," `rank` asc ");

				$table_width = ($mode=='board_update') ? $board['bo_table_width'] : 800;		// 게시판 가로 사이즈
				$image_width = ($mode=='board_update') ? $board['bo_image_width'] : 600;	// 이미지 출력 폭
				$subject_len = ($mode=='board_update') ? $board['bo_subject_len'] : 60;			// 게시글 제목 길이
				$page_rows = ($mode=='board_update') ? $board['bo_page_rows'] : 15;			// 페이지당 게시글 수

				$board_view = ($mode=='board_update') ? $board['bo_board_view'] : 1;	// 게시판 사용 유무
				$adult_view = ($mode=='board_update') ? $board['bo_adult_view'] : 1;		// 성인 게시판 사용 유무

				$list_level = ($mode=='board_update') ? $board['bo_list_level'] : 1;						// 리스트 접근 레벨
				$read_level = ($mode=='board_update') ? $board['bo_read_level'] : 1;					// 게시글 읽기 레벨
				$write_level = ($mode=='board_update') ? $board['bo_write_level'] : 1;				// 게시글 쓰기 레벨
				$reply_level = ($mode=='board_update') ? $board['bo_reply_level'] : 1;				// 답변글쓰기 레벨
				$comment_level = ($mode=='board_update') ? $board['bo_comment_level'] : 1;	// 댓글쓰기 레벨
				$secret_level = ($mode=='board_update') ? $board['bo_secret_level'] : 2;				// 비밀글 기능 레벨

				$use_point = ($mode=='board_update') ? $board['bo_use_point'] : 1;				// 포인트 사용 유무
				$use_comment = ($mode=='board_update') ? $board['bo_use_comment'] : 1;	// 댓글기능 사용 유무
				$use_reply = ($mode=='board_update') ? $board['bo_use_reply'] : 1;				// 답변기능 사용 유무
				$use_good = ($mode=='board_update') ? $board['bo_use_good'] : 1;				// 추천기능 사용 유무
				$use_nogood = ($mode=='board_update') ? $board['bo_use_nogood'] : 1;			// 비추천기능 사용 유무
				$use_report = ($mode=='board_update') ? $board['bo_use_report'] : 1;			// 신고기능 사용 유무
				$use_sns = ($mode=='board_update') ? $board['bo_use_sns'] : 1;					// SNS기능 사용 유무
				$use_list_view = ($mode=='board_update') ? $board['bo_use_list_view'] : 1;		// 상세목록 사용 유무
				$reply_order = ($mode=='board_update') ? $board['bo_reply_order'] : 1;			// 답변정렬
				$use_sideview = ($mode=='board_update') ? $board['bo_use_sideview'] : 1;		// 사이드 사용 유무
				$bo_cut_name = ($mode=='board_update') ? $board['bo_cut_name'] : 6;			// 작성자 출력글자
				$use_best_cnt = ($mode=='board_update') ? $board['bo_best_count'] : 10;		// 베스트 출력 제한 카운트
				$bo_new = ($mode=='board_update') ? $board['bo_new'] : 24;							// NEW 아이콘 출력

				$read_point = ($mode=='board_update') ? $board['bo_read_point'] : 0;					// 게시물 읽기 포인트
				$write_point = ($mode=='board_update') ? $board['bo_write_point'] : 5;				// 게시물 쓰기 포인트
				$comment_point = ($mode=='board_update') ? $board['bo_comment_point'] : 1;			// 댓글 쓰기 포인트
				$download_point = ($mode=='board_update') ? $board['bo_download_point'] : '-10';		// 다운로드 포인트
				$recommand_point = ($mode=='board_update') ? $board['bo_recommand_point'] : 5;	// 추천시 지급 포인트

				$bo_sns = $board['bo_sns'];
				if($mode=='board_update')	 { // SNS 글보내기 사용
					$use_sns = ($board['bo_use_sns']) ? 'checked' : '';
					$sns_feed = explode(",",$bo_sns);
				} else {
					$use_sns = 'checked';
					$sns_feed = array('twitter','facebook','me2day','yozm','google','clog');
				}
				$sns_count = count($sns_feed);

				$use_upload = ($mode=='board_update') ? $board['bo_use_upload'] : 1;				// 업로드    사용 유무
				$upload_count = ($mode=='board_update') ? $board['bo_upload_count'] : 4;			// 첨부파일 갯수
				$upload_size = ($mode=='board_update') ? $board['bo_upload_size'] : 2097152;	// 첨부파일 최대크기

				$bo_use_search = ($mode=='board_update') ? $board['bo_use_search'] : 1;		// 전체 검색 사용 유무
				$bo_order_search = ($mode=='board_update') ? $board['bo_order_search'] : 0;		// 전체 검색 순서

?>
				<style>
				.board_attaches { display:<?php echo ($use_upload)?'':'none';?>; }
				/* 선택 스킨별 자동으로 value 값이 지정되는 스크립트 에서 자동되는 CSS 입니다.
				 * 필요한 경우 사용하세요.
				.secret_check { display:<?php echo ($board[bo_skin]=='on2on')?'none':'';?>}
				*/
				</style>
				<div id="add_form" class="bocol lnb_col" style="top:0%;left:28%;display:none;">

					<form name="boardFrm" method="post" id="boardFrm" action="./process/board.php" enctype="multipart/form-data" onSubmit="return validate(this)">
					<input type="hidden" name="mode" value="<?php echo $mode;?>"/>
					<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
					<?php if($mode=='board_update'){ // 수정일때만 사용?> 
						<input type="hidden" name="no" value="<?php echo $no;?>"/><!-- 게시판 고유 no -->
					<?php } ?>
					<input type="hidden" name="code" value="<?php echo $code;?>"/><!-- 상위 메뉴 code -->

					<dl class="ntlt lnb_col m0 hand" id="boardFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">게시판환경설정
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<table width="850" class="bg_col">
					<col width=120><col>
					<tr>
						<td class="ctlt">게시판 이름</td>
						<td class="pdlnb2">
							<input type="text" class="txt w50" name="bo_subject" value="<?php echo stripslashes($board['bo_subject']);?>" hname="게시판명" required>
							<span class="subtlt">게시판 상단에 출력</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">게시판 형태</td>
						<td class="pdlnb2">
							<label><input type="radio" name="bo_skin" value="default" class="radio" checked>텍스트형</label> &nbsp;
							<label><input type="radio" name="bo_skin" value="image" class="radio" <?php echo ($board['bo_skin']=='image')?'checked':'';?>>이미지형</label> &nbsp;
							<label><input type="radio" name="bo_skin" value="webzine" class="radio" <?php echo ($board['bo_skin']=='webzine')?'checked':'';?>>웹진형</label> &nbsp;
							<!-- <label><input type="radio" name="bo_skin" value="on2on" class="radio" <?php echo ($board['bo_skin']=='on2on')?'checked':'';?>>1:1상담형</label> -->
							<span class="subtlt">이미지형, 웹진형 선택시 첨부파일은 필수항목</span>
						</td>
					</tr> 
<!-- 
					<tr>
						<td class="ctlt">게시판 가로크기</td>
						<td class="pdlnb2">
							<input type="text" name="bo_table_width" class="tnum" size="3" value="<?php echo $table_width;?>">
							<span class="subtlt">100 이하는 %</span>
						</td>
					</tr>
-->
					<tr id="image_widths">
						<td class="ctlt">이미지 가로크기</td>
						<td class="pdlnb2">
							<input type="text" name="bo_image_width" class="tnum" size="3" value="<?php echo $image_width;?>"> 픽셀 
							<!-- <span class="subtlt">이미지형, 웹진형 선택시 출력되는 이미지의 폭 크기</span> -->
							<span class="subtlt">게시글 상세내용 출력 이미지 가로 사이즈 (높이는 비율대로 줄어듭니다)</span>
						</td>
					</tr>
<!-- 
					<tr>
						<td class="ctlt">게시글 제목길이</td>
						<td class="pdlnb2">
							<input type="text" name="bo_subject_len" class="tnum" size="3" value="<?php echo $subject_len;?>">
							<span class="subtlt">목록에서의 제목 글자수. 잘리는 글은 ...로 표시</span>
						</td>
					</tr>
-->
					<tr>
						<td class="ctlt">페이지당 게시글수</td>
						<td class="pdlnb2">
							<input type="text" name="bo_page_rows" class="tnum" size="3" value="<?php echo $page_rows;?>"> 개/페이지당
							<span class="subtlt">1 페이지당 출력될 게시글 수</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">게시판 출력</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_board_view" class="check" value="1" <?php echo ($board_view)?'checked':'';?>>사용함</label>
							<span class="subtlt dho">※ 체크해제시 사이트에 해당 게시판/게시글들이 더이상 출력되지 않음</span>
						</td>
					</tr>  
					<!-- <tr>
						<td class="ctlt">성인게시판으로 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_adult_view" class="check" value="1" <?php echo ($adult_view)?'checked':'';?>>사용함</label>
							<span class="subtlt dho">※ 성인게시판으로 사용시 자동으로 성인인증 페이지가 출력됩니다.</span>
						</td>
					</tr>   -->
					<tr><td colspan="2" height="5" class="wbg lnb"></td></tr>

					<tr>
						<td class="ctlt">권한설정</td>
						<td class="lnb2 pl4">
							<dl class="fl w50 dlst">
								<b>ㆍ리스트접근</b>
									<select name="bo_list_level" id="bo_list_level">
									<?php 
										foreach($level_category as $level){ 
										$selected = ($level['rank']==$list_level) ? 'selected' : '';
									?>
									<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
									<?php } ?>
									</select>
									<!-- <label><input type="radio" name="bo_list_level" value="0" checked/> 비회원</label>
									<label><input type="radio" name="bo_list_level" value="1" <?php echo ($board['bo_list_level'])?'checked':'';?>/> 회원</label> -->
								<dt>
									<b>ㆍ게시물읽기</b>
									<select name="bo_read_level" id="bo_read_level">
									<?php 
										foreach($level_category as $level){ 
										$selected = ($level['rank']==$read_level) ? 'selected' : '';
									?>
									<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
									<?php } ?>
									</select>
									<!-- <label><input type="radio" name="bo_read_level" value="0" checked/> 비회원</label>
									<label><input type="radio" name="bo_read_level" value="1" <?php echo ($board['bo_read_level'])?'checked':'';?>/> 회원</label> -->
								</dt>
								<dt>
									<b>ㆍ게시물쓰기</b>
									<select name="bo_write_level" id="bo_write_level">
									<?php 
										foreach($level_category as $level){ 
										$selected = ($level['rank']==$write_level) ? 'selected' : '';
									?>
									<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
									<?php } ?>
									</select>
									<!-- <label><input type="radio" name="bo_write_level" value="0" checked/> 비회원</label>
									<label><input type="radio" name="bo_write_level" value="1" <?php echo ($board['bo_write_level'])?'checked':'';?>/> 회원</label> -->
								</dt>
							</dl>
							<dl class="fr w50 dlst">
								<b>ㆍ답변글쓰기</b>
									<select name="bo_reply_level" id="bo_reply_level">
									<?php 
										foreach($level_category as $level){ 
										$selected = ($level['rank']==$reply_level) ? 'selected' : '';
									?>
									<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
									<?php } ?>
									</select>
									<!-- <label><input type="radio" name="bo_reply_level" value="0" checked/> 비회원</label>
									<label><input type="radio" name="bo_reply_level" value="1" <?php echo ($board['bo_reply_level'])?'checked':'';?>/> 회원</label> -->
								</dt>
								<dt>
									<b class="ds" style="width:72px">ㆍ댓글쓰기</b>
									<select name="bo_comment_level" id="bo_comment_level">
									<?php 
										foreach($level_category as $level){ 
										//if($level['rank']==1) continue;
										$selected = ($level['rank']==$comment_level) ? 'selected' : '';
									?>
									<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
									<?php } ?>
									</select>
									<!-- <label><input type="radio" name="bo_comment_level" value="0" checked/> 비회원</label>
									<label><input type="radio" name="bo_comment_level" value="1" <?php echo ($board['bo_comment_level'])?'checked':'';?>/> 회원</label> -->
								</dt>
								<dt>
									<b class="ds" style="width:72px">ㆍ비밀글쓰기</b>
									<select name="bo_secret_level" id="secret_level">
									<?php 
										foreach($level_category as $level){ 
										$selected = ($level['rank']==$secret_level) ? 'selected' : '';
									?>
									<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
									<?php } ?>
									</select>
								</dt>
							</dl>
						</td>
					</tr>
					<!-- <tr>
						<td class="ctlt">포인트 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_point" class="check" <?php echo ($use_point)?'checked':'';?> id="use_point">사용함</label>
							<span class="subtlt dho">※ 게시물 등록시 포인트 지급유무 선택 </span>
						</td>
					</tr> -->
					<input type="hidden" name="bo_use_point" value="1"/><!-- 포인트 사용 변수 자동 설정 -->
					<!-- <tr id="use_points" style="display:<?php echo ($use_point)?'':'none';?>;"> -->
					<tr>
						<td class="ctlt">포인트 설정</td>
						<td class="lnb2 pl4">
							<dl class="fl w50 dlst">
								<b>ㆍ게시물읽기</b>
									<input type="text" name="bo_read_point" class="tnum" size="10" value="<?php echo $read_point;?>"/> 포인트
								<dt>
									<b>ㆍ게시물쓰기</b>
									<input type="text" name="bo_write_point" class="tnum" size="10" value="<?php echo $write_point;?>"/> 포인트
								</dt>
							</dl>
							<dl class="fr w50 dlst">
								<b>ㆍ댓글쓰기</b>
									<input type="text" name="bo_comment_point" class="tnum" size="10" value="<?php echo $comment_point;?>"/> 포인트
								</dt>
								<dt>
									<b class="ds">ㆍ다운로드</b>
									<input type="text" name="bo_download_point" class="tnum" size="10" value="<?php echo $download_point;?>"/> 포인트
								</dt>
							</dl>
						</td>
					</tr>
					<!-- <tr>
						<td class="ctlt">중복조회 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_overlap" class="check" value="1" <?php echo ($board['bo_use_overlap'])?'checked':'';?> id="use_overlap">사용함</label>
							<span class="subtlt">게시물을 읽을때 마다 조회수가 증가</span>
						</td>
					</tr> -->
					<tr>
						<td class="ctlt">댓글기능 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_comment" class="check" value="1" <?php echo ($use_comment)?'checked':'';?>>사용함</label>
							<span class="subtlt">게시판에 댓글 입력을 할수 있도록 설정</span>
						</td>
					</tr>
					<!-- <tr>
						<td class="ctlt">BEST 댓글표시</td>
						<td class="pdlnb2">
							<input type="checkbox" name="bo_use_comment_best" class="check" value="1" <?php echo ($board['bo_use_comment_best'])?'checked':'';?>>사용함
							<span class="subtlt">추천수 많은 댓글을 댓글 목록 최상단에 출력합니다 (일명 '베플') 단, 추천 기능을 사용하셔야 합니다.</span>
						</td>
					</tr> -->
					<!-- <tr>
						<td class="ctlt">답변기능 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_reply" class="check" value="1" <?php echo ($use_reply)?'checked':'';?>>사용함</label>
							<span class="subtlt">게시판에 답변글 입력을 할수 있도록 설정</span>
						</td>
					</tr> -->
					<!-- 
					<input type="hidden" name="bo_use_reply" value="1"/>
					<tr class="secret_check">
						<td class="ctlt">추천 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_good" class="check use_good" value="1" <?php echo ($use_good)?'checked':'';?>>사용함</label><!-- &nbsp;&nbsp;/&nbsp;&nbsp;
							비추천 <label><input type="checkbox" name="bo_use_nogood" class="check use_good" value="1" <?php echo ($use_nogood)?'checked':'';?>>사용함</label> -->
							<!-- 
						</td>
					</tr>
					<!-- <tr class="secret_check" style="display:none;">
						<td class="ctlt">추천 포인트</td>
						<td class="pdlnb2">
							<input type="text" name="bo_recommand_point" class="tnum" size="10" value="<?php echo $recommand_point;?>"/> 포인트
							&nbsp;<span class="subtlt">추천시 추천 받은사람에게 포인트 지급, 반대로 비추천시 포인트 차감</span>
						</td>
					</tr> -->
					<!-- <tr>
						<td class="ctlt">트랙백기능 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_trackback" class="check" value="1" <?php echo ($board['bo_use_trackback'])?'checked':'';?>>사용함</label>
							<span class="subtlt">내가 작성하는 글을 다른사람에게 알리는 기능</span>
						</td>
					</tr> -->
					<!-- <tr class="secret_check">
						<td class="ctlt">신고기능 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_report" class="check" value="1" <?php echo ($use_report)?'checked':'';?> id="use_report">사용함</label>
							<span class="subtlt">회원이 불건전한 게시물을 신고할 수 있는 기능 (신고항목은 <a href="./category.php?type=board_reason" target="_blank">[게시글 신고사유]</a> 에서 설정)</span>
						</td>
					</tr> -->
					<tr>
						<td class="ctlt">비밀글 기능 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_secret" class="check" value="1" <?php echo ($board['bo_use_secret'])?'checked':'';?> id="use_secret">사용함</label>
						</td>
					</tr>
					<!-- 
					<tr>
						<td class="ctlt">게시글 삭제</td>
						<td class="pdlnb2">
							<label><input type="radio" class="radio" name="bo_use_delete" value="0" checked>바로삭제</label> &nbsp;
							<label><input type="radio" class="radio" name="bo_use_delete" value="1" <?php echo ($board['bo_use_delete'])?'checked':'';?>>삭제된 게시물로 표시</label>
							<span class="subtlt">삭제 표시된 게시물을 삭제하면 완전히 데이터 삭제</span>
						</td>
					</tr>
					-->
					<tr>
						<td class="ctlt">작성자이름 출력</td>
						<td class="pdlnb2">
							<label><input type="radio" name="bo_use_name" class="radio" value="0" checked>닉네임</label> &nbsp;
							<label><input type="radio" name="bo_use_name" class="radio" value="1" <?php echo ($board['bo_use_name']=='1')?'checked':'';?>>아이디</label> &nbsp;
							<label><input type="radio" name="bo_use_name" class="radio" value="2" <?php echo ($board['bo_use_name']=='2')?'checked':'';?>>이름</label> &nbsp;
							<label><input type="radio" name="bo_use_name" class="radio" value="3" <?php echo ($board['bo_use_name']=='3')?'checked':'';?>>익명</label>
							<span class="subtlt">게시물 작성자에 선택된 명칭으로 출력 (익명의 경우 '익명' 으로 출력됨)</span>
						</td>
					</tr>
					<tr id="cut_names">
						<td class="ctlt">작성자 출력글자</td>
						<td class="pdlnb2">
							<input type="text" name="bo_cut_name" class="tnum" size="3" value="<?php echo $bo_cut_name;?>" id="cut_name"> 글자 
							<span class="subtlt">한글의 경우 영문 2자와 동일합니다.</span>
						</td>
					</tr>
					<!-- <tr>
						<td class="ctlt">SNS 글보내기 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_sns" class="check" value="1" <?php echo $use_sns;?> id="use_sns">사용함</label>
							<span class="subtlt">게시물 상세페이지에 SNS 글보내기 버튼 출력</span>
						</td>
					</tr>
					<tr id="sns_set" style="display:<?php echo ($use_sns)?'':'none';?>;">
						<td class="ctlt">SNS 설정</td>
						<td class="pdlnb2">
							<input name="sns_all" type="checkbox" class="check" value="all" id='sns_all' <?php echo ($sns_count==6)?'checked':'';?>><label class="fon11 b mr5" for="sns_all">ALL</label>
							<input name="bo_sns[]" type="checkbox" class="check" value="twitter" id="sns_twitter" <?php echo (@in_array('twitter',$sns_feed))?'checked':'';?>> <img src="<?php echo $alice['images_path'];?>/ic/sns/twitter.gif" class="vm"><label class="fon11 mr5" for="sns_twitter">트위터</label>
							<input name="bo_sns[]" type="checkbox" class="check" value="facebook" id="sns_facebook" <?php echo (@in_array('facebook',$sns_feed))?'checked':'';?>> <img src="<?php echo $alice['images_path'];?>/ic/sns/facebook.gif" class="vm"><label class="fon11 mr5" for="sns_facebook">페이스북</label>
							<input name="bo_sns[]" type="checkbox" class="check" value="me2day" id="sns_me2day" <?php echo (@in_array('me2day',$sns_feed))?'checked':'';?>> <img src="<?php echo $alice['images_path'];?>/ic/sns/me2day.gif" class="vm"><label class="fon11 mr5" for="sns_me2day">미투데이</label>
							<input name="bo_sns[]" type="checkbox" class="check" value="yozm" id="sns_yozm" <?php echo (@in_array('yozm',$sns_feed))?'checked':'';?>> <img src="<?php echo $alice['images_path'];?>/ic/sns/yozm.gif" class="vm"><label class="fon11 mr5" for="sns_yozm">요즘</label>
							<input name="bo_sns[]" type="checkbox" class="check" value="google" id="sns_google" <?php echo (@in_array('google',$sns_feed))?'checked':'';?>> <img src="<?php echo $alice['images_path'];?>/ic/sns/google.gif" class="vm"><label class="fon11 mr5" for="sns_google">구글플러스</label>
							<input name="bo_sns[]" type="checkbox" class="check" value="clog" id="sns_clog" <?php echo (@in_array('clog',$sns_feed))?'checked':'';?>> <img src="<?php echo $alice['images_path'];?>/ic/sns/clog.gif" class="vm"><label class="fon11 mr5" for="sns_clog">C로그</label>
						</td>
					</tr> -->
					<!-- <tr class="secret_check">
						<td class="ctlt">BEST 출력</td>
						<td class="pdlnb2">
							<input type="checkbox" name="bo_use_best" class="check" value="1" <?php echo ($board['bo_use_best'])?'checked':'';?>>사용함
							( 조회수 <input type="text" name="bo_best_count" class="tnum" size="3" value="<?php echo $use_best_cnt;?>"> 회 이상 )
							<span class="subtlt">게시물 목록/상세페이지에 조회수 BEST 출력 </span>
						</td>
					</tr> -->
					<tr>
						<td class="ctlt">NEW 아이콘 출력</td>
						<td class="pdlnb2">
							<input type="text" name="bo_new" class="tnum" size="3" value="<?php echo $bo_new;?>"> 시간
							<span class="subtlt">글 입력후 new 이미지를 출력하는 시간</span>
						</td>
					</tr>
					<!-- <tr>
						<td class="ctlt">댓글 이모티콘 입력</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_imoticon" class="check" value="1" <?php echo ($bo_imoticon)?'checked':'';?>>사용함</label>
							<span class="subtlt">댓글 입력시 이모티콘(스티커) 사용 유무</span>
						</td>
					</tr>
					<tr>
						<td class="ctlt">댓글 에디터사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_comment_editor" class="check" value="1" <?php echo ($comment_editor)?'checked':'';?>>사용함</label>
							<span class="subtlt">댓글 입력시 일반 textarea 가 아닌 글작성과 동일한 editor 사용 </span>
						</td>
					</tr> -->
					<tr>
						<td class="ctlt">상세페이지 목록 출력</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_list_view" class="check" value="1" <?php echo ($use_list_view)?'checked':'';?>>사용함</label>
							<span class="subtlt">게시물 상세페이지 하단에 목록 출력</span>
						</td>
					</tr>
					<!-- <tr>
						<td class="ctlt">답변 정렬</td>
						<td class="pdlnb2">
							<select name="bo_reply_order">
							<option value='1'>나중에 쓴 답변 아래로 달기 (기본)
							<option value='0' <?php echo (!$reply_order)?'selected':'';?>>나중에 쓴 답변 위로 달기
							</select>
						</td>
					</tr> 
					<tr>
						<td class="ctlt">리스트 정렬 필드</td>
						<td class="pdlnb2">
							<select name="bo_sort_field" style="margin-bottom:5px;">
							<option value=''>wr_num, wr_reply : 기본
							<option value='wr_datetime asc' <?php echo ($board['bo_sort_field']=='wr_datetime asc')?'selected':'';?>>wr_datetime asc : 날짜 이전것 부터
							<option value='wr_datetime desc' <?php echo ($board['bo_sort_field']=='wr_datetime desc')?'selected':'';?>>wr_datetime desc : 날짜 최근것 부터
							<option value='wr_hit asc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_hit asc, wr_num, wr_reply')?'selected':'';?>>wr_hit asc : 조회수 낮은것 부터
							<option value='wr_hit desc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_hit desc, wr_num, wr_reply')?'selected':'';?>>wr_hit desc : 조회수 높은것 부터
							<option value='wr_last asc' <?php echo ($board['bo_sort_field']=='wr_last asc')?'selected':'';?>>wr_last asc : 최근글 이전것 부터
							<option value='wr_last desc' <?php echo ($board['bo_sort_field']=='wr_last desc')?'selected':'';?>>wr_last desc : 최근글 최근것 부터
							<option value='wr_comment asc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_comment asc, wr_num, wr_reply')?'selected':'';?>>wr_comment asc : 코멘트수 낮은것 부터
							<option value='wr_comment desc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_comment desc, wr_num, wr_reply')?'selected':'';?>>wr_comment desc : 코멘트수 높은것 부터
							<option value='wr_good asc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_good asc, wr_num, wr_reply')?'selected':'';?>>wr_good asc : 추천수 낮은것 부터
							<option value='wr_good desc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_good desc, wr_num, wr_reply')?'selected':'';?>>wr_good desc : 추천수 높은것 부터
							<option value='wr_nogood asc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_nogood asc, wr_num, wr_reply')?'selected':'';?>>wr_nogood asc : 비추천수 낮은것 부터
							<option value='wr_nogood desc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_nogood desc, wr_num, wr_reply')?'selected':'';?>>wr_nogood desc : 비추천수 높은것 부터
							<option value='wr_subject asc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_subject asc, wr_num, wr_reply')?'selected':'';?>>wr_subject asc : 제목 내림차순
							<option value='wr_subject desc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_subject desc, wr_num, wr_reply')?'selected':'';?>>wr_subject desc : 제목 오름차순
							<option value='wr_name asc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_name asc, wr_num, wr_reply')?'selected':'';?>>wr_name asc : 글쓴이 내림차순
							<option value='wr_name desc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='wr_name desc, wr_num, wr_reply')?'selected':'';?>>wr_name desc : 글쓴이 오름차순
							<option value='ca_name asc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='ca_name asc, wr_num, wr_reply')?'selected':'';?>>wr_category asc : 분류명 내림차순
							<option value='ca_name desc, wr_num, wr_reply' <?php echo ($board['bo_sort_field']=='ca_name desc, wr_num, wr_reply')?'selected':'';?>>wr_category desc : 분류명 오름차순
							</select>
							<span class="subtlt">리스트에서 기본으로 정렬에 사용할 필드를 선택합니다.</span><br/>
							<span class="subtlt" style="margin-left:-5px;">'기본'으로 사용하지 않으시는 경우 속도가 느려질 수 있습니다.</span>
						</td>
					</tr>-->
					<tr>
						<td class="ctlt">분류 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_category" class="check" value="1" <?php echo ($board['bo_use_category'])?'checked':'';?>>사용함</label>
							<span class="subtlt">게시판 내 분류 사용유무 (분류 사용시 게시판 생성후 목록 에서 설정하시기 바랍니다)</span>
						</td>
					</tr>
					<!-- <tr id="use_categories" style="display:none;">
						<td class="ctlt">분류 설정</td>
						<td class="pdlnb2">
							<input type="text" name="bo_category_list" class="tnum" style="width:100%;" value="<?php echo $category_list;?>" id="category_list"><br/>
							<span class="subtlt" style="margin-left:-5px;">분류와 분류 사이는 | 로 구분하세요. (예: 질문|답변) 첫자로 #은 입력하지 마세요. (예: #질문|#답변 [X])</span>
						</td>
					</tr> -->
					<!-- <tr>
						<td class="ctlt">사이드뷰 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_sideview" class="check" value="1" <?//php echo ($use_sideview)?'checked':'';?>>사용함</label>
							<span class="subtlt">작성자 클릭시 나오는 레이어 메뉴</span>
						</td>
					</tr> -->
					<tr><td colspan="2" height="5" class="wbg lnb"></td></tr>

					<tr>
						<td class="ctlt">첨부파일 사용</td>
						<td class="pdlnb2">
							<label><input type="checkbox" name="bo_use_upload" class="check" value="1" <?php echo ($use_upload)?'checked':'';?> id="use_upload">사용함</label>
							<span class="subtlt">이미지/웹진형 사용시 반드시 선택</span>
						</td>
					</tr>
					<!-- <tr class='board_attaches'>
						<td class="ctlt">첨부파일 출력</td>
						<td class="pdlnb2">
							<input type="checkbox" name="" class="check">사용함
							<span class="subtlt">게시물 상세페이지에 첨부파일 목록 / 다운로드 현황 출력</span>
						</td>
					</tr> -->
					<tr class='board_attaches'>
						<td class="ctlt">첨부파일 갯수</td>
						<td class="pdlnb2">
							<input type="text" name="bo_upload_count" class="tnum" size="10" value="<?php echo $upload_count;?>"> 개
							<span class="subtlt"><b class="dho">최대 10</b>개까지 설정가능</span>
						</td>
					</tr>
					<tr class='board_attaches'>
						<td class="ctlt">첨부파일 최대크기</td>
						<td class="pdlnb2">
							<input type="text" name="bo_upload_size" class="tnum" size="10" value="<?php echo $upload_size;?>"> Bytes/1파일
							<span class="subtlt"><b class="dho">1파일당 최대 <?php echo number_format(intval(substr(ini_get('post_max_size'),0,-1)) * 1024);?>KB</b>까지 설정가능합니다.</span>
						</td>
					</tr>
					<tr class='board_attaches'>
						<td class="ctlt">첨부이미지 확장자</td>
						<td class="pdlnb2">
							<input type="text" name="bo_upload_ext_img" class="tnum" style="width:80%;" value="<?php echo ($board['bo_upload_ext_img'])?$board['bo_upload_ext_img']:'gif|png|jpg|bmp';?>">
							<span class="subtlt">입력시 ( '|' )로 구분</span>
						</td>
					</tr>
					<tr class='board_attaches'>
						<td class="ctlt">첨부플래시 확장자</td>
						<td class="pdlnb2">
							<input type="text" name="bo_upload_ext_fla" class="tnum" style="width:80%;" value="<?php echo ($board['bo_upload_ext_fla'])?$board['bo_upload_ext_fla']:'swf|fla';?>">
							<span class="subtlt">입력시 ( '|' )로 구분</span>
						</td>
					</tr>
					<tr class='board_attaches'>
						<td class="ctlt">첨부동영상 확장자</td>
						<td class="pdlnb2">
							<input type="text" name="bo_upload_ext_mov" class="tnum" style="width:80%;" value="<?php echo ($board['bo_upload_ext_mov'])?$board['bo_upload_ext_mov']:'asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3|mp4';?>">
							<span class="subtlt">입력시 ( '|' )로 구분</span>
						</td>
					</tr>
					<tr class='board_attaches'>
						<td class="ctlt">첨부파일 확장자</td>
						<td class="pdlnb2">
							<input type="text" name="bo_upload_ext" class="tnum" style="width:80%;" value="<?php echo ($board['bo_upload_ext'])?$board['bo_upload_ext']:'hwp|doc|pdf|ppt|pptx|xls|xlsx|gul|zip|alz|rar|torrent';?>">
							<span class="subtlt">입력시 ( '|' )로 구분</span>
						</td>
					</tr>
					<tr><td colspan="2" height="5" class="wbg lnb"></td></tr>

					<!-- <tr>
					<td class="ctlt">게시판 상단파일설정</td>
					<td class="pdlnb2">
						<input type="text" name="bo_include_head" class="tnum w50">
						<dl class="mt3 subt">게시판 상단에 출력할 파일경로의 파일명, <span class="red">파일 업로드 위치 : ../comu/include/</span></dl>
					</td>
					</tr> 
					<tr>
						<td class="ctlt">게시판 하단파일설정</td>
						<td class="pdlnb2">
							<input type="text" name="bo_include_tail" class="tnum w50">
							<dl class="mt3 subt">게시판 하단에 출력할 파일경로의 파일명, <span class="red">파일 업로드 위치 : ../comu/include/</span></dl>
						</td>
					</tr>
					<tr><td colspan="2" height="5" class="wbg lnb"></td></tr>
					
					<tr>
						<td class="ctlt">게시판 상단내용</td>
						<td class="pdlnb2">
							<textarea type="editor" name="bo_content_head" style="width:100%;height:100px;"><?=stripslashes($board['bo_content_head']);?></textarea>
						</td>
					</tr> 
					<tr>
						<td class="ctlt">게시판 하단내용</td>
						<td class="pdlnb2">
							<textarea type="editor" name="bo_content_tail" style="width:100%;height:100px;"><?=stripslashes($board['bo_content_tail']);?></textarea>
						</td>
					</tr>
					<tr><td colspan="2" height="5" class="wbg lnb"></td></tr>
					<tr>
						<td class="ctlt">글작성 기본 내용</td>
						<td class="pdlnb2">
							<textarea type="editor" name="bo_insert_content" style="width:100%;height:100px;"><?=stripslashes($board['bo_insert_content']);?></textarea>
						</td>
					</tr>
					
					<tr><td colspan="2" height="5" class="wbg lnb"></td></tr>
-->
					<tr>
						<td class="ctlt">금지 단어 설정<dl class="mt7 subt">입력시 쉼표(,)로 구분</dl></td>
						<td class="pdlnb2">
							<dl class="twrap">
								<textarea name="bo_filter" style="height:100px;" class="fon11"><?php echo ($board['bo_filter'])?stripslashes($board['bo_filter']):"18아,18놈,18새끼,18년,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ";?></textarea>
							</dl>
						</td>
					</tr>
					<!-- <tr>
						<td class="ctlt">아이피 차단 설정<dl class="mt7 subt">입력시 쉼표(,)로 구분</dl></td>
						<td class="pdlnb2">
							<dl class="twrap">
								<textarea name="bo_intercept_ip" style="height:60px;" class="fon11"><?php echo stripslashes($board['bo_intercept_ip']);?></textarea>
							</dl>
						</td>
					</tr> -->
					<!-- <tr>
						<td class="ctlt">전체 검색 사용</td>
						<td class="pdlnb2">
							<dl class="twrap">
								<label><input type="checkbox" name="bo_use_search" class="check" value="1" <?php echo ($bo_use_search)?'checked':'';?>>사용함</label>
							</dl>
						</td>
					</tr> -->
					<!-- <tr>
						<td class="ctlt">전체 검색 순서</td>
						<td class="pdlnb2">
							<dl class="twrap">
								<input type="text" name="bo_order_search" class="tnum" size="3" value="<?php echo $bo_order_search;?>" id="cut_name"> 글자 
								<span class="subtlt">숫자가 낮은 게시판 부터 검색</span>
							</dl>
						</td>
					</tr> -->
					</table>

					<dl class="pbtn">  
						<input type="image" src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

					</form>

				</div>
<?
			break;

			## 리스트상 게시판 권한설정
			case 'board_level':

				$level_category = $category_control->__CategoryList("mb_level"," `rank` asc ");

?>
				<div id="board_level" class="bocol lnb_col" style="top:35%;left:45%;width:200px;display:none;">

					<form name="levelFrm" method="post" id="levelFrm" action="./process/board.php">
					<input type="hidden" name="mode" value="level_update"/>
					<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
					<input type="hidden" name="no" value="<?php echo $no;?>"/><!-- 게시판 고유 no -->
					<input type="hidden" name="code" value="<?php echo $code;?>"/><!-- 상위 메뉴 code -->

					<dl class="ntlt lnb_col m0 hand" id="levelFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">게시판 권한설정
						<a onClick="MM_showHideLayers('board_level','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<dl class="fon11 lnb dlst" style="padding:7px 7px 7px 0;">
						<b>ㆍ리스트접근</b>
							<select name="bo_list_level" id="bo_list_level">
							<?php 
								foreach($level_category as $level){ 
								$selected = ($level['rank']==$board['bo_list_level']) ? 'selected' : '';
							?>
							<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
							<?php } ?>
							</select>
						<dt>
							<b>ㆍ게시물읽기</b>
							<select name="bo_read_level" id="bo_read_level">
							<?php 
								foreach($level_category as $level){ 
								$selected = ($level['rank']==$board['bo_read_level']) ? 'selected' : '';
							?>
							<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
							<?php } ?>
							</select>
						</dt>
						<dt>
							<b>ㆍ게시물쓰기</b>
							<select name="bo_write_level" id="bo_write_level">
							<?php 
								foreach($level_category as $level){ 
								$selected = ($level['rank']==$board['bo_write_level']) ? 'selected' : '';
							?>
							<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
							<?php } ?>
							</select>
						</dt>
						<dt>
							<b class="ds" style="width:72px">ㆍ답변글쓰기</b>
							<select name="bo_reply_level" id="bo_reply_level">
							<?php 
								foreach($level_category as $level){ 
								$selected = ($level['rank']==$board['bo_reply_level']) ? 'selected' : '';
							?>
							<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
							<?php } ?>
							</select>
						</dt>
						<dt>    
							<b>ㆍ댓글쓰기</b>&nbsp;&nbsp;&nbsp;
							<select name="bo_comment_level" id="bo_comment_level">
							<?php 
								foreach($level_category as $level){ 
								if($level['rank']==1) continue;
								$selected = ($level['rank']==$board['bo_comment_level']) ? 'selected' : '';
							?>
							<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
							<?php } ?>
							</select>
						</dt>
						<dt>    
							<b>ㆍ비밀글쓰기</b>
								<select name="bo_secret_level" id="secret_level">
								<?php 
									foreach($level_category as $level){ 
									$selected = ($level['rank']==$board['bo_secret_level']) ? 'selected' : '';
								?>
								<option value="<?php echo $level['rank'];?>" <?php echo $selected;?>><?php echo $level['name'];?> (<?php echo $level['rank'];?>레벨)</option>
								<?php } ?>
								</select>
						</dt>
					</dl>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="$('#board_level').hide();"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

					</form>

				</div>
<?php
			break;
			
			## 리스트상 게시판 카테고리(분류) 설정
			case 'board_category':

				$modes = $_POST['modes'];
				$bo_table = $board['bo_table'];
				$get_category = $category_control->pcode_List($bo_table);
?>
				<div id="board_category" class="bocol lnb_col" style="top:35%;left:33%;display:none;">
					<dl class="ntlt lnb_col m0 hand" id="categoryFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">게시판 분류설정
						<a onClick="$('#board_category').hide();"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<form name="boardCategoryFrm" method="post" id="boardCategoryFrm" action="./process/board.php">
					<input type="hidden" name="mode" value="board_category"/><!-- 카테고리 mode -->
					<input type="hidden" name="modes" value="<?php echo $modes;?>" id="mode"/><!-- 카테고리 mode (입력/수정) -->
					<input type="hidden" name="type" value="board"/>
					<input type="hidden" name="p_code" value="<?php echo $bo_table?>"/>
					<input type="hidden" name="ajax" value="1"/>
					<input type="hidden" name="no" value="<?php echo $no;?>"/>

					<table class="ttlt" width="700">
					<col span="2" width="40"><col><col width="70"><col span="2" width="56">
					<tr class="bg"><td>출력</td><td>순서</td><td>분류명</td><td>게시물수</td><td>수정</td><td class="e">삭제</td></tr>					
						<tbody id='category_lists'>
						<?php if(!$get_category){?>
						<tr><td colspan="6" class="stlt"></td></tr>
						<?php } else { ?>
						<?php 
							foreach($get_category as $category){ 
							$name = $utility->remove_quoted($category['name']);	 // (쌍)따옴표 등록시 필터링
						?>
						<tr class='category_lists' no='<?php echo $category['no'];?>'>
							<td><input name="view[]" type="checkbox" value="yes" <?php echo ($category['view']=='yes')?'checked':'';?> id="cateView_<?php echo $category['no'];?>" onclick="board_cate_view(this,'<?php echo $category['no']?>');"></td>
							<td class="none num3">
								<a onclick="change_cate_rank('up',this);">▲</a>
								<a onclick="change_cate_rank('down',this);">▼</a>
							</td>
							<td class="tl"><input name="name[]" type="text" class="txt w100" value="<?php echo $name;?>" id="cateName_<?php echo $category['no'];?>" no="<?php echo $category['no'];?>"></td>
							<td class="num3"><?php echo number_format($category['hit']);?></td>
							<td><a onClick="board_cate_update('<?php echo $category['no'];?>');"><img src="../../images/btn/19_05.gif"></a></td>
							<td class="e"><a onClick="board_cate_delete('<?php echo $category['no'];?>','<?php echo $category['p_code'];?>');"><img src="../../images/btn/19_06.gif"></a></td>
						</tr>
						<?php } // foreach end.?>
						<?php } // if end.?>
						</tbody>

						<tr class="bg_col" id="category_input">
							<td><input name="view" type="checkbox" value="yes" checked></td>
							<td class="tl" colspan="3"><input name="name" type="text" class="txt w100" hname="분류명" required></td>
							<td><input type="image" src="../../images/btn/19_01.gif"></td>
							<td class="e"><a onClick="cate_close();"><img src="../../images/btn/19_02.gif"></a></td>
						</tr>

					</table>

					</form>

					<dl class="pbtn">  
						<a onClick="$('#board_category').hide();"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>
				</div>
<?php
			break;

			## 게시물 등록/수정
			case 'insert':
			case 'update':
				$bo_table = $_POST['bo_table'];	// 게시판 고유 code
				$board = $board_config_control->get_boardTable($bo_table);	// 게시판 정보 (단수)
				
				/* 카테고리 정보 */
				$bo_category = false;
				if($board['bo_use_category'])
					$bo_category = $category_control->category_pcodeList('board',$bo_table, " rank asc ");
				/* //카테고리 정보 */

				$file_script = "";
				$file_length = -1;
				if($mode=='update') {
					$write = $board_control->get_view($bo_table, $no);
					$option = $write['wr_option'];
					$secret = $write['wr_secret'];
				    $file = $board_control->get_file($bo_table, $no);	 // 가변 파일
					$is_file_content = false;
					for ($i=0; $i<$file['count']; $i++) {
						$row = $db->query_fetch(" select file_name, file_content from `alice_board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$no."' and `file_no` = '".$i."' ");
						if ($row['file_name']) {
							$file_script .= "add_file(\"&nbsp;<input type='checkbox' name='file_no_del[$i]' value='1'><a href='{$file[$i][href]}'>{$file[$i][source]}({$file[$i][size]})</a> 파일 삭제";
							if ($is_file_content)
								$file_script .= "<br><input type='text' class=ed size=50 name='file_content[$i]' value='".addslashes($utility->get_text($row['file_content']))."' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
							$file_script .= "\");\n";
						} else
							$file_script .= "add_file('');\n";
					}
					$file_length = $file['count'] - 1;

				}
				if ($file_length < 0) {
					$file_script .= "add_file('');\n";
					$file_length = 0;
				}
				$wr_category = ($mode=='insert') ? $_POST['wr_category'] : $write['wr_category'];	// 카테고리
?>
				<div id="add_form" class="bocol lnb_col" style="top:5%;left:28%;display:none;">
				
				<form name="boardFrm" method="post" id="boardFrm" action="./process/regist.php" enctype="multipart/form-data" onSubmit="return validate(this)">
				<input type="hidden" name="mode" value="<?php echo $mode;?>"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->				
				<input type="hidden" name="code" value="<?php echo $code;?>"/>
				<input type="hidden" name="bo_table" value="<?php echo $bo_table;?>"/>
				<?php if($mode=='update'){ // 수정일때만 사용?> 
				<input type="hidden" name="no" value="<?php echo $no;?>"/>
				<?php } ?>
				<input type="hidden" name="wr_id" value="<?php echo $admin_info['uid'];?>"/>
				<input type="hidden" name="wr_password" value="<?php echo $admin_info['passwd'];?>"/>
				<input type="hidden" name="wr_link1" value="<?php echo $write['wr_link1'];?>"/>
				<input type="hidden" name="wr_link2" value="<?php echo $write['wr_link2'];?>"/>

					<dl class="ntlt lnb_col m0 hand" id="boardFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t"><?php echo stripslashes($board['bo_subject']);?> 게시물등록
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<table width="850" class="bg_col">
					<col width=80><col>
					<tr>
						<td class="ctlt">제목</td>
						<td class="pdlnb2">
							<input type="text" class="txt w50" name="wr_subject" value="<?php echo stripslashes($write['wr_subject']);?>" hname='제목' required style="ime-mode:active;"> &nbsp;
							<input name="wr_option" type="checkbox" value="notice" <?php echo ($option=='notice')?'checked':'';?>><label class="m">공지글</label>
							<input name="wr_secret" type="checkbox" value="1" <?php echo ($secret)?'checked':'';?>><label class="m">비밀글</label>
						</td>
					</tr>
					<?php if($bo_category){?>
					<tr>
					<td class="ctlt">분류</td>
					<td class="pdlnb2">
						<select name="wr_category" hname='분류' required option='select'>
							<option value="">분류</option>
							<?php foreach($bo_category as $cate){ ?>
							<option value="<?php echo $cate['code'];?>" <?php echo ($cate['code']==$wr_category)?'selected':'';?>><?php echo stripslashes($cate['name']);?></option>
							<?php } ?>
						</select>
					</td>
					</tr>
					<?php } ?>
					<tr>
						<td class="ctlt">작성자</td>
						<td class="pdlnb2">
							<input type="text" class="txt" size="20" name="wr_name" value="<?php echo $write['wr_name'] ? stripslashes($write['wr_name']) : stripslashes($admin_info['nick']);?>" hname='작성자' required style="ime-mode:active;"> &nbsp;
						</td>
					</tr>

					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2">
							<?php echo $utility->make_cheditor('wr_content', $write['wr_content']);	// 에디터 생성?>
						</td>
					</tr>
					<?php if($board['bo_use_upload']){ ?>
					<tr>
						<td class="ctlt">
							파일첨부
							<p>
							<img src="<?php echo $alice['images_path'];?>/ic/+.gif" onclick="add_file();" class="hand">
							<img src="<?php echo $alice['images_path'];?>/ic/-.gif" onclick="del_file();"  class="hand mL2">
							</p>
						</td>
						<td class="pdlnb2">
							<table align='left' id='variableFiles'></table>
							<script>
							var flen = 0;
							function add_file(delete_code){
								var upload_count = <?=(int)$board[bo_upload_count]?>;
								if (upload_count && flen >= upload_count){
									alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
									return;
								}

								var objTbl;
								var objRow;
								var objCell;
								if (document.getElementById)
									objTbl = document.getElementById("variableFiles");
								else
									objTbl = document.all["variableFiles"];

								objRow = objTbl.insertRow(objTbl.rows.length);
								objCell = objRow.insertCell(0);

								objCell.innerHTML = "<span><input type='file' class='txt mb3' name='file_name[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능' size='50' onChange=\"netfu_util1.filesize_check(this, '<?=intval($board['bo_upload_size']/1024)?>')\"></span>";
								if (delete_code)
									objCell.innerHTML += delete_code;
								else{
									<? if ($is_file_content) { ?>
									objCell.innerHTML += "<br><input type='text' class='txt' size=50 name='file_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
									<? } ?>
									;
								}

								flen++;
							}

							<?=$file_script; //수정시에 필요한 스크립트?>

							function del_file(){
								// file_length 이하로는 필드가 삭제되지 않아야 합니다.
								var file_length = <?=(int)$file_length?>;
								var objTbl = document.getElementById("variableFiles");
								if (objTbl.rows.length - 1 > file_length){
									objTbl.deleteRow(objTbl.rows.length - 1);
									flen--;
								}
							}
							</script>
						</td>
					</tr>
					<?php } ?>
					</table>

					<dl class="pbtn">  
						<input type="image" src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

				</form>
				</div>
<?php
			break;

			## 관리자 답변
			case 'admin_reply':
				$bo_table = $_POST['bo_table'];	// 게시판 고유 code
				$board = $board_config_control->get_boardTable($bo_table);	// 게시판 정보 (no 기준 추출)
				$wr_no = $_POST['wr_no'];	// 답변 게시글
				$view = $board_control->get_view($bo_table,$wr_no);

				$file_script = "";
				$file_length = -1;
				$option = $view['wr_option'];
				$secret = $view['wr_secret'];
				$file = $board_control->get_file($bo_table, $no);	 // 가변 파일
				$is_file_content = false;
				for ($i=0; $i<$file['count']; $i++) {
					$row = $db->query_fetch(" select file_name, file_content from `alice_board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$no."' and `file_no` = '".$i."' ");
					if ($row['file_name']) {
						$file_script .= "add_file(\"&nbsp;<input type='checkbox' name='file_no_del[$i]' value='1'><a href='{$file[$i][href]}'>{$file[$i][source]}({$file[$i][size]})</a> 파일 삭제";
						if ($is_file_content)
							$file_script .= "<br><input type='text' class=ed size=50 name='file_content[$i]' value='".addslashes($utility->get_text($row['file_content']))."' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
						$file_script .= "\");\n";
					} else
						$file_script .= "add_file('');\n";
				}
				$file_length = $file['count'] - 1;

				if ($file_length < 0) {
					$file_script .= "add_file('');\n";
					$file_length = 0;
				}

?>
				<div id="add_form" class="bocol lnb_col" style="top:5%;left:28%;display:none;">
				
				<form name="boardFrm" method="post" id="boardFrm" action="./process/regist.php">
				<input type="hidden" name="mode" value="reply"/>
				<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->				
				<input type="hidden" name="code" value="<?php echo $code;?>"/>
				<input type="hidden" name="bo_table" value="<?php echo $bo_table;?>"/>
				<input type="hidden" name="wr_no" value="<?php echo $wr_no;?>"/>
				<input type="hidden" name="wr_id" value="<?php echo $admin_info['uid'];?>"/>
				<input type="hidden" name="wr_password" value="<?php echo $admin_info['passwd'];?>"/>
				<input type="hidden" name="wr_link1" value="<?php echo $view['wr_link1'];?>"/>
				<input type="hidden" name="wr_link2" value="<?php echo $view['wr_link2'];?>"/>
				<input type="hidden" name="wr_category" value="<?php echo $get_view['wr_category'];?>"/>

					<dl class="ntlt lnb_col m0 hand" id="boardFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">게시판명 글보기
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>
					<table width="850" class="bg_col tf">
					<col width=65><col><col width=65><col>
					<tr>
						<td class="ctlt">제목</td>
						<td class="pdlnb2" colspan="3"><?php echo stripslashes($view['subject']);?></td>
					</tr>
					<tr>
						<td class="ctlt">작성자</td>
						<td class="pdlnb2"><?php echo stripslashes($view['wr_name']);?></td>
						<td class="ctlt">작성일</td>
						<td class="pdlnb2 num3"><?php echo $view['datetime2'];?></td>
					</tr>
					<?php if($view['file']['count']){ ?>
					<tr>
						<td class="ctlt">첨부파일</td>
						<td class="pdlnb2 h20" colspan="3">
							<table>
							<?php
								// 가변 파일
								$cnt = 0;
								for ($i=0; $i<$view['file']['count']; $i++) {
									if ($view['file'][$i]['source'] && !$view[file][$i]['view']) {
										$cnt++;
										echo "<tr><td>";
										echo "<img src='../../images/ic/file.gif' align=absmiddle border='0'>";
										echo "<a href=\"javascript:file_download('{$view[file][$i][href]}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'>";
										echo "&nbsp;<span style=\"color:#888;\">{$view[file][$i][source]} ({$view[file][$i][size]})</span>";
										echo "&nbsp;<span style=\"color:#ff6600; font-size:11px;\">[{$view[file][$i][download]}]</span>";
										echo "&nbsp;<span style=\"color:#d3d3d3; font-size:11px;\">DATE : {$view[file][$i][datetime]}</span>";
										echo "</a></td></tr>";
									}
								}
							?>
							</table>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2 h20" colspan="3"><?php echo $view['content'];?></td>
					</tr>
					</table>

					<dl class="ntlt lnb_col"><img src="../../images/comn/bul_10.png" class="t">게시판명 답변쓰기</dl>
					<table width="850" class="bg_col">
					<col width=65><col>
					<tr>
						<td class="ctlt">작성자</td>
						<td class="pdlnb2">
							<input type="text" class="txt" size="20" name="wr_name" value="<?php echo stripslashes($admin_info['nick']);?>" hname='작성자' required style="ime-mode:active;">
							<?php if($secret == 1) { ?><input name="wr_secret" type="checkbox" value="1" checked><label class="m">비밀글</label><?php } ?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">답변제목</td>
						<td class="pdlnb2">
							<input type="text" class="txt w100" name="wr_subject" value="[답변] <?php echo stripslashes($view['subject']);?>" hname='답변제목' required style="ime-mode:active;">
						</td>
					</tr>
					<tr>
						<td class="ctlt">내용</td>
						<td class="pdlnb2">
							<?php echo $utility->make_cheditor('wr_content', $write['wr_content']);	// 에디터 생성?>
						</td>
					</tr>
					<?php if($board['bo_use_upload']){ ?>
					<tr>
						<td class="ctlt">
							파일첨부
							<p>
							<img src="<?php echo $alice['images_path'];?>/ic/+.gif" onclick="add_file();" class="hand">
							<img src="<?php echo $alice['images_path'];?>/ic/-.gif" onclick="del_file();"  class="hand mL2">
							</p>
						</td>
						<td class="pdlnb2">
							<table align='left' id='variableFiles'></table>
							<script>
							var flen = 0;
							function add_file(delete_code){
								var upload_count = <?=(int)$board[bo_upload_count]?>;
								if (upload_count && flen >= upload_count){
									alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
									return;
								}

								var objTbl;
								var objRow;
								var objCell;
								if (document.getElementById)
									objTbl = document.getElementById("variableFiles");
								else
									objTbl = document.all["variableFiles"];

								objRow = objTbl.insertRow(objTbl.rows.length);
								objCell = objRow.insertCell(0);

								objCell.innerHTML = "<input type='file' class='txt mb3' name='file_name[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능' size='50'>";
								if (delete_code)
									objCell.innerHTML += delete_code;
								else{
									<? if ($is_file_content) { ?>
									objCell.innerHTML += "<br><input type='text' class='txt' size=50 name='file_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
									<? } ?>
									;
								}

								flen++;
							}

							<?=$file_script; //수정시에 필요한 스크립트?>

							function del_file(){
								// file_length 이하로는 필드가 삭제되지 않아야 합니다.
								var file_length = <?=(int)$file_length?>;
								var objTbl = document.getElementById("variableFiles");
								if (objTbl.rows.length - 1 > file_length){
									objTbl.deleteRow(objTbl.rows.length - 1);
									flen--;
								}
							}
							</script>
						</td>
					</tr>
					<?php } ?>
					</table>

					<dl class="pbtn">  
						<input type="image" src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

				</form>
				</div>
<?php
			break;
			
		}
?>