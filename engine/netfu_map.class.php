<?php

class netfu_map {

	var $js_script = '';
	var $js_array = array(
		'daum'=>'<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey={키값}&libraries=services"></script>',
	);

	function netfu_map() {
		global $design, $env;
		$map_key = $env[$env['use_map'].'_map_key'];
		$this->js_script = preg_replace("/{키값}/", $map_key, $this->js_array[$env['use_map']]);
	}
}
?>