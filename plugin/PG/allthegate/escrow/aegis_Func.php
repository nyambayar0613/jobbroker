<?

/*
$Limit_DealStore = array( "cyberp", "silveron", "virtual", "tandca" );
$Limit_StartTime = array( "19", "19", "19", "19" );
$Limit_EndTime   = array( "09", "09", "09", "09" );

function Limit_DealTime( $Limit_DealStore, $StoreId, $Limit_StartTime, $Limit_EndTime )
{
	foreach( $Limit_DealStore as $Index => $Value )
	{
		if( strcmp( $Value, $StoreId ) == 0 ) 
		{
			$CurrTime = date( "H" );
			if( $CurrTime >= $Limit_StartTime[$Index] || $CurrTime < $Limit_EndTime[$Index] )
			{
				print "
						<script language='javascript'>
						alert( $Limit_StartTime[$Index].'시부터 '.$Limit_EndTime[$Index].'시까지는 결제를 하실 수 없습니다.' );
						this.close();
						</script>
					";
			}
			return;
		}
	}
}
*/

/*
	Aegis 카드데이터 Encrypt
*/

function encrypt_aegis( $OrgData )
{
	if( empty( $OrgData ) || $OrgData == "" ) 
	{
		return "";
	}
	
	$temp = "";
	for( $i = 0; $i < strlen( $OrgData ); $i++ )
	{
		$temp .= substr( $OrgData, (strlen( $OrgData ) - 1) - $i, 1 );
	}

	//print "Reverse data : ".$temp."<br>";

	$one_char = "";
	$EncData  = "";
	for( $i = 0; $i < strlen( $temp ); $i++ )
	{
		$one_char = substr( $temp, $i, 1 );
		$EncData  .= ($one_char + $i * 77) % 10 ;
	}

	//print "Enc Data : ".$EncData."<br>";

	return $EncData;
}

/*
	문자열 포멧
*/
function format_string($TSTR,$TLEN,$TAG)
{
	if ( !isset($TSTR) ) 
	{
		for ( $i=0 ; $i < $TLEN ; $i++ ) 
		{
			if( $TAG == 'Y' ) 
			{
				$TSTR = $TSTR.chr(32);
			} 
			else 
			{
				$TSTR = $TSTR.'+';
			}
		}
	}
	
	$TSTR = trim($TSTR);
	
	$TSTR = stripslashes($TSTR); 
	
	// 입력자료가 길이보다 긴 경우 자르고 한글처리
	
	if ( strlen($TSTR) > $TLEN ) 
	{
		// $flag == 1 이면 그 바이트는 한글의 시작 바이트 이라서 거기까지 자르게 되면 
		// 한글이 깨지게 되는 현상이 발생합니다. 
		
		$flag = 0;
		
		for($i=0 ; $i< $TLEN ; $i++) 
		{ 
			$j = ord($TSTR[$i]); // 문자의 ASCII 값을 구합니다. 
			                     // 구한 ASCII값이 127보다 크면 그 바이트가 한글의 시작바이트이거나 끝바이트(?)라는 뜻이죠. 
			if($j > 127) 
			{ 
				if( $flag ) $flag = 0; // $flag 값이 존재한다는 것은 이번 문자는 한글의 끝바이트이기 때문에 
				                       // $flag 를 0으로 해줍니다. 
				else $flag = 1;        // 값이 존재하지 않으면 한글의 시작바이트이죠. 그러므로 $flag 는 1! 
			}
			else $flag = 0; // 다른 숫자나 영문일때는 그냥 넘어가면 되겠죠. 
		} 
		if( $flag ) 
		{
			// 이렇게 해서 마지막 문자까지의 $flag를 계산해서 $flag가 존재하면 
			$TSTR = substr($TSTR, 0, $TLEN - 1);
			if( $TAG == 'Y' ) 
			{
				$TSTR = $TSTR.chr(32);
			}
			else 
			{
				$TSTR = $TSTR.'+';
			}
		} 
		else 
		{
			// 한바이트를 더해서 자르던지 빼서 자르던지 해야겠죠. 
			$TSTR = substr($TSTR, 0, $TLEN); // 아님 말구.... 
		}
		
		return $TSTR; // 이제 결정된 스트링을 반환합니다.   
		
		// 입력자료가 길이보다 작은 경우 SPACE로 채운다
	} 
	else if ( strlen($TSTR) < $TLEN ) 
	{ 
		$TLENGTH = strlen($TSTR);
		for ( $i=0 ; $i < $TLEN - $TLENGTH; $i++ ) 
		{
			if( $TAG == 'Y' ) 
			{
				$TSTR = $TSTR.chr(32);
			} 
			else 
			{
				$TSTR = $TSTR.'+';
			}
		}
		
		return ($TSTR);
		
		// 입력자료가 길이와 같은경우
	} 
	else if ( strlen($TSTR) == $TLEN ) 
	{
		return ($TSTR);  
	}
}

/* 
	입력한 글자가 숫자아스키값에 해당하는지 판단.
*/
function IsNumber($word)
{
	
	for($i = 0; $i < strlen($word); $i++)
	{
		$wordNum = ord( substr( $word, $i, 1 ) );

		if( $wordNum < 48 || $wordNum > 57 ) 
		{
			return false;
		}

	}

	return true;
}
/* 
	경고 메세지
*/
function AlertMsg( $msg , $go=0)
{

	$msg = str_replace( "\"" ,"'" ,$msg );
	$msg = str_replace( "\n" ,"\\n" ,$msg );
	print "<script language='javascript'>";
	print "alert( '".$msg."' );";
	if( $go < 0 )
		print "history.go( ".$go." );";
	print "</script>";

}
function HistoryGo( $go )
{
	print "<script language='javascript'>";
	print "history.go( ".$go." );";
	print "</script>";
}

function AlertExit( $msg )
{

	AlertMsg( $msg );
	exit;

}

function AlertGoBack( $msg )
{
	
	AlertMsg( $msg, -1);
	exit;
}

?>