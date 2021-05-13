<?php
		/*
		* /application/nad/config/views/_load/scheme.php
		* @author Harimao
		* @since 2014/03/07
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: DB Scheme
		* @Comment :: 데이터베이스 스키마 구조도
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$table = $_POST['table'];

		$DATA = $description_control->description_kind( $table, 'T' );
		$DATAS = array();

		$images_path = "../../images";

		switch($mode){

			## DB 정보 보기
			case 'DB':

				foreach($DATA['DATA'] as $rows) {
					$value = array_values($rows);
					$ROW = $DATAS[] = $value[0];
					$aLink = ($is_demo) ? "alert('죄송합니다. 데모버젼에서는 편집할 수 없습니다.')" : "viewDescFrmDiv('".$ROW."')";
					$modify_btn = "<a onClick=\"".$aLink."\"><img src='".$images_path."/description_img/icon_modify.gif' border=0 align=absmiddle alt='편집'></a>";
					$desc = ($ROW==$dir) ? "" : "<a onClick=\"".$aLink."\"><div id='".$ROW."'>".stripslashes($DATA['DESCRIPTION'][$ROW])."</div></a>";

					$tableAddList .= "<tr height=20".$bgcolor." id='table_".$ROW."'>";
					$tableAddList .= "	<td>";
					$tableAddList .= "		<table width=100% cellpadding=0 cellspacing=0>";
					$tableAddList .= "		<tr>";
					$tableAddList .= "			<td width=20><img src='".$images_path."/description_img/icon_table.gif' align=absmiddle alt='TABLE명'></td>";
					$tableAddList .= "			<td><a onclick=\"getInfo('".$ROW."')\" title='클릭-내용보기'>".$ROW."</a></td>";
					$tableAddList .= "		</tr>";
					$tableAddList .= "		</table>";
					$tableAddList .= "	</td>";
					$tableAddList .= "	<td>";
					$tableAddList .= "		<table width=100% cellpadding=0 cellspacing=0>";
					$tableAddList .= "		<tr>";
					$tableAddList .= "			<td width=24>".$modify_btn."</td>";
					$tableAddList .= "			<td>".$desc."</td>";
					$tableAddList .= "		</tr>";
					$tableAddList .= "		</table>";
					$tableAddList .= "	</td>";
					$tableAddList .= "</tr>";

					$bgcolor = empty($bgcolor) ? " bgcolor=#F7F7F7" : "";
				}
				
				$CDATA = $db->query_fetch_rows(" select * from `".$description_control->description_table."` where `kind` = '".$kind."' and `object` = '".$object."' ");
				if(is_array($CDATA)) foreach($CDATA as $CROW) $DESCRIPTION[$CROW['location']] = $CROW['description'];

				// 존재하지 않는 객체(테이블)에 대한 Record 삭제 처리
				if(is_array($CDATA)) {
					foreach($CDATA as $CROW) if(!in_array($CROW['location'],$DATAS)) $delRecord[] = $CROW[idx];
					if(is_array($delRecord)) $db->_query("delete from `".$description_control->description_table."` where `no` in(".join(',',$delRecord).")");
				}

				$tableList  = "<table width=100% cellpadding=3 cellspacing=1 bgcolor='#FFFFFF'>";
				$tableList .= "<col width=250><col>";
				$tableList .= "<tbody bgcolor=white>";
				$tableList .= "<tr>";
				$tableList .= "	<td colspan=2 style='color:#0033CC; height:22px;'><img src='".$images_path."/description_img/icon_host.gif' align=absmiddle alt='HOST명'> ".$db->db_host." &nbsp; <img src='".$images_path."/description_img/icon_db.gif' align=absmiddle alt='DB명'> ".$db->db_name."</td>";
				$tableList .= "</tr>";
				$tableList .= "<tr height=1 bgcolor=#ACACAC>";
				$tableList .= "	<td style='padding:0px'></td>";
				$tableList .= "	<td style='padding:0px'></td>";
				$tableList .= "</tr>";
				$tableList .= "<tr align=center bgcolor=#EDEDED>";
				$tableList .= "	<td class=d8 style='height:18px; border-right:1px solid #ACACAC'>Table Name</td>";
				$tableList .= "	<td class=d8>Comment</td>";
				$tableList .= "</tr>";
				$tableList .= $tableAddList;
				$tableList .= "<tr height=1 bgcolor=#DEDEDE>";
				$tableList .= "	<td style='padding:0px'></td>";
				$tableList .= "	<td style='padding:0px'></td>";
				$tableList .= "</tr>";
				$tableList .= "</tbody>";
				$tableList .= "</table>";

				echo $tableList;

			break;

			## TABLE 정보 보기
			case 'TABLE':

				foreach($DATA['DATA'] as $ROW) { // Field, Type, Null (YES|NO), Key(PRI|UNI|MUL| ), Default(NULL|), Extra (auto_increment)
					$flags = explode(" ",$ROW['Type']);
					if(count($flags)>1) {
						$flags = strtoupper(array_pop($flags));
						$ROW[Type] = eregi_replace($flags,'',$ROW['Type']);
					} else $flags = '';
					$type = array_pop(array_reverse(explode("(",$ROW['Type'])));
					$ROW['Type'] = str_replace($type,strtoupper($type),str_replace(",","</font>,<font color=#3399CC>",str_replace(")","</font>)",str_replace("(","(<font color=#3399CC>",$ROW['Type']))));
					$type = (in_array($type,array("int","float","double","integer","tinyint","smallint","mediumint","bigint") ) || $type=="enum") ? ($type=="enum") ? "enum" : "num" : "char";
					$default_value = (is_numeric($ROW['Default']) || empty($ROW['Default'])) ? $ROW['Default'] : "'".$ROW['Default']."'";

					// 삭제용
					$FIELD[] = $ROW['Field'];

					// 기본 아이콘 설정
					$key_icon = ($ROW['Key']=="PRI") ? "<img src='".$images_path."/description_img/icon_primary.gif' align=absmiddle alt='Primary Key'>" : "<img src='".$images_path."/description_img/icon_normal.gif' align=absmiddle>";
					$type_icon = "<img src='".$images_path."/description_img/icon_".$type.".gif' align=absmiddle>";
					$null_icon = ($ROW['Null']=="") ? "<img src='".$images_path."/description_img/icon_check.gif' alt='check'>" : "";
					$ai_icon = ($ROW['Extra']=="auto_increment") ? "<img src='".$images_path."/description_img/icon_check.gif' alt='check'>" : "";

					// 링크 및 코멘트
					$aLink = ($is_demo) ? "alert('죄송합니다. 데모버젼에서는 편집할 수 없습니다.')" : "viewDescFrmDiv('".$table."','".$ROW['Field']."')";
					$modify_btn = "<a onclick=\"".$aLink."\"><img src='".$images_path."/description_img/icon_modify.gif' border=0 align=absmiddle alt='편집'></a>";
					$desc = ($ROW==$dir) ? "" : "<a onclick=\"".$aLink."\"><div id='".$table.$ROW['Field']."'>".$DATA['DESCRIPTION'][$ROW['Field']]."</div></a>";

					$tableList .= "<tr height=22".$bgcolor.">";
					$tableList .= "	<td>";
					$tableList .= "		<table width=100% cellpadding=0 cellspacing=0>";
					$tableList .= "		<tr>";
					$tableList .= "			<td style='width:10%;'>".$key_icon."</td>";
					$tableList .= "			<td class=gd8>".$ROW['Field']."</td>";
					$tableList .= "		</tr>";
					$tableList .= "		</table>";
					$tableList .= "	</td>";
					$tableList .= "	<td>";
					$tableList .= "		<table width=100% cellpadding=0 cellspacing=0>";
					$tableList .= "		<tr>";
					$tableList .= "			<td width=20>".$type_icon."</td>";
					$tableList .= "			<td class=gd8>".$ROW['Type']."</td>";
					$tableList .= "		</tr>";
					$tableList .= "		</table>";
					$tableList .= "	</td>";
					$tableList .= "	<td style='text-align:center;'>".$null_icon."</td>";
					$tableList .= "	<td style='text-align:center;'>".$ai_icon."</td>";
					$tableList .= "	<td class='gd8' style='text-align:center;'>".$flags."</td>";
					$tableList .= "	<td class=gd8 style='color:#3399CC;text-align:center;'>".$default_value."</td>";
					$tableList .= "	<td>";
					$tableList .= "		<table width=100% cellpadding=0 cellspacing=0>";
					$tableList .= "		<tr>";
					$tableList .= "			<td width=24>".$modify_btn."</td>";
					$tableList .= "			<td>".$desc."</td>";
					$tableList .= "		</tr>";
					$tableList .= "		</table>";
					$tableList .= "	</td>";
					$tableList .= "</tr>";
					$bgcolor = empty($bgcolor) ? " bgcolor=#F7F7F7" : "";
				}	// foreach end.


				$CDATA = $db->query_fetch_rows(" select * from `".$description_control->description_table."` where `kind` = '".$kind."' and `location` = '".$table."' and `object` <> '' ");
				if(is_array($CDATA)) foreach($CDATA as $CROW) $DESCRIPTION[$CROW['location']] = $CROW['description'];

				// 존재하지 않는 객체(테이블)에 대한 Record 삭제 처리
				if(is_array($CDATA)) {
					foreach($CDATA as $CROW) if(!in_array($CROW['object'],$FIELD)) $delRecord[] = $CROW['no'];
					if(is_array($delRecord)) $db->_query("delete from `".$description_control->description_table."` where `no` in(".join(',',$delRecord).")");
				}

?>
				<div id="pop_db" class="bocol lnb_col" style="top:10%;left:33%;display:;">
					<dl class="ntlt lnb_col m0 hand" id="dbHandle">
						<img src="../../images/comn/bul_10.png" class="t">Table : <?php echo $table;?>
						<a onClick="MM_showHideLayers('pop_db','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  
					<table width="980" class="bg_col tf" border="0">
					<col><col width=150><col width=30><col width=26><col width=100><col width=120><col>
					<tbody>
					<tr align=center bgcolor="#EDEDED">
						<td>Column Name</td>
						<td>Data Type</td>
						<td style='font-size:7pt;'>NOT<br />NULL</td>
						<td style='font-size:6pt;'>AUTO<br />INC</td>
						<td>Flags</td>
						<td>Default Value</td>
						<td>Comment</td>
					</tr>
					<?php echo $tableList;?>
					</tbody>
					</table>

				</div>
<?php

			break;

			## 코멘트 수정
			case 'comment_update':
			
?>
				<div id="pop_comment" class="bocol lnb_col" style="top:10%;left:33%;display:;">
					<dl class="ntlt lnb_col m0 hand" id="commentHandle">
						<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><img src="<?php echo $images_path;?>/description_img/icon_table.gif" align="absmiddle" title="TABLE명" alt="TABLE명"></td>
							<td nowrap style="overflow-x:hidden"><span id="destination" style="padding:2 2 0 2px;background-color:#DEDEDE;color:#333399;border:silver 1 dotted;line-height:150%"><?php echo $table;?></span><font color="gray">'s Description</font></td>
						</tr>
						</table>
						<a onClick="MM_showHideLayers('pop_comment','','hide')"><img src="../../images/comn/pclose.png" class="lclose ln_col"></a>
					</dl>  
					<form name="descFrm" method="POST" action="./process/description.php" id="descFrm">
					<input type="hidden" name="ajax" value="1">
					<input type="hidden" name="mode" value="db_comment">
					<input type="hidden" name="ftable" id="ftable">
					<input type="hidden" name="fobject" id="fobject">

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