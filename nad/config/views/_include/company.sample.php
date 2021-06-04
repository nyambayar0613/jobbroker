<?php
$width = 370;
$test_maps = array("'37.538779843072824','127.00200500605618'", "'37.538635699652154','127.00030778301571'", "'37.537338259427315','126.9998325645435'", "'37.53377026138633','127.00288736856231'", "'37.534941239454476','127.00920075758009'");

?>
<div class="pop_b1">
    <div>
        <table border="0" cellspacing="0" cellpadding="0" width="<?php echo $width;?>">
            <tr><td class="tit"><span>Компанийн мэдээллийн жишээ.</span></td></tr>
        </table>
    </div>
    <div class="pop_b2">
        <table border="0" cellspacing="0" cellpadding="0" width="<?php echo $width;?>" align="center">
            <tr>
                <td valign="middle" width="120">
                    <div class="mb10"><a href="#" target="_blank"><?php echo $file_image;?></a></div>
                    <div class="ta_center">
                        <a onClick="map_api.map_location_move(<?php echo $test_maps[$no];?>,13)" class="point_check"><!-- <img src="images/btn_map_location.gif" alt="위치로이동" class="mr3"/></a><a href="#" target="_blank"><img src="images/btn_view_detail3.gif" alt="자세히보기" /> --></a>
                    </div>
                </td>
                <td valign="top">
                    <table border="0" cellspacing="0" cellpadding="0" width="96%" align="center" class="sbox_tbl">
                        <tr>
                            <th width="22%">Төлөөлөгчийн нэр</th>
                            <td style="font-weight:normal;">Төлөөлөгчийн нэр жишээ</td>
                        </tr>
                        <tr><td colspan="2" height="1" bgcolor="#f4f4f4"></td></tr>
                        <tr>
                            <th>Компаний хаяг</th>
                            <td style="font-weight:normal;">Компаний хаяг</td>
                        </tr>
                        <tr><td colspan="2" height="1" bgcolor="#f4f4f4"></td></tr>
                        <tr>
                            <th>Салбарууд</th>
                            <td style="font-weight:normal;">Жишээ салбарууд</td>
                        </tr>
                        <tr><td colspan="2" height="1" bgcolor="#f4f4f4"></td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>