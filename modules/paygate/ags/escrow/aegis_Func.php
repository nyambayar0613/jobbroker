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
						alert( $Limit_StartTime[$Index].'�ú��� '.$Limit_EndTime[$Index].'�ñ����� ������ �Ͻ� �� �����ϴ�.' );
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
	Aegis ī�嵥���� Encrypt
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
	���ڿ� ����
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
	
	// �Է��ڷᰡ ���̺��� �� ��� �ڸ��� �ѱ�ó��
	
	if ( strlen($TSTR) > $TLEN ) 
	{
		// $flag == 1 �̸� �� ����Ʈ�� �ѱ��� ���� ����Ʈ �̶� �ű���� �ڸ��� �Ǹ� 
		// �ѱ��� ������ �Ǵ� ������ �߻��մϴ�. 
		
		$flag = 0;
		
		for($i=0 ; $i< $TLEN ; $i++) 
		{ 
			$j = ord($TSTR[$i]); // ������ ASCII ���� ���մϴ�. 
			                     // ���� ASCII���� 127���� ũ�� �� ����Ʈ�� �ѱ��� ���۹���Ʈ�̰ų� ������Ʈ(?)��� ������. 
			if($j > 127) 
			{ 
				if( $flag ) $flag = 0; // $flag ���� �����Ѵٴ� ���� �̹� ���ڴ� �ѱ��� ������Ʈ�̱� ������ 
				                       // $flag �� 0���� ���ݴϴ�. 
				else $flag = 1;        // ���� �������� ������ �ѱ��� ���۹���Ʈ����. �׷��Ƿ� $flag �� 1! 
			}
			else $flag = 0; // �ٸ� ���ڳ� �����϶��� �׳� �Ѿ�� �ǰ���. 
		} 
		if( $flag ) 
		{
			// �̷��� �ؼ� ������ ���ڱ����� $flag�� ����ؼ� $flag�� �����ϸ� 
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
			// �ѹ���Ʈ�� ���ؼ� �ڸ����� ���� �ڸ����� �ؾ߰���. 
			$TSTR = substr($TSTR, 0, $TLEN); // �ƴ� ����.... 
		}
		
		return $TSTR; // ���� ������ ��Ʈ���� ��ȯ�մϴ�.   
		
		// �Է��ڷᰡ ���̺��� ���� ��� SPACE�� ä���
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
		
		// �Է��ڷᰡ ���̿� �������
	} 
	else if ( strlen($TSTR) == $TLEN ) 
	{
		return ($TSTR);  
	}
}

/* 
	�Է��� ���ڰ� ���ھƽ�Ű���� �ش��ϴ��� �Ǵ�.
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
	��� �޼���
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