<?php
$_POST['no'] = $pno;

// : �������� �ҷ�����
$pay_row = sql_fetch("select * from alice_payment where `no`='".addslashes($pno)."'");
$_post_un = unserialize(stripslashes($pay_row['post_un']));
$_pg_un = unserialize(stripslashes($pay_row['pg_un']));

// : ����üũ
$get_price = $netfu_payment->get_service_type($_post_un);

    /* ============================================================================== */
    /* =   PAGE : ���� ��û �� ��� ó�� PAGE                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
    /* =   ���� �ּ� : http://kcp.co.kr/technique.requestcode.do                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   ȯ�� ���� ���� Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ�                                                                  = */
    /* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php������ �����Ͻñ� �ٶ��ϴ�.     = */
    /* = -------------------------------------------------------------------------- = */

    include NFE_PATH."/plugin/PG/kcp/cfg/site_conf_inc.php";       // ȯ�漳�� ���� include
    require NFE_PATH."/plugin/PG/kcp/mobile_sample/pp_cli_hub_lib.php";              // library [�����Ұ�]

    /* = -------------------------------------------------------------------------- = */
    /* =   ȯ�� ���� ���� Include END                                               = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   POST ���� üũ�κ�                                                       = */
    /* = -------------------------------------------------------------------------- = */
    if ( $_SERVER['REQUEST_METHOD'] != "POST" )
    {
        echo("�߸��� ��η� �����Ͽ����ϴ�.");
        exit;
    }
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   01. ���� ��û ���� ����                                                  = */
    /* = -------------------------------------------------------------------------- = */
    $req_tx         = $_POST[ "req_tx"         ]; // ��û ����
    $tran_cd        = $_POST[ "tran_cd"        ]; // ó�� ����
    /* = -------------------------------------------------------------------------- = */
    $cust_ip        = getenv( "REMOTE_ADDR"    ); // ��û IP
    $ordr_idxx      = $_POST[ "ordr_idxx"      ]; // ���θ� �ֹ���ȣ
    $good_name      = $_POST[ "good_name"      ]; // ��ǰ��
    /* = -------------------------------------------------------------------------- = */
    $res_cd         = "";                         // �����ڵ�
    $res_msg        = "";                         // ����޽���
    $tno            = $_POST[ "tno"            ]; // KCP �ŷ� ���� ��ȣ
    /* = -------------------------------------------------------------------------- = */
    $buyr_name      = $_POST[ "buyr_name"      ]; // �ֹ��ڸ�
    $buyr_tel1      = $_POST[ "buyr_tel1"      ]; // �ֹ��� ��ȭ��ȣ
    $buyr_tel2      = $_POST[ "buyr_tel2"      ]; // �ֹ��� �ڵ��� ��ȣ
    $buyr_mail      = $_POST[ "buyr_mail"      ]; // �ֹ��� E-mail �ּ�
    /* = -------------------------------------------------------------------------- = */
    $use_pay_method = $_POST[ "use_pay_method" ]; // ���� ���
    $bSucc          = "";                         // ��ü DB ó�� ���� ����
    /* = -------------------------------------------------------------------------- = */
    $app_time       = "";                         // ���νð� (��� ���� ���� ����)
    $amount         = "";                         // KCP ���� �ŷ� �ݾ�
    /* = -------------------------------------------------------------------------- = */
    $card_cd        = "";                         // �ſ�ī�� �ڵ�
    $card_name      = "";                         // �ſ�ī�� ��
    $app_no         = "";                         // �ſ�ī�� ���ι�ȣ
    $noinf          = "";                         // �ſ�ī�� ������ ����
    $quota          = "";                         // �ſ�ī�� �Һΰ���
    $partcanc_yn    = "";                         // �κ���� ��������
    $card_bin_type_01 = "";                       // ī�屸��1
    $card_bin_type_02 = "";                       // ī�屸��2
    /* = -------------------------------------------------------------------------- = */
    $bank_name      = "";                         // �����
    $bank_code      = "";                         // �����ڵ�
    /* = -------------------------------------------------------------------------- = */
    $bankname       = "";                         // �Ա��� �����
    $depositor      = "";                         // �Ա��� ���� ������ ����
    $account        = "";                         // �Ա��� ���� ��ȣ
    $va_date        = "";                         // ������� �Աݸ����ð�
    /* = -------------------------------------------------------------------------- = */
    $pnt_issue      = "";                         // ���� ����Ʈ�� �ڵ�
    $pnt_amount     = "";                         // �����ݾ� or ���ݾ�
    $pnt_app_time   = "";                         // ���νð�
    $pnt_app_no     = "";                         // ���ι�ȣ
    $add_pnt        = "";                         // �߻� ����Ʈ
    $use_pnt        = "";                         // ��밡�� ����Ʈ
    $rsv_pnt        = "";                         // ���� ����Ʈ
    /* = -------------------------------------------------------------------------- = */
    $commid         = "";                         // ��Ż� �ڵ�
    $mobile_no      = "";                         // �޴��� ��ȣ
    /* = -------------------------------------------------------------------------- = */
    $tk_van_code    = "";                         // �߱޻� �ڵ�
    $tk_app_no      = "";                         // ��ǰ�� ���� ��ȣ
    /* = -------------------------------------------------------------------------- = */
    $cash_yn        = $_POST[ "cash_yn"        ]; // ���ݿ����� ��� ����
    $cash_authno    = "";                         // ���� ������ ���� ��ȣ
    $cash_tr_code   = $_POST[ "cash_tr_code"   ]; // ���� ������ ���� ����
    $cash_id_info   = $_POST[ "cash_id_info"   ]; // ���� ������ ��� ��ȣ
    $cash_no        = "";                         // ���� ������ �ŷ� ��ȣ      

    $param_opt_1    = $_POST[ "param_opt_1" ];
    $param_opt_2    = $_POST[ "param_opt_2" ];
    $param_opt_3    = $_POST[ "param_opt_3" ];

    /* ============================================================================== */
    /* =   01. ���� ��û ���� ���� END                                              = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. �ν��Ͻ� ���� �� �ʱ�ȭ                                              = */
    /* = -------------------------------------------------------------------------- = */
    /* =       ������ �ʿ��� �ν��Ͻ��� �����ϰ� �ʱ�ȭ �մϴ�.                     = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus = new C_PP_CLI;

    $c_PayPlus->mf_clear();
    /* ------------------------------------------------------------------------------ */
    /* =   02. �ν��Ͻ� ���� �� �ʱ�ȭ END                                          = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03. ó�� ��û ���� ����                                                  = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. ���� ��û                                                          = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
            /* 1 ���� ������ ��ü���� �����ϼž� �� �� �ݾ��� �־��ּž� �մϴ�. �����ݾ� ��ȿ�� ���� */
            $c_PayPlus->mf_set_ordr_data( "ordr_mony",  $get_price['use_price_hap'] );                                    

            $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ], $_POST[ "enc_info" ] );
    }
    /* ------------------------------------------------------------------------------ */
    /* =   03.  ó�� ��û ���� ���� END                                             = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. ����                                                                 = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tran_cd != "" )
    {
        $c_PayPlus->mf_do_tx( "", $g_conf_home_dir, $g_conf_site_cd, $g_conf_site_key, $tran_cd, "",
                              $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                              $cust_ip, $g_conf_log_level, 0, 0, $g_conf_log_path ); // ���� ���� ó��

        $res_cd  = $c_PayPlus->m_res_cd;  // ��� �ڵ�
        $res_msg = $c_PayPlus->m_res_msg; // ��� �޽���
    }
    else
    {
        $c_PayPlus->m_res_cd  = "9562";
        $c_PayPlus->m_res_msg = "���� ����|tran_cd���� �������� �ʾҽ��ϴ�.";
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   04. ���� END                                                             = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   05. ���� ��� �� ����                                                    = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            $tno       = $c_PayPlus->mf_get_res_data( "tno"       ); // KCP �ŷ� ���� ��ȣ
            $amount    = $c_PayPlus->mf_get_res_data( "amount"    ); // KCP ���� �ŷ� �ݾ�
            $app_time  = $c_PayPlus->mf_get_res_data( "app_time"  ); // ���νð�
            $pnt_issue = $c_PayPlus->mf_get_res_data( "pnt_issue" ); // ���� ����Ʈ�� �ڵ�

    /* = -------------------------------------------------------------------------- = */
    /* =   05-1. �ſ�ī�� ���� ��� ó��                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "100000000000" )
            {
                $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   ); // ī��� �ڵ�
                $card_name = $c_PayPlus->mf_get_res_data( "card_name" ); // ī�� ����
                $app_no    = $c_PayPlus->mf_get_res_data( "app_no"    ); // ���� ��ȣ
                $noinf     = $c_PayPlus->mf_get_res_data( "noinf"     ); // ������ ���� ( 'Y' : ������ )
                $quota     = $c_PayPlus->mf_get_res_data( "quota"     ); // �Һ� ���� ��
                $partcanc_yn = $c_PayPlus->mf_get_res_data( "partcanc_yn" ); // �κ���� ��������
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-2. ������ü ���� ��� ó��                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "010000000000" )
            {
                $bank_name = $c_PayPlus->mf_get_res_data( "bank_name"  ); // �����
                $bank_code = $c_PayPlus->mf_get_res_data( "bank_code"  ); // �����ڵ�
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-3. ������� ���� ��� ó��                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "001000000000" )
            {
                $bankname  = $c_PayPlus->mf_get_res_data( "bankname"  ); // �Ա��� ���� �̸�
                $depositor = $c_PayPlus->mf_get_res_data( "depositor" ); // �Ա��� ���� ������
                $account   = $c_PayPlus->mf_get_res_data( "account"   ); // �Ա��� ���� ��ȣ
                $va_date   = $c_PayPlus->mf_get_res_data( "va_date"   ); // ������� �Աݸ����ð�
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-4. ����Ʈ ���� ��� ó��                                               = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000100000000" )
            {
                $pnt_amount   = $c_PayPlus->mf_get_res_data( "pnt_amount"   ); // �����ݾ� or ���ݾ�
                $pnt_app_time = $c_PayPlus->mf_get_res_data( "pnt_app_time" ); // ���νð�
                $pnt_app_no   = $c_PayPlus->mf_get_res_data( "pnt_app_no"   ); // ���ι�ȣ 
                $add_pnt      = $c_PayPlus->mf_get_res_data( "add_pnt"      ); // �߻� ����Ʈ
                $use_pnt      = $c_PayPlus->mf_get_res_data( "use_pnt"      ); // ��밡�� ����Ʈ
                $rsv_pnt      = $c_PayPlus->mf_get_res_data( "rsv_pnt"      ); // ���� ����Ʈ
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-5. �޴��� ���� ��� ó��                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000010000000" )
            {
                $app_time  = $c_PayPlus->mf_get_res_data( "hp_app_time"  ); // ���� �ð�
                $commid    = $c_PayPlus->mf_get_res_data( "commid"	     ); // ��Ż� �ڵ�
                $mobile_no = $c_PayPlus->mf_get_res_data( "mobile_no"	 ); // �޴��� ��ȣ

            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-6. ��ǰ�� ���� ��� ó��                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000001000" )
            {
                $app_time    = $c_PayPlus->mf_get_res_data( "tk_app_time"  ); // ���� �ð�
                $tk_van_code = $c_PayPlus->mf_get_res_data( "tk_van_code"  ); // �߱޻� �ڵ�
                $tk_app_no   = $c_PayPlus->mf_get_res_data( "tk_app_no"    ); // ���� ��ȣ
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-7. ���ݿ����� ��� ó��                                               = */
    /* = -------------------------------------------------------------------------- = */
            $cash_authno  = $c_PayPlus->mf_get_res_data( "cash_authno"  ); // ���� ������ ���� ��ȣ
            $cash_no      = $c_PayPlus->mf_get_res_data( "cash_no"      ); // ���� ������ �ŷ� ��ȣ
        }
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   05. ���� ��� ó�� END                                                   = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   06. ���� �� ���� ��� DBó��                                             = */
    /* = -------------------------------------------------------------------------- = */
    /* =       ����� ��ü ��ü������ DBó�� �۾��Ͻô� �κ��Դϴ�.                 = */
    /* = -------------------------------------------------------------------------- = */

    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            // 06-1-1. �ſ�ī��
            if ( $use_pay_method == "100000000000" )
            {
            }
            // 06-1-2. ������ü
            if ( $use_pay_method == "010000000000" )
            {
            }
            // 06-1-3. �������
            if ( $use_pay_method == "001000000000" )
            {
            }
            // 06-1-4. ����Ʈ
            if ( $use_pay_method == "000100000000" )
            {
            }
            // 06-1-5. �޴���
            if ( $use_pay_method == "000010000000" )
            {
            }
            // 06-1-6. ��ǰ��
             if ( $use_pay_method == "000000001000" )
            {
            }

			$result = $payment_control->payment_status($c_PayPlus);
			$_pay_result = true;
        }

    /* = -------------------------------------------------------------------------- = */
    /* =   06. ���� �� ���� ��� DBó��                                             = */
    /* ============================================================================== */
        else if ( $res_cd != "0000" )
        {
			$update = sql_query("update alice_payment set `pg_un`='".addslashes(serialize($c_PayPlus))."' where `no`='".addslashes($pno)."'");
        }
    }


    /* ============================================================================== */
    /* =   07. ���� ��� DBó�� ���н� : �ڵ����                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =         ���� ����� DB �۾� �ϴ� �������� ���������� ���ε� �ǿ� ����      = */
    /* =         DB �۾��� �����Ͽ� DB update �� �Ϸ���� ���� ���, �ڵ�����       = */
    /* =         ���� ��� ��û�� �ϴ� ���μ����� �����Ǿ� �ֽ��ϴ�.                = */
    /* =                                                                            = */
    /* =         DB �۾��� ���� �� ���, bSucc ��� ����(String)�� ���� "false"     = */
    /* =         �� ������ �ֽñ� �ٶ��ϴ�. (DB �۾� ������ ��쿡�� "false" �̿��� = */
    /* =         ���� �����Ͻø� �˴ϴ�.)                                           = */
    /* = -------------------------------------------------------------------------- = */
    
    $bSucc = ""; // DB �۾� ���� �Ǵ� �ݾ� ����ġ�� ��� "false" �� ����

    /* = -------------------------------------------------------------------------- = */
    /* =   07-1. DB �۾� ������ ��� �ڵ� ���� ���                                 = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            if ( $bSucc == "false" )
            {
                $c_PayPlus->mf_clear();

                $tran_cd = "00200000";

                $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP ���ŷ� �ŷ���ȣ
                $c_PayPlus->mf_set_modx_data( "mod_type", "STSC"                       );  // ���ŷ� ���� ��û ����
                $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // ���� ��û�� IP
                $c_PayPlus->mf_set_modx_data( "mod_desc", "��� ó�� ���� - �ڵ� ���" );  // ���� ����

                $c_PayPlus->mf_do_tx( "", $g_conf_home_dir, $g_conf_site_cd, $g_conf_site_key, $tran_cd, "",
                              $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                              $cust_ip, $g_conf_log_level, 0, 0, $g_conf_log_path ); // ���� ���� ó��

                $res_cd  = $c_PayPlus->m_res_cd;
                $res_msg = $c_PayPlus->m_res_msg;
            }
        }
    } // End of [res_cd = "0000"]
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   08. �� ���� �� ��������� ȣ��                                           = */
    /* ============================================================================== */
