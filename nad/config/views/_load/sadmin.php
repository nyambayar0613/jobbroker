<?php
		/*
		* /application/nad/config/views/_load/sadmin.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Second level admin Setting
		* @Comment :: 부관리자 설정시 읽어들이는 폼
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";
		include_once $alice['path'] . "engine/config/menu_config.php";	// 메뉴설정 및 변수 정의 파일

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$uid = $_POST['uid'];

		$get_admin = $admin_control->get_admin($uid);	 // 부관리자 기본 정보
		$get_admin_auth = $admin_control->get_admin_auth($uid);	 // 부관리자 접근 메뉴

		$top_menu = explode(',',$get_admin_auth['top_menu']);
		$middle_menu = explode(',',$get_admin_auth['middle_menu']);
		$sub_menu = explode(',',$get_admin_auth['sub_menu']);

		if($mode!='sadmin_insert'){
?>

	<form name="AdminRegistFrm" method="post" id="AdminRegistFrm" action="./process/admin.php">
	<input type="hidden" name="mode" value="<?php echo $mode;?>" id="mode"/><!-- 부관리자 등록 -->
	<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
	<input type="hidden" name="level" value="9"/><!-- 부관리자의 경우 level 을 9 로 설정 -->
	<input type="hidden" name="uid" value="<?php echo $get_admin['uid'];?>"/>

		<dl class="ntlt lnb_col m0 hand" id="addFrmHandle">
			<img src="../../images/comn/bul_10.png" class="t">부관리자 설정
			<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
		</dl>

		<table width="100%" class="bg_col">
		<col width=80><col><col width=80><col><col width=80><col>
		<tr>
			<td class="ctlt">관리자아이디</td>
			<td class="pdlnb2"><?php echo $get_admin['uid'];?></td>
			<td class="ctlt">관리자명</td>
			<td class="pdlnb2">
				<?php if($mode=='sadmin_update'){ ?>
				<input  style="width:150px;" name="name" type="text" class="txt " id="name" style="ime-mode:active;" required hname='관리자명' value="<?php echo $get_admin['name'];?>">
				<?php } else echo $get_admin['name']; ?>
			</td>
			<td class="ctlt">관리자닉네임</td>
			<td class="pdlnb2" >
				<?php if($mode=='sadmin_update'){ ?>
				<input name="nick" type="text" class="tnum" id="nick" style="width:150px;ime-mode:active;" required hname='관리자닉네임' value="<?php echo $get_admin['nick'];?>">
				<?php } else echo $get_admin['nick']; ?>
			</td>
		</tr>
		<tr>
			
		</tr>
		<?php if($mode=='sadmin_update'){ ?>
		<tr>
			<td class="ctlt">비밀번호</td>
			<td class="pdlnb2"><input  style="width:150px;" name="password" type="password" class="tnum " id="password" <?php echo ($mode!='sadmin_update')?"minbyte=6 maxbyte=20 hname='비밀번호' required":"";?> matching="password_re"></td>
			<td class="ctlt">비밀번호확인</td>
			<td class="pdlnb2" colspan="3"><input  style="width:150px;" name="password_re" type="password" class="tnum " id="password_re" hname="비밀번호확인"></td>
		</tr>
		<?php } ?>
		</table>

		<dl class="mt10 lnb lnt ctlt bg tc" style="line-height:29px">부관리자가 사용가능한 메뉴 선택</dl>
		<dl class="xflow mt5 lnb" style="width:770px;margin-right:-5px">
			<?php
				$t = 0;
				foreach($top_menus as $key => $val){
					$_key = substr($key, 0, 3);
			?>
			<dl class="clearfix" style="margin:15px 0; width:99%;border:1px solid #ddd; border-top:none; background:url(../../images/main/bg_line_1.gif) repeat-y 50% 0">
				<dt class="bg_col lnb2_col pd3 pl5 ba b col">
					<input name="top_menu[]" type="checkbox" value="<?php echo $key;?>" class="check" id="top_menu_<?php echo $t;?>" onclick="top_menu(this);" <?php echo (in_array($key,$top_menu))?'checked':'';?> /><label for="top_menu_<?php echo $t;?>"><?php echo $val;?></label>
				</dt>
				<?php
					$m = 0;
					foreach($menu[$_key]['menus'] as $mkey => $mval){
				?>
				<ul class="s11lst  w50 fl" style=" padding-top:5px; margin-left:-1px; margin-right:-1px; ">
					<label style="cursor:normal; margin-left:10px;">
						<h1 class="bk f11">
							<input name="middle_menu[]" type="checkbox" value="<?php echo $mval['code'];?>" class="check <?php echo $key;?>" id="middle_menu_<?php echo $m;?>" onclick="middle_menu(this);" <?php echo (in_array($mval['code'],$middle_menu))?'checked':'';?> /><?php echo $mval['name'];?>
						</h1>
					</label>
					<?php
						$s = 0;
						foreach($mval['sub_menu'] as $skey => $sval){
					?>
					<li class="" style="margin-left:20px;letter-spacing:-0.05em">
						<input name="sub_menu[]" type="checkbox" value="<?php echo $sval['code'];?>" class="check <?php echo $key;?> <?php echo $mval['code'];?>" <?php echo (in_array($sval['code'],$sub_menu))?'checked':'';?> /><?php echo $sval['name'];?>
						<span class="subtlt">[<?php echo strtr($sval['url'],'..',' ');?> ]</span>
					</li>
					<?php
						$s++;
						}	// sub menu foreach end.
					?>
				</ul>
				<?php
					$m++;
					}	// middle menu foreach end.
				?>
			</dl>
			<?php
				$t++;
				}	// top menus foreach end.
			?>
		</dl>
		<dl class="pbtn">  
			<?php if($mode!='get_sadmin'){?><input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;<?php } ?>
			<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
		</dl>

	</form>
<?php } else {?>
	<form name="AdminRegistFrm" method="post" id="AdminRegistFrm" action="./process/admin.php">
	<input type="hidden" name="mode" value="sadmin_insert" id="mode"/><!-- 부관리자 등록 -->
	<input type="hidden" name="ajax" value="1"/><!-- ajax mode 유무 -->
	<input type="hidden" name="level" value="9"/><!-- 부관리자의 경우 level 을 9 로 설정 -->

		<dl class="ntlt lnb_col m0 hand" id="addFrmHandle">
			<img src="../../images/comn/bul_10.png" class="t">부관리자 설정
			<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
		</dl>

		<table width="100%" class="bg_col">
		<col width=80><col><col width=80><col><col width=80><col>
		<tr>
			<td class="ctlt">관리자아이디</td>
			<td class="pdlnb2"><input  style="width:150px;" name="uid" type="text" class="tnum " id="uid" style="ime-mode:disabled;" maxbyte=20 required hname='관리자아이디'></td>
			<td class="ctlt">관리자명</td>
			<td class="pdlnb2"><input  style="width:150px;" name="name" type="text" class="txt " id="name" style="ime-mode:active;" required hname='관리자명'></td>
					<td class="ctlt">관리자닉네임</td>
			<td class="pdlnb2" ><input name="nick" type="text" class="tnum" id="nick" style="width:150px; ime-mode:active;" required hname='관리자닉네임'></td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td class="ctlt">비밀번호</td>
			<td class="pdlnb2"><input  style="width:150px;" name="password" type="password" class="tnum" id="password" minbyte=6 maxbyte=20 hname="비밀번호" required matching="password_re"></td>
			<td class="ctlt">비밀번호확인</td>
			<td class="pdlnb2" colspan="3"><input style="width:150px;" name="password_re" type="password" class="tnum" id="password_re" hname="비밀번호확인"></td>
		</tr>
		</table>

		<dl class="mt10 lnb lnt ctlt bg tc" style="line-height:29px">부관리자가 사용가능한 메뉴 선택</dl>
		<dl class="xflow mt5 lnb" style="width:770px;margin-right:-5px">
			<?php
				$t = 0;
				foreach($top_menus as $key => $val){
					$_key = substr($key, 0, 3);
			?>
			<dl class="clearfix" style="margin:15px 0; width:99%;border:1px solid #ddd; border-top:none; background:url(../../images/main/bg_line_1.gif) repeat-y 50% 0">
				<dt class="bg_col lnb2_col pd3 pl5 ba b col">
					<input name="top_menu[]" type="checkbox" value="<?php echo $key;?>" class="check" id="top_menu_<?php echo $t;?>" onclick="top_menu(this);" checked /><label for="top_menu_<?php echo $t;?>"><?php echo $val;?></label>
				</dt>
				<?php
					$m = 0;
					foreach($menu[$_key]['menus'] as $mkey => $mval){
				?>
				<ul class="s11lst  w50 fl" style=" padding-top:5px; margin-left:-1px; margin-right:-1px; ">
					<label style="cursor:normal; margin-left:10px;">
						<h1 class="bk f11">
							<input name="middle_menu[]" type="checkbox" value="<?php echo $mval['code'];?>" class="check <?php echo $key;?>" id="middle_menu_<?php echo $m;?>" onclick="middle_menu(this);" checked /><?php echo $mval['name'];?>
						</h1>
					</label>
					<?php
						foreach($mval['sub_menu'] as $skey => $sval){
					?>
					<li class="" style="margin-left:20px;letter-spacing:-0.05em">
						<input name="sub_menu[]" type="checkbox" value="<?php echo $sval['code'];?>" class="check <?php echo $key;?> <?php echo $mval['code'];?>" checked /><?php echo $sval['name'];?>
						<span class="subtlt">[<?php echo strtr($sval['url'],'..',' ');?> ]</span>
					</li>
					<?php
						}	// sub menu foreach end.
					?>
				</ul>
				<?php
					$m++;
					}	// middle menu foreach end.
				?>
			</dl>
			<?php
				$t++;
				}	// top menus foreach end.
			?>
		</dl>
		<dl class="pbtn">  
			<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
			<a onClick="MM_showHideLayers('add_form','','hide')"><img src="../../images/btn/23_10.gif"></a>
		</dl>

	</form>
<?php }?>