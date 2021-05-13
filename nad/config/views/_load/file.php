<?php
		/*
		* /application/nad/config/views/_load/file.php
		* @author Harimao
		* @since 2014/03/10
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: File directory
		* @Comment :: 파일 디렉토리 구조도
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$images_path = "../../images/description_img";

		$mode = $_POST['mode'];
		$dir = $_POST['dir'];

		switch($mode){

			## 디렉토리 구조
			case 'dir';

				$dir = (in_array($_POST['dir'], array("","./","undefine"))) ? $DOCUMENT_ROOT : $_POST['dir'];
				$location = ($dir==$DOCUMENT_ROOT) ? "./" : str_replace($DOCUMENT_ROOT,'',$dir);
				if(substr($dir, -1) != '/') $dir .= '/';


				$fulls = @array_merge($description_control->searchdir($dir,1,"DIRS"),$description_control->searchdir($dir,0,"FILES"));

				if(is_array($fulls)) {

					$DATA = $db->query_fetch_rows(" select * from `".$description_control->description_table."` where `location` = '".$location."' ");

					if(is_array($DATA)) {

						foreach($DATA as $ROW) {
							if($ROW['kind']=='D') { // 폴더가 존재하지 않으면 삭제할 인덱스값 저장

								if(!is_dir($dir.$ROW['object'])) 
									$delRecord[] = $ROW['no'];
								else 
									$DESCRIPTION[$ROW['kind']][$ROW['object']] = $ROW['description'];

							} else { // 파일이 존재하지 않으면 삭제할 인덱스값 저장

								if(!is_file($dir.$ROW['object'])) 
									$delRecord[] = $ROW['no'];
								else 
									$DESCRIPTION[$ROW['kind']][$ROW['object']] = $ROW['description'];

							}

						}	// foreach end.

						// 존재하지 않는 객체(파일 or 폴더)에 대한 Record 삭제 처리
						if(is_array($delRecord)) 
							$db->_query(" delete from `".$description_control->description_table."` where `no` in(".join(',',$delRecord).") ");
					}

					foreach($fulls as $ROW) {
						$base_name = array_reverse(explode("/",$ROW));
						if(is_dir($ROW)) { // 폴더인경우
							$base_name = $base_name[1];
							$url = $dir.$base_name.'/';
							$out_dir = ($ROW==$dir) ? ($dir==$DOCUMENT_ROOT) ? ".." : "<a onclick=getList('".eregi_replace("/$base_name/$",'',$dir)."/')>..</a>" : "<a onclick=getList('".$url."')>".$base_name."</a>";
							$icon = "<img src='".$images_path."/icon_folder.gif' align=absmiddle>";
							$fsize = "";
							$ctime = @$description_control->printDate(filectime($dir));
							$kind = "D";
						} else { // 파일인경우
							$base_name = $base_name[0];
							$url = $dir.$base_name.'/';
							$out_dir = str_replace($dir,'',$ROW);
							$fsize = number_format(filesize($dir.$out_dir));
							$ctime = @$description_control->printDate(filectime($dir.$out_dir));
							$kind = "F";

							// 파일 아이콘
							$file_ext = strtolower(array_pop(explode('.',$ROW)));
							$icon = (is_file("".$images_path."/icon_".$file_ext.gif."")) ? "<img src='".$images_path."/icon_".$file_ext.gif."' align=absbottom>" : "<img src='".$images_path."/icon_dat.gif' align=absbottom>";

							// 이미지파일의 경우 링크 생성
							if(in_array($file_ext, array("gif","jpg","png","swf","bmp"))) {
								list($_width, $_height, $_type, $_attr) = @getimagesize($ROW);
								switch($_type) {
									case in_array($_type, array(1,2,3,6)) : // GIF, JPG, PNG, BMP
										$file = str_replace(" ","%20",str_replace($DOCUMENT_ROOT,'',$ROW)); // 파일명 공백 치환
										$out_dir = "<a onclick=imageView('http://".$_SERVER['SERVER_NAME'].$base_url.$file."') title='클릭-이미지보기'>".$out_dir."</a><img src='http://".$_SERVER['SERVER_NAME']."/".$file."' width=0 height=0 style='display:none;'>";
										$preloadImg[] = "http://".$_SERVER['SERVER_NAME']."/".$file;
										break;
									case 4: default: // SWF or etc.
										break;
								}
							}
						}

						if($ROW==$dir) { // 상위폴더( .. )
							$modify_btn = "";
							$desc = "";
						} else {
							$aLink = ($is_demo) ? "alert('죄송합니다. 데모버젼에서는 편집할 수 없습니다.')" : "viewDescFrmDiv('".$base_name."','".$kind."')";
							$modify_btn = "<a onclick=\"".$aLink."\"><img src='".$images_path."/icon_modify.gif' border=0 align=absmiddle alt='편집'></a>";
							$desc = ($ROW==$dir) ? "" : "<a onclick=\"".$aLink."\"><div id='".$base_name."' style='overflow-y:hidden'>".$DESCRIPTION[$kind][$base_name]."</div></a>";
						}
						$dirList .= "<tr height=20".$bgcolor.">";
						$dirList .= "	<td>";
						$dirList .= "		<table width=100% cellpadding=0 cellspacing=0>";
						$dirList .= "		<tr>";
						$dirList .= "			<td width=16 align=center>".$icon."</td>";
						$dirList .= "			<td width=4></td>";
						$dirList .= "			<td>".$out_dir."</td>";
						$dirList .= "		</tr>";
						$dirList .= "		</table>";
						$dirList .= "		</td>";
						$dirList .= "		<td style='color:#BCBCBC'>".$fsize."</td>";
						$dirList .= "		<td>".$ctime."</td>";
						$dirList .= "		<td>";
						$dirList .= "			<table width=100% cellpadding=0 cellspacing=0>";
						$dirList .= "			<tr id='".$base_name."_".$kind."'>";
						$dirList .= "				<td width=24>".$modify_btn."</td>";
						$dirList .= "				<td>".$desc."</td>";
						$dirList .= "			</tr>";
						$dirList .= "		</table>";
						$dirList .= "	</td>";
						$dirList .= "</tr>";

						$bgcolor = empty($bgcolor) ? " bgcolor=#FAFAFA" : "";
					}

				}
?>
				<table width="100%" cellpadding="3" cellspacing="1" bgcolor='#FFFFFF'>
				<col width="250"><col width="80" align="right"><col width="120" align="center"><col>
				<tbody bgcolor="white">
				<tr>
					<td colspan="5" style="height:22px; color:#0033CC;"><img src='<?php echo $images_path;?>/icon_folder_open.gif' align=absmiddle> <?php echo $dir;?></td>
				</tr>
				<tr height="1"bgcolor="#ACACAC">
					<td style='padding:0px'></td>
					<td style='padding:0px'></td>
					<td style='padding:0px'></td>
					<td style='padding:0px'></td>
				</tr>
				<tr align="center" bgcolor="#EEE">
					<td class="d8" style="background-color:#EEE; height:18px; border-right:1px solid #ACACAC;">name</td>
					<td class="d8" style="background-color:#EEE; border-right:1px solid #ACACAC;" align="center">size</td>
					<td class="d8" style="background-color:#EEE; border-right:1px solid #ACACAC;">date</td>
					<td class="d8" style="background-color:#EEE;">comment</td>
				</tr>
				<?php echo $dirList;?>
				<tr height="1" bgcolor="#DEDEDE">
					<td style='padding:0px'></td>
					<td style='padding:0px'></td>
					<td style='padding:0px'></td>
					<td style='padding:0px'></td>
				</tr>
				</tbody>
				</table>
<?php
			break;

			## 코멘트 수정
			case 'comment_update':
?>
				<div id="pop_comment" class="bocol lnb_col" style="top:10%;left:33%;display:;">
					<dl class="ntlt lnb_col m0 hand" id="commentHandle">
						<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><img src="<?php echo $images_path;?>/icon_table.gif" align="absmiddle" title="TABLE명" alt="TABLE명"></td>
							<td nowrap style="overflow-x:hidden"><span id="destination" style="padding:2 2 0 2px;background-color:#DEDEDE;color:#333399;border:silver 1 dotted;line-height:150%"><?php echo $dir;?></span><font color="gray">'s Description</font></td>
						</tr>
						</table>
						<a onClick="MM_showHideLayers('pop_comment','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  
					<form name="descFrm" method="POST" action="./process/description.php" id="descFrm">
					<input type="hidden" name="ajax" value="1">
					<input type="hidden" name="mode" value="file_comment">
					<input type="hidden" name="flocation" id="flocation">
					<input type="hidden" name="fobject" id="fobject">
					<input type="hidden" name="fkind" id="fkind">

					<table width="250" height="100%" cellpadding="3" cellspacing="0" border="0">
					<tbody align="center">
					<tr height="30">
						<td colspan="2"><input type="text" name="description" maxlength="255" class='tnum' style="width:100%;" id="description"></td>
					</tr>
					</tbody>

					</table>

					<dl class="pbtn">  
						<input type='image' src="../../images/btn/b23_02.png" class="ln_col">&nbsp;
						<a onClick="MM_showHideLayers('pop_comment','','hide')"><img src="../../images/btn/23_10.gif"></a></a>
					</dl>

					</form>
				</div>

<?php
			break;
		}

?>