?>
    <html>
    <head>
        <title>����Ʈ�� �� ����â</title>
        <script type="text/javascript">
            function goResult()
            {
                document.pay_info.submit()
            }

            // ���� �� ���ΰ�ħ ���� ���� ��ũ��Ʈ (�ߺ����� ����)
            function noRefresh()
            {
                /* CTRL + NŰ ����. */
                if ((event.keyCode == 78) && (event.ctrlKey == true))
                {
                    event.keyCode = 0;
                    return false;
                }
                /* F5 ��Ű ����. */
                if(event.keyCode == 116)
                {
                    event.keyCode = 0;
                    return false;
                }
            }
            document.onkeydown = noRefresh ;
        </script>
    </head>

    <body onload="goResult()">
    <form name="pay_info" method="post" action="./result.php">
        <input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd   ?>">    <!-- ����Ʈ �ڵ� -->
        <input type="hidden" name="req_tx"          value="<?=$req_tx           ?>">    <!-- ��û ���� -->
        <input type="hidden" name="use_pay_method"  value="<?=$use_pay_method   ?>">    <!-- ����� ���� ���� -->
        <input type="hidden" name="bSucc"           value="<?=$bSucc            ?>">    <!-- ���θ� DB ó�� ���� ���� -->

        <input type="hidden" name="res_cd"          value="<?=$res_cd           ?>">    <!-- ��� �ڵ� -->
        <input type="hidden" name="res_msg"         value="<?=$res_msg          ?>">    <!-- ��� �޼��� -->
        <input type="hidden" name="escw_yn"         value="<?=$escw_yn          ?>">    <!-- ����ũ�� ���� -->
        <input type="hidden" name="ordr_idxx"       value="<?=$ordr_idxx        ?>">    <!-- �ֹ���ȣ -->
        <input type="hidden" name="tno"             value="<?=$tno              ?>">    <!-- KCP �ŷ���ȣ -->
        <input type="hidden" name="good_name"       value="<?=$good_name        ?>">    <!-- ��ǰ�� -->
        <input type="hidden" name="buyr_name"       value="<?=$buyr_name        ?>">    <!-- �ֹ��ڸ� -->
        <input type="hidden" name="buyr_tel1"       value="<?=$buyr_tel1        ?>">    <!-- �ֹ��� ��ȭ��ȣ -->
        <input type="hidden" name="buyr_tel2"       value="<?=$buyr_tel2        ?>">    <!-- �ֹ��� �޴�����ȣ -->
        <input type="hidden" name="buyr_mail"       value="<?=$buyr_mail        ?>">    <!-- �ֹ��� E-mail -->
        <input type="hidden" name="app_time"        value="<?=$app_time         ?>">    <!-- ���νð� -->
        <input type="hidden" name="amount"          value="<?=$amount           ?>">    <!-- KCP ���� �ŷ� �ݾ� -->
        
        <!-- �ſ�ī�� ���� -->
        <input type="hidden" name="card_cd"         value="<?=$card_cd          ?>">    <!-- ī���ڵ� -->
        <input type="hidden" name="card_name"       value="<?=$card_name        ?>">    <!-- ī���̸� -->
        <input type="hidden" name="app_no"          value="<?=$app_no           ?>">    <!-- ���ι�ȣ -->
        <input type="hidden" name="noinf"           value="<?=$noinf            ?>">    <!-- �����ڿ��� -->
        <input type="hidden" name="quota"           value="<?=$quota            ?>">    <!-- �Һΰ��� -->
        <input type="hidden" name="partcanc_yn"     value="<?=$partcanc_yn      ?>">    <!-- �κ���Ұ������� -->
        <input type="hidden" name="card_bin_type_01"value="<?=$card_bin_type_01 ?>">    <!-- ī�屸��1 -->
        <input type="hidden" name="card_bin_type_02"value="<?=$card_bin_type_02 ?>">    <!-- ī�屸��2 -->
        <!-- ������ü ���� -->
        <input type="hidden" name="bank_name"       value="<?=$bank_name        ?>">    <!-- ����� -->
        <input type="hidden" name="bank_code"       value="<?=$bank_code        ?>">    <!-- �����ڵ� -->
        <!-- ������� ���� -->
        <input type="hidden" name="bankname"        value="<?=$bankname         ?>">    <!-- �Ա� ���� -->
        <input type="hidden" name="depositor"       value="<?=$depositor        ?>">    <!-- �Աݰ��� ������ -->
        <input type="hidden" name="account"         value="<?=$account          ?>">    <!-- �Աݰ��� ��ȣ -->
        <input type="hidden" name="va_date"         value="<?=$va_date          ?>">    <!-- ������� �Աݸ����ð� -->
        <!-- ����Ʈ ���� -->
        <input type="hidden" name="pnt_issue"       value="<?=$pnt_issue        ?>">    <!-- ����Ʈ ���񽺻� -->
        <input type="hidden" name="pnt_app_time"    value="<?=$pnt_app_time     ?>">    <!-- ���νð� -->
        <input type="hidden" name="pnt_app_no"      value="<?=$pnt_app_no       ?>">    <!-- ���ι�ȣ -->
        <input type="hidden" name="pnt_amount"      value="<?=$pnt_amount       ?>">    <!-- �����ݾ� or ���ݾ� -->
        <input type="hidden" name="add_pnt"         value="<?=$add_pnt          ?>">    <!-- �߻� ����Ʈ -->
        <input type="hidden" name="use_pnt"         value="<?=$use_pnt          ?>">    <!-- ��밡�� ����Ʈ -->
        <input type="hidden" name="rsv_pnt"         value="<?=$rsv_pnt          ?>">    <!-- �� ���� ����Ʈ -->
        <!-- �޴��� ���� -->
        <input type="hidden" name="commid"          value="<?=$commid           ?>">    <!-- ��Ż� �ڵ� -->
        <input type="hidden" name="mobile_no"       value="<?=$mobile_no        ?>">    <!-- �޴��� ��ȣ -->

        <!-- ��ǰ�� ���� -->
        <input type="hidden" name="tk_van_code"     value="<?=$tk_van_code      ?>">    <!-- �߱޻� �ڵ� -->
        <input type="hidden" name="tk_app_no"       value="<?=$tk_app_no        ?>">    <!-- ���� ��ȣ -->
        <!-- ���ݿ����� ���� -->
        <input type="hidden" name="cash_yn"         value="<?=$cash_yn          ?>">    <!-- ���ݿ����� ��� ���� -->
        <input type="hidden" name="cash_authno"     value="<?=$cash_authno      ?>">    <!-- ���� ������ ���� ��ȣ -->
        <input type="hidden" name="cash_tr_code"    value="<?=$cash_tr_code     ?>">    <!-- ���� ������ ���� ���� -->
        <input type="hidden" name="cash_id_info"    value="<?=$cash_id_info     ?>">    <!-- ���� ������ ��� ��ȣ -->
        <input type="hidden" name="cash_no"         value="<?=$cash_no          ?>">    <!-- ���� ������ �ŷ� ��ȣ -->
        
        <input type="hidden" name="param_opt_1"     value="<?=$param_opt_1 ?>">
        <input type="hidden" name="param_opt_2"     value="<?=$param_opt_2 ?>">
        <input type="hidden" name="param_opt_3"     value="<?=$param_opt_3 ?>">
    </form>
    </body>
    </html>
