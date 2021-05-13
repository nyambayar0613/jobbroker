<?php
		/*
		* /application/nad/payment/views/_load/package.php
		* @author Harimao
		* @since 2015/03/23
		* @last update 2015/04/07
		* @Module v3.5 ( Alice )
		* @Brief :: Package load layer
		* @Comment :: 패키지 결제
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];
		$wr_type = $_POST['wr_type'];

		$package_service = $service_control->package_service[$wr_type];

		$data = $package_control->get_package($no);
		$wr_content = unserialize($data['wr_content']);

		switch($mode){

			## 패키지 정보 입력
			case 'package_insert':
			case 'package_update':

?>
				<div id="add_form" class="bocol lnb_col" style="top:5%;left:33%;display:none;">

					<form name="packageFrm" method="post" id="packageFrm" action="./process/regist.php" enctype="multipart/form-data">
					<input type="hidden" name="mode" value="<?php echo $mode;?>" id="mode"/>
					<input type="hidden" name="no" value="<?php echo $no;?>" id="no"/>
					<input type="hidden" name="wr_type" value="<?php echo $wr_type;?>" id="wr_type"/>

					<dl class="ntlt lnb_col m0 hand" id="packageFrmHandle">
						<img src="../../images/comn/bul_10.png" class="t">패키지 유료설정 정보 <?php echo ($mode=='package_insert')?'등록':'수정';?>
						<span>( <b class="col">*</b> 표시는 필수 입력사항 )</span>
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>

					<table width="700" class="bg_col">
					<col width="100px"><col>
					<tr>
						<td class="ctlt">패키지 사용여부</td>
						<td class="pdlnb2">
							<label><input type="radio" class="chk" name="wr_use" id="wr_use_1" value="1" checked/>사용</label>&nbsp;
							<label><input type="radio" class="chk" name="wr_use" id="wr_use_0" value="0" <?php echo ($mode=='package_update'&&!$data['wr_use'])?'checked':'';?>/> 미사용</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="ctlt">패키지 제목</td>
						<td class="pdlnb2">
							<input style="width:98%;" name="wr_subject" id="wr_subject" type="text" class="txt" value="<?php echo $data['wr_subject'];?>" required hname='패키지제목'/>
						</td>
					</tr>
					<tr>
						<td class="ctlt">패키지 설명</td>
						<td class="pdlnb2">
							<?php echo $utility->make_cheditor('wr_brief',$data['wr_brief']);?>
						</td>
					</tr>
					<tr>
						<td class="ctlt">패키지 금액</td>
						<td class="pdlnb2">
							<input style="width:200px;ime-mode:disabled;" name="wr_price" id="wr_price" type="text" class="tnum" value="<?php echo $data['wr_price'];?>" required hname='패키지금액' placeholder="0" data-v-min="0" data-v-max="10000000000"/> 원
						</td>
					</tr>
					<tr>
						<td class="ctlt">패키지 내용</td>
						<td class="pdlnb2">
							<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
							<col width="250px"><col>
							<?php 
							foreach($package_service as $key => $val){ 
							$is_jump_service = false;
							if($key=='alba_option_jump' || $key=='resume_option_jump'){
								$is_jump_service = true;
							}
							?>
							<tr>
								<td class="ctlt"><label><input type="checkbox" class="typeCheckbox" name="wr_content[<?php echo $key;?>][use]" value="1" <?php echo ($wr_content[$key]['use'])?'checked':'';?>/> <?php echo $val;?></label>&nbsp;</td>
								<td>
								<?php if($is_jump_service) { ?>
									<input name="wr_content[<?php echo $key;?>][jump_count]" type="text" class="tnum tc" size="3" required hname='서비스설정 값' value="<?php echo $wr_content[$key]['jump_count'];?>" placeholder="0">
                                <?php }else{ ?>
									<input name="wr_content[<?php echo $key;?>][service_count]" type="text" class="tnum" size="3" required hname='서비스설정 값' value="<?php echo $wr_content[$key]['service_count'];?>" placeholder="0" style="text-align:center;">
                                <?php } ?>
									<?php if($key=='etc_sms' || $is_jump_service){ ?>
									<input type="hidden" name="wr_content[<?php echo $key;?>][service_unit]" value="count"/>건
									<?php } else { ?>
									<select name="wr_content[<?php echo $key;?>][service_unit]">
										<option value='day' <?php echo ($wr_content[$key]['service_unit']=='day')?'selected':'';?>>일</option>
										<option value='month' <?php echo ($wr_content[$key]['service_unit']=='month')?'selected':'';?>>개월</option>
										<option value='year' <?php echo ($wr_content[$key]['service_unit']=='year')?'selected':'';?>>년</option>
										<?php if($key=='etc_open' || $key=='etc_alba'){ ?>
										<option value='count' <?php echo ($wr_content[$key]['service_unit']=='count')?'selected':'';?>>건</option>
										<?php } ?>
									</select>&nbsp;
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
							</table>
						</td>
					</tr>
					</table>

					<dl class="pbtn">  
						<img src="../../images/btn/b23_02.png" class="ln_col hand" onclick="packageFrm_submit();">&nbsp;
						<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

					</form>

				</div>
<?php
			break;

		}
?>