<?
  /* ============================================================================== */
  /* =   PAGE : ���̺���� PAGE                                                   = */
  /* = -------------------------------------------------------------------------- = */
  /* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
  /* ============================================================================== */

  /* ============================================================================== */
  /* =   ���� ���� CLASS                                                          = */
  /* ============================================================================== */
  class   C_PP_CLI
  {
    var   $m_payx_common;
    var   $m_payx_card;
    var   $m_ordr_data;
    var   $m_rcvr_data;
    var   $m_escw_data;
    var   $m_modx_data;
    var   $m_encx_data;
    var   $m_encx_info;

    /* -------------------------------------------------------------------- */
    /* -   ó�� ��� ��                                                   - */
    /* -------------------------------------------------------------------- */
    var   $m_res_data;
    var   $m_res_cd;
    var   $m_res_msg;

    /* -------------------------------------------------------------------- */
    /* -   ������                                                         - */
    /* -------------------------------------------------------------------- */
    function  C_PP_CLI()
    {
      $this->m_payx_common = "";
      $this->m_payx_card   = "";
      $this->m_ordr_data   = "";
      $this->m_rcvr_data   = "";
      $this->m_escw_data   = "";
      $this->m_modx_data   = "";
      $this->m_encx_data   = "";
      $this->m_encx_info   = "";
    }

    function  mf_init( $mode )
    {
      if ( $mode == "1" )
      {
        if ( !extension_loaded( 'pp_cli_dl_php' ) )
        {
          dl( "pp_cli_dl_php.so" );
        }
      }
    }

    function  mf_clear()
    {
      $this->m_payx_common = "";
      $this->m_payx_card   = "";
      $this->m_ordr_data   = "";
      $this->m_rcvr_data   = "";
      $this->m_escw_data   = "";
      $this->m_modx_data   = "";
      $this->m_encx_data   = "";
      $this->m_encx_info   = "";
    }

    function  mf_gen_trace_no( $site_cd, $ip, $mode )
    {
      if ( $mode == "1" )
      {
        $trace_no = lfPP_CLI_DL__gen_trace_no( $site_cd, $ip );
      }
      else
      {
        $trace_no = "";
      }

      return  $trace_no;
    }

    /* -------------------------------------------------------------------- */
    /* -   FUNC  :  ENC DATA ���� ���� �Լ�                               - */
    /* -------------------------------------------------------------------- */
    function  mf_set_payx_common_data( $name, $val )
    {
      if ( $val != "" )
      {
        $this->m_payx_common .= ( $name . '=' . $val . chr( 31 ) );
      }
    }

    function  mf_set_payx_card_data( $name, $val )
    {
      if ( $val != "" )
      {
        $this->m_payx_card .= ( $name . '=' . $val . chr( 31 ) );
      }
    }

    function  mf_set_ordr_data( $name, $val )
    {
      if ( $val != "" )
      {
        $this->m_ordr_data .= ( $name . '=' . $val . chr( 31 ) );
      }
    }

    function  mf_set_rcvr_data( $name, $val )
    {
      if ( $val != "" )
      {
        $this->m_rcvr_data .= ( $name . '=' . $val . chr( 31 ) );
      }
    }

    function  mf_set_escw_data( $name, $val )
    {
      if ( $val != "" )
      {
        $this->m_escw_data .= ( $name . '=' . $val . chr( 29 ) );
      }
    }

    function  mf_set_modx_data( $name, $val )
    {
      if ( $val != "" )
      {
        $this->m_modx_data .= ( $name . '=' . $val . chr( 31 ) );
      }
    }

    function  mf_set_encx_data( $encx_data, $encx_info )
    {
      $this->m_encx_data = $encx_data;
      $this->m_encx_info = $encx_info;
    }

    /* -------------------------------------------------------------------- */
    /* -   FUNC  :  ���� ó�� �Լ�                                        - */
    /* -------------------------------------------------------------------- */
    function  mf_do_tx( $trace_no,  $home_dir, $site_cd,
                        $site_key,  $tx_cd,    $pub_key_str,
                        $pa_url,    $pa_port,  $user_agent,
                        $ordr_idxx, $cust_ip,
                        $log_level, $opt, $mode, $g_conf_log_path)
    {
      $payx_data = $this->mf_get_payx_data();

      $ordr_data = $this->mf_get_data( "ordr_data", $this->m_ordr_data );
      $rcvr_data = $this->mf_get_data( "rcvr_data", $this->m_rcvr_data );
      $escw_data = $this->mf_get_data( "escw_data", $this->m_escw_data );
      $modx_data = $this->mf_get_data( "mod_data",  $this->m_modx_data );

      if ( $mode == "1" )
      {
        $res_data = lfPP_CLI_DL__do_tx_2( $trace_no, $home_dir, $site_cd,
                                          $site_key, $tx_cd,    $pub_key_str,
                                          $pa_url,   $pa_port,  $user_agent,
                                          $ordr_idxx,
                                          $payx_data, $ordr_data,
                                          $rcvr_data, $escw_data,
                                          $modx_data,
                                          $this->m_encx_data, $this->m_encx_info,
                                          $log_level, $opt );
      }
      else
      {
				$res_data = $this->mf_exec( $home_dir . "/bin/pp_cli",
                                    "-h",
                                    "home="      . $home_dir          . "," .
                                    "site_cd="   . $site_cd           . "," .
                                    "site_key="  . $site_key          . "," .
                                    "tx_cd="     . $tx_cd             . "," .
                                    "pa_url="    . $pa_url            . "," .
                                    "pa_port="   . $pa_port           . "," .
                                    "ordr_idxx=" . $ordr_idxx         . "," .
                                    "payx_data=" . $payx_data         . "," .
                                    "ordr_data=" . $ordr_data         . "," .
                                    "rcvr_data=" . $rcvr_data         . "," .
                                    "escw_data=" . $escw_data         . "," .
                                    "modx_data=" . $modx_data         . "," .
                                    "enc_data="  . $this->m_encx_data . "," .
                                    "enc_info="  . $this->m_encx_info . "," .
                                    "trace_no="  . $trace_no          . "," .
                                    "cust_ip="   . $cust_ip           . "," .
                                    "log_path="  . $g_conf_log_path   . ","	.
                                    "log_level=" . $log_level         . "," .
                                    "opt="       . $opt               . "," .		                          
		                          	"mode="		 . $mode              . "" 
			                        		  );
              
				
                              
        if ( $res_data == "" )
        {
           $res_data = "res_cd=9502" . chr( 31 ) . "res_msg=���� ��� ȣ�� ����";
        }
      }

      parse_str( str_replace( chr( 31 ), "&", $res_data ), $this->m_res_data );

      $this->m_res_cd  = $this->m_res_data[ "res_cd"  ];
      $this->m_res_msg = $this->m_res_data[ "res_msg" ];
    }

    /* -------------------------------------------------------------------- */
    /* -   FUNC  :  ó�� ��� ���� �����ϴ� �Լ�                          - */
    /* -------------------------------------------------------------------- */
    function  mf_get_res_data( $name )
    {
      return  $this->m_res_data[ $name ];
    }

    function  mf_get_payx_data()
    {
      if ( $this->m_payx_common != "" || $this->m_payx_card != "" )
      {
        $my_data  = "payx_data=";
      }

      if ( $this->m_payx_common != "" )
      {
        $my_data .= "common=" . $this->m_payx_common . chr( 30 );
      }

      if ( $this->m_payx_card != "" )
      {
        $my_data .= ( "card=" . $this->m_payx_card   . chr( 30 ) );
      }

      return  $my_data;
    }

    function  mf_get_data( $data_name, $data )
    {
      if ( $data != "" )
      {
        $my_data = $data_name . "=" . $data;
      }
      else
      {
        $my_data = "";
      }

      return  $my_data;
    }

    function  mf_exec()
    {
      $arg = func_get_args();

      if ( is_array( $arg[0] ) )  $arg = $arg[0];

      $exec_cmd = array_shift( $arg );

      while ( list(,$i) = each($arg) )
      {
        $exec_cmd .= " " . escapeshellarg( $i );
      }

      $rt = exec( $exec_cmd );

      return  $rt;
    }
  }
?>