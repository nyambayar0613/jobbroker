/**
 * 로그분석 클래스
 *@author: kurokisi
 *@authDate: 2011.10.11
 */
var google_analytics = {
	load: function() {
		var infos = {};
		var kinds = [];

		$('.chart').each(function(){
			var chart_id = $(this).attr('id');
			var width = $(this).css('width'), height = $(this).css('height');
			var kind = $(this).attr('kind'), shape = $(this).attr('shape'), recent = $(this).attr('recent');
			infos[chart_id] = {
				id: chart_id,
				width: width.replace('px',''),
				height: height.replace('px',''),
				kind: kind,
				shape: shape,
				recent: recent
			}
			/*
			kinds[chart_id] = {
				kind: kind,
				shape: shape,
				recent: recent
			}
			*/

			var info = infos[kind+'_chart'];

			if(recent=='yes'){
				google_analytics.draw( info, sdate, edate );
			} else {
				$.post("./process/google_ajax.php", { mode:'load', ajax:'true', shape:shape, kind:kind, sdate:sdate, edate:edate }, function(result){
					google_analytics.draw( info, sdate, edate );
				});
			}

		});

	},
	draw: function( info, sdate, edate ){
		with(info){
			
			/* 데이터 내용을 알고 싶다면 주석을 해제하라~ 
			$.post("./views/_data/"+shape+".php", { ajax:'true', kind:kind, sdate:sdate, edate:edate }, function(result){
				alert(result);
			});
			*/

			//alert( kind+"\n\n"+shape+"\n\n"+sdate+"\n\n"+edate+"\n\n"+id+"\n\n"+width+"\n\n"+height);
			var data_file = encodeURIComponent( './views/_data/'+ shape +'.php?kind='+ kind +'&sdate='+ sdate +'&edate='+ edate );
			var chart = '<scr'+'ipt type="text/javascript"> swfobject.embedSWF("'+chart_path+'/open-flash-chart.swf", "'+ id +'", "'+ width +'", "'+ height +'", "9.0.0", "expressInstall.swf", {"data-file":"'+ data_file +'" } ); </scr'+'ipt>';

			$('#'+id).html(chart);

		}
	}
}