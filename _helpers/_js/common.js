var charset = 'UTF-8';
var domain = document.domain;
var is_http = /\s(?:http|https):\/\/\S*(?:\s|$)/g;

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);} 
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'':(v='hide')?'none':v; }
    obj.display=v; }
}

function showhide() { //v3.0
  var i,p,v,obj,args=showhide.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}
// TAB  -------------------------------------------------------------------*/
function Chtab(layername,xid,len){

	try{
		for(i=1;i <= len; i++){
			if (i==xid)	document.getElementById(layername+i).style.display="block";
			else	document.getElementById(layername+i).style.display="none";
		}
	} catch (e)	{}
}

function Ch_Class(layername,xid,len,class_name){

	try{
		for(i=1;i <= len; i++){
			if (i==xid)	document.getElementById(layername+i).className=class_name;
			else	document.getElementById(layername+i).className="";
		}
	} catch (e)	{}
}
// 포커싱   -------------------------------------------------------------------*/
function bluring(){  
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") document.body.focus();  
}  
document.onfocusin=bluring;
// 인풋 비활성화 배경   -------------------------------------------------------------------*/
isDisabled = function (){
        for (var i=0; i<this.length; i++){
          if(this.item(i).disabled) this.item(i).style.backgroundColor="#e5e5e5";
        }
      }
      window.onload = function (){
        var input = document.getElementsByTagName("INPUT");
        //isDisabled.apply(input);  
      }
// 플래시 출력   -------------------------------------------------------------------*/	
function get_embed(src,query,width,height,vars)
{
	src += '?' + query;
	var codebase = "http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0";
	var pluginspage = "http://www.macromedia.com/go/getflashplayer";

	if (document.location.protocol == "https:") {
		codebase = codebase.replace(/http:/, "https:");
		pluginspage = pluginspage.replace(/http:/, "https:");
	}

	var widthAttr = (width > 0 ? 'width="'+width+'"' : '');
	var heightAttr = (height > 0 ? 'height="'+height+'"' : '');
	var tag = '';
	tag += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="'+codebase+'" '+widthAttr+' '+heightAttr+'>';
	tag += '<param name="movie" value="'+src+'"/>';
	tag += '<param name="quality" value="high"/>';
	tag += '<param name="wmode" value="transparent"/>';
	tag += '<param name="bgcolor" value="#FFFFFF"/>';
	tag += '<param name="flashvars" value="' + vars + '"/>';
	tag += '<embed src="'+src+'" quality="high" wmode="transparent" bgcolor="#FFFFFF" '+widthAttr+' '+heightAttr+' type="application/x-shockwave-flash" pluginspage="'+pluginspage+'" flashvars="' + vars + '"></embed>';
	tag += '</object>';
	return tag;
}		
function embed(src,query,width,height,vars)
{
	var tag = get_embed(src,query,width,height,vars);
	document.write(tag);
}			
// 플래시 활성화   -------------------------------------------------------------------*/
function insertFlash( id, flashUri, vWidth, vHeight, winMode ) {
	var _obj_ = "";

	_obj_ = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8.0.35.0" width="' + vWidth + '" height="' + vHeight + '" id="' + id + '" align="middle">';
	_obj_ += '<param name="allowScriptAccess" value="always" />';
	_obj_ += '<param name="movie" value="' + flashUri + '" />';
	_obj_ += '<param name="quality" value="high" />';
	_obj_ += '<param name="wmode" value="' + winMode + '" />    ';
	_obj_ += '<param name="bgcolor" value="#ffffff" />        ';
	_obj_ += '<param name="scale" value="exactfit" />        ';	
	_obj_ += '<embed src="' + flashUri + '" quality="high" wmode="' + winMode + '" bgcolor="#ffffff" width="' + vWidth +'" height="' + vHeight + '" id="' + id + '" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></embed>    ';
	_obj_ += '</object>';
	document.writeln( _obj_ );
}
//텍스트에어리어 비우기
function OnEnter( field ) { if( field.value == field.defaultValue ) { field.value = ""; } } 

function trim(str){
   //정규 표현식을 사용하여 화이트스페이스를 빈문자로 전환
   str = str.replace(/^\s*/,'').replace(/\s*$/, ''); 
   return str; //변환한 스트링을 리턴.
}

// 쿠키 얻음
function get_cookie(name) {
	var find_sw = false;
	var start, end;
	var i = 0;

	for (i=0; i<= document.cookie.length; i++){
		start = i;
		end = start + name.length;

		if(document.cookie.substring(start, end) == name) 
		{
			find_sw = true
			break
		}
	}

	if (find_sw == true) {
		start = end + 1;
		end = document.cookie.indexOf(";", start);

		if(end < start)
			end = document.cookie.length;

		return document.cookie.substring(start, end);
	}
	return "";
}

// 쿠키 지움
function delete_cookie(name) {
	var today = new Date();

	today.setTime(today.getTime() - 1);
	var value = get_cookie(name);
	if(value != "")
		document.cookie = name + "=" + value + "; path=/; expires=" + today.toGMTString();
}

/* 사용자 브라우저 */
var user_agent = "";
if( new RegExp(/MSIE/).test(navigator.userAgent) ){ 
	user_agent = "IE";
} else if( new RegExp(/Chrome/).test(navigator.userAgent) ){
	user_agent = "Chrome";
} else if( new RegExp(/Firefox/).test(navigator.userAgent) ){
	user_agent = "Firefox";
} else if( new RegExp(/Opera/).test(navigator.userAgent) ){
	user_agent = "Opera";
} else if( new RegExp(/Safari/).test(navigator.userAgent) ){
	user_agent = "Safari";
}else if( new RegExp(/Netscape/).test(navigator.userAgent) ){ 
	user_agent = "Netscape";
}
/* //사용자 브라우저 */

is_sb = !1,
is_ie6 = !1; - 1 != navigator.userAgent.indexOf("MSIE") && (-1 != navigator.userAgent.indexOf("MSIE 8.0") ? is_sb = !0 : -1 != navigator.userAgent.indexOf("MSIE 7.0") ? is_sb = !0 : -1 != navigator.userAgent.indexOf("MSIE 6.0") && (is_ie6 = is_sb = !0));

// 이메일 정규식 체크
var isValidEmails = function(value) {
	var pattern = /^[_a-zA-Z0-9-\.]+@[\.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	return (pattern.test(value)) ? true : false;
}
// 아이디 정규식 체크
var isValidUserids = function(value){
	var chk1 = /^[a-zA-Z\d]{4,20}$/g;  //a-z와 0-9이외의 문자가 있는지 확인
    var chk2 = /[a-zA-Z]/i;  //적어도 한개의 a-z 확인
    var chk3 = /\d/;  //적어도 한개의 0-9 확인
	return chk1.test(value) && chk2.test(value) && chk3.test(value);
}
var isValidUserpw = function(value) {
	var pattern = /^[a-zA-Z0-9_.]{6,20}$/;
	return (pattern.test(value)) ? true : false;
}
var getPlaceholderElement = function(a) {
    if ($(a).attr("name").length) {
        var c = $(a).attr("name") + "_placeholder";
        if ($("#" + c).length) return $("#" + c).get(0);
        var b = document.createElement("input");
        b.setAttribute("type", "text");
        b.setAttribute("id", c);
        b.setAttribute("class", $(a).attr("class"));
        b.setAttribute("value", $(a).attr("placeholder"));
        b.setAttribute("link_element_name", $(a).attr("name"));
        $(b).css({
            color: "#aaa",
            width: $(a).width(),
            position: "absolute",
            marginLeft: "0px"
        });
        $(b).hide();
        b.onfocus = function () {
            link_element = $('input[name="' + $(this).attr("link_element_name") + '"]');
            $(this).hide();
            $(link_element).focus()
        };
        $(a).parent().prepend(b);
        return b
    }
}
// url 검사
var isValidUrl = function (strUrl){
	var RegexUrl = /(http|https|ftp|telnet|news|mms):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return RegexUrl.test(strUrl);
}
var checkDetailUrl = function(strUrl) {
    var expUrl = /^(http\:\/\/)?((\w+)[.])+(asia|biz|cc|cn|com|de|eu|in|info|jobs|jp|kr|mobi|mx|name|net|nz|org|travel|tv|tw|uk|us)(\/(\w*))*$/i;
    return expUrl.test(strUrl);
}
var fncRplc = function(obj){
	var patt = /[\ㄱ-ㅎ가-힣]/g;
	obj.value = obj.value.replace(patt, '');
}
var sel_toggle = function(id){
	$('#'+id).toggle();
}

// 이달 마지막날짜
var LastDayOfMonth = function(Year, Month) {
    return(new Date((new Date(Year, Month+1,1))-1)).getDate();
}

var addslashes = function(str) {
	str=str.replace(/\\/g,'\\\\');
	str=str.replace(/\'/g,'\\\'');
	str=str.replace(/\"/g,'\\"');
	str=str.replace(/\0/g,'\\0');
	return str;
}
var stripslashes = function (str) {
	str=str.replace(/\\'/g,'\'');
	str=str.replace(/\\"/g,'"');
	str=str.replace(/\\0/g,'\0');
	str=str.replace(/\\\\/g,'\\');
	return str;
}
var nl2br = function(str, is_xhtml) {
  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
var imgLinkView = function(link, img){
	var imgObj = new Image();
	imgObj.src = link;
	var w = imgObj.width, h = imgObj.height;
	var img_src = imgObj.src;

	var winl = (screen.width-w)/2; 
	var wint = (screen.height-h)/3; 

	if (w >= screen.width) { 
		winl = 0; 
		h = (parseInt)(w * (h / w)); 
	} 

	if (h >= screen.height) { 
		wint = 0; 
		w = (parseInt)(h * (w / h)); 
	} 

	var js_url = "<script type='text/javascript'> \n"; 
		js_url += "<!-- \n"; 
		js_url += "var ie=document.all; \n"; 
		js_url += "var nn6=document.getElementById&&!document.all; \n"; 
		js_url += "var isdrag=false; \n"; 
		js_url += "var x,y; \n"; 
		js_url += "var dobj; \n"; 
		js_url += "function movemouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  if (isdrag) \n"; 
		js_url += "  { \n"; 
		js_url += "    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n"; 
		js_url += "    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "function selectmouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  var fobj      = nn6 ? e.target : event.srcElement; \n"; 
		js_url += "  var topelement = nn6 ? 'HTML' : 'BODY'; \n"; 
		js_url += "  while (fobj.tagName != topelement && fobj.className != 'dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n"; 
		js_url += "  } \n"; 
		js_url += "  if (fobj.className=='dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    isdrag = true; \n"; 
		js_url += "    dobj = fobj; \n"; 
		js_url += "    tx = parseInt(dobj.style.left+0); \n"; 
		js_url += "    ty = parseInt(dobj.style.top+0); \n"; 
		js_url += "    x = nn6 ? e.clientX : event.clientX; \n"; 
		js_url += "    y = nn6 ? e.clientY : event.clientY; \n"; 
		js_url += "    document.onmousemove=movemouse; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "document.onmousedown=selectmouse; \n"; 
		js_url += "document.onmouseup=new Function('isdrag=false'); \n"; 
		js_url += "//--> \n"; 
		js_url += "</"+"script> \n"; 

	var settings;

	if (is_gecko) {
		settings  ='width='+(w+10)+','; 
		settings +='height='+(h+10)+','; 
	} else {
		settings  ='width='+w+','; 
		settings +='height='+h+','; 
	}
	settings +='top='+wint+','; 
	settings +='left='+winl+','; 
	settings +='scrollbars=no,'; 
	settings +='resizable=yes,'; 
	settings +='status=no'; 

	win=window.open("","image_window",settings); 
	win.document.open(); 
	win.document.write ("<html><head> \n<meta http-equiv='imagetoolbar' CONTENT='no'> \n<meta http-equiv='content-type' content='text/html; charset="+charset+"'>\n"); 
	var size = "이미지 사이즈 : "+w+" x "+h;
	win.document.write ("<title>"+size+"</title> \n"); 
	if(w >= screen.width || h >= screen.height) { 
		win.document.write (js_url); 
		var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n 이미지 사이즈가 화면보다 큽니다. \n 왼쪽 버튼을 클릭한 후 마우스를 움직여서 보세요. \n\n 더블 클릭하면 닫혀요. '"; 
	} 
	else 
		var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n 클릭하면 닫혀요. '"; 

	win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
	win.document.write ("</head> \n\n"); 
	win.document.write ("<body leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n"); 
	win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img src='"+img_src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");
	win.document.write ("</body></html>"); 
	win.document.close(); 

	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
}

var image_window = function(img){
	
	var w = img.width; 
	var h = img.height;
	var winl = (screen.width-w)/2; 
	var wint = (screen.height-h)/3; 

	if (w >= screen.width) { 
		winl = 0; 
		h = (parseInt)(w * (h / w)); 
	} 

	if (h >= screen.height) { 
		wint = 0; 
		w = (parseInt)(h * (w / h)); 
	} 

	var js_url = "<script type='text/javascript'> \n"; 
		js_url += "<!-- \n"; 
		js_url += "var ie=document.all; \n"; 
		js_url += "var nn6=document.getElementById&&!document.all; \n"; 
		js_url += "var isdrag=false; \n"; 
		js_url += "var x,y; \n"; 
		js_url += "var dobj; \n"; 
		js_url += "function movemouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  if (isdrag) \n"; 
		js_url += "  { \n"; 
		js_url += "    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n"; 
		js_url += "    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "function selectmouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  var fobj      = nn6 ? e.target : event.srcElement; \n"; 
		js_url += "  var topelement = nn6 ? 'HTML' : 'BODY'; \n"; 
		js_url += "  while (fobj.tagName != topelement && fobj.className != 'dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n"; 
		js_url += "  } \n"; 
		js_url += "  if (fobj.className=='dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    isdrag = true; \n"; 
		js_url += "    dobj = fobj; \n"; 
		js_url += "    tx = parseInt(dobj.style.left+0); \n"; 
		js_url += "    ty = parseInt(dobj.style.top+0); \n"; 
		js_url += "    x = nn6 ? e.clientX : event.clientX; \n"; 
		js_url += "    y = nn6 ? e.clientY : event.clientY; \n"; 
		js_url += "    document.onmousemove=movemouse; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "document.onmousedown=selectmouse; \n"; 
		js_url += "document.onmouseup=new Function('isdrag=false'); \n"; 
		js_url += "//--> \n"; 
		js_url += "</"+"script> \n"; 

	var settings;

	if (is_gecko) {
		settings  ='width='+(w+10)+','; 
		settings +='height='+(h+10)+','; 
	} else {
		settings  ='width='+w+','; 
		settings +='height='+h+','; 
	}
	settings +='top='+wint+','; 
	settings +='left='+winl+','; 
	settings +='scrollbars=no,'; 
	settings +='resizable=yes,'; 
	settings +='status=no'; 


	win=window.open("","image_window",settings); 
	win.document.open(); 
	win.document.write ("<html><head> \n<meta http-equiv='imagetoolbar' CONTENT='no'> \n<meta http-equiv='content-type' content='text/html; charset="+charset+"'>\n"); 
	var size = "이미지 사이즈 : "+w+" x "+h;
	win.document.write ("<title>"+size+"</title> \n"); 
	if(w >= screen.width || h >= screen.height) { 
		win.document.write (js_url); 
		var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n 이미지 사이즈가 화면보다 큽니다. \n 왼쪽 버튼을 클릭한 후 마우스를 움직여서 보세요. \n\n 더블 클릭하면 닫혀요. '"; 
	} 
	else 
		var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n 클릭하면 닫혀요. '"; 
	win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
	win.document.write ("</head> \n\n"); 
	win.document.write ("<body leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n"); 
	win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img src='"+img.src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");
	win.document.write ("</body></html>"); 
	win.document.close(); 

	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
}
var resizeBoardImage = function(imageWidth, borderColor) {
    var content = document.getElementById("writeContents");
    if (content) {
        var target = content.getElementsByTagName("img");
        if (target) {
            var imageHeight = 0;

            for(i=0; i<target.length; i++) { 
                // 원래 사이즈를 저장해 놓는다
                target[i].tmpWidth  = target[i].width;
                target[i].tmpHeight = target[i].height;

                //alert(target[i].width);

                // 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다
                if(target[i].width > imageWidth) {
                    imageHeight = parseFloat(target[i].width / target[i].height)
                    target[i].width = imageWidth;
                    target[i].height = parseInt(imageWidth / imageHeight);

                    // 스타일에 적용된 이미지의 폭과 높이를 삭제한다
                    target[i].style.width = '';
                    target[i].style.height = '';
                }

                if (borderColor) {
                    target[i].style.borderWidth = '1px';
                    target[i].style.borderStyle = 'solid';
                    target[i].style.borderColor = borderColor;
                }
            }
        }
    }

    var target = document.getElementsByName('target_resize_image[]');
    var imageHeight = 0;

    if (target) {
        for(i=0; i<target.length; i++) { 
            // 원래 사이즈를 저장해 놓는다
            target[i].tmp_width  = target[i].width;
            target[i].tmp_height = target[i].height;
            // 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다
            if(target[i].width > imageWidth) {
                imageHeight = parseFloat(target[i].width / target[i].height)
                target[i].width = imageWidth;
                target[i].height = parseInt(imageWidth / imageHeight);
                target[i].style.cursor = 'pointer';

                // 스타일에 적용된 이미지의 폭과 높이를 삭제한다
                target[i].style.width = '';
                target[i].style.height = '';
            }

            if (borderColor) {
                target[i].style.borderWidth = '1px';
                target[i].style.borderStyle = 'solid';
                target[i].style.borderColor = borderColor;
            }
        }
    }
}

var image_window_view = function(img, width, height){	// 이력서 포토앨범 사진 원본으로 겁나 크게 보임
	//var w = img.width; 
	//var h = img.height;
	var w = Number(width);
	var h = Number(height);
	var winl = w; //(screen.width-w)/2; 
	var wint = h; //(screen.height-h)/3; 

	/*
	if (w >= screen.width) { 
		winl = 0; 
		h = (parseInt)(w * (h / w)); 
	} 

	if (h >= screen.height) { 
		wint = 0; 
		w = (parseInt)(h * (w / h)); 
	} 
	*/

	var js_url = "<script type='text/javascript'> \n"; 
		js_url += "<!-- \n"; 
		js_url += "var ie=document.all; \n"; 
		js_url += "var nn6=document.getElementById&&!document.all; \n"; 
		js_url += "var isdrag=false; \n"; 
		js_url += "var x,y; \n"; 
		js_url += "var dobj; \n"; 
		js_url += "function movemouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  if (isdrag) \n"; 
		js_url += "  { \n"; 
		js_url += "    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n"; 
		js_url += "    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "function selectmouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  var fobj      = nn6 ? e.target : event.srcElement; \n"; 
		js_url += "  var topelement = nn6 ? 'HTML' : 'BODY'; \n"; 
		js_url += "  while (fobj.tagName != topelement && fobj.className != 'dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n"; 
		js_url += "  } \n"; 
		js_url += "  if (fobj.className=='dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    isdrag = true; \n"; 
		js_url += "    dobj = fobj; \n"; 
		js_url += "    tx = parseInt(dobj.style.left+0); \n"; 
		js_url += "    ty = parseInt(dobj.style.top+0); \n"; 
		js_url += "    x = nn6 ? e.clientX : event.clientX; \n"; 
		js_url += "    y = nn6 ? e.clientY : event.clientY; \n"; 
		js_url += "    document.onmousemove=movemouse; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "document.onmousedown=selectmouse; \n"; 
		js_url += "document.onmouseup=new Function('isdrag=false'); \n"; 
		js_url += "//--> \n"; 
		js_url += "</"+"script> \n"; 

	var settings;

	if (is_gecko) {
		settings  ='width='+(w+10)+','; 
		settings +='height='+(h+10)+','; 
	} else {
		settings  ='width='+w+','; 
		settings +='height='+h+','; 
	}
	settings +='top='+wint+','; 
	settings +='left='+winl+','; 
	settings +='scrollbars=no,'; 
	settings +='resizable=yes,'; 
	settings +='status=no'; 


	win=window.open("","image_window",settings); 
	win.document.open(); 
	win.document.write ("<html><head> \n<meta http-equiv='imagetoolbar' CONTENT='no'> \n<meta http-equiv='content-type' content='text/html; charset="+charset+"'>\n"); 
	var size = "이미지 사이즈 : "+w+" x "+h;
	win.document.write ("<title>"+size+"</title> \n"); 
	if(w >= screen.width || h >= screen.height) { 
		win.document.write (js_url); 
		var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n 이미지 사이즈가 화면보다 큽니다. \n 왼쪽 버튼을 클릭한 후 마우스를 움직여서 보세요. \n\n 더블 클릭하면 닫혀요. '"; 
	} 
	else 
		var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n 클릭하면 닫혀요. '"; 
	win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
	win.document.write ("</head> \n\n"); 
	win.document.write ("<body leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n"); 
	win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img src='"+img.src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");
	win.document.write ("</body></html>"); 
	win.document.close(); 

	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
}
var selAll = function(){	// 전체선택
	$('.check_all').each(function(){
		var sel = $(this).attr('checked');
		if(sel=='checked') {
			$('.check_all').attr('checked',false);
			$("input[name='check_all']").attr('checked',false);
			return false;
		} else {
			$('.check_all').attr('checked',true);
			$("input[name='check_all']").attr('checked',true);
			return false;
		}
	});
}
// 글숫자 검사
var check_byte = function (content, target) {
	var i = 0;
	var cnt = 0;
	var ch = '';
	var cont = document.getElementById(content).value;

	for (i=0; i<cont.length; i++) {
		ch = cont.charAt(i);
		if (escape(ch).length > 4) {
			cnt += 2;
		} else {
			cnt += 1;
		}
	}
	// 숫자를 출력
	document.getElementById(target).innerHTML = cnt;

	return cnt;
}
// 즐겨찾기 추가
var addFavorite = function( title ){

	window.external.AddFavorite('http://' + domain, title);

}
// 시작 페이지로 설정
var addStart = function(){
	document.body.style.behavior='url(#default#homepage)';
	document.body.setHomePage('http://' + domain);
}
// 기본 팝업창
var win_open = function(a, b, c, k) {
    c = window.open(a, b, "width=" + c + ", height=" + k + ", scrollbars=no, resizable=no, status=no,top=" + (screen.height - 550) / 2 + ",left=" + (screen.width - 640) / 2);
    c.focus()	
}
// input field 한글/숫자/영문 (onkeyup event)
var field_types = function( sel, type ){

	switch(type){
		case 'english':
			sel.value = sel.value.replace(/^a-zA-z]/g,'');
		break;
		case 'hangle':
			sel.value = sel.value.replace(/[^ㄱ-ㅎ가-횧]/g,'');
		break;
		case 'number':
			sel.value = sel.value.replace(/[^0-9]/g,'');
		break;
	}

}
var file_download = function(link, file) {	// 파일 다운로드
    document.location.href = link;
}
var isValidBlank = function(value) {
	var pattern = /[\s]/g;	///^\s+|\s+$/g;(/\s/g
	return (pattern.test(value)) ? true : false;
}
var CountChar = function( message, limit ){	 // 문자 bytes 계산 msg_bytes id 값만 잘 체크하면 됨
	var nbytes = 0;
	var availMsg = "";
	var chk=0;
	for (var i=0; i <message.value.length; i++){
		ch = message.value.charAt(i);
		if(escape(ch).length > 4) {
			nbytes += 2;
		} else if (ch == '\n') {
			if (message.value.charAt(i-1) != '\r') {
				nbytes += 1;
			}
		} else {
			nbytes += 1;
		}
		if (limit*1 >= nbytes*1) {
			availMsg += message.value.charAt(i);
		}
		$('#msg_bytes').html(nbytes*1);
	}
	if (nbytes*1 > limit*1) { // 바이트를 초과했을경우
		alert("[" + availMsg + "] 까지 발송됩니다.");
		//message.value = availMsg;
		$('#msg_bytes').html(limit*1);
		//message.focus();
		return;
	}
}
var CountCharText = function( message, limit, msg_bytes ){	 // text 필드 검사
	var nbytes = 0;
	var availMsg = "";
	var chk=0;
	for (var i=0; i <message.value.length; i++){
		ch = message.value.charAt(i);
		if(escape(ch).length > 4) {
			nbytes += 1;
		} else if (ch == '\n') {
			if (message.value.charAt(i-1) != '\r') {
				nbytes += 1;
			}
		} else {
			nbytes += 1;
		}
		if (limit*1 >= nbytes*1) {
			availMsg += message.value.charAt(i);
		}
		$('#'+msg_bytes).html(nbytes*1);
	}
	if (nbytes*1 > limit*1) { // 바이트를 초과했을경우
		//alert("[" + availMsg + "] 까지 입력 가능합니다.");
		$('#'+msg_bytes).html(limit*1);
		return;
	}
}


// 가운데 정렬
jQuery.fn.center = function () {
	this.css("position","absolute");
	//this.css("top", ((jQuery(window).height() - this.outerHeight()) / 2) + jQuery(window).scrollTop() + "px");
	this.css("left", ((jQuery(window).width() - this.outerWidth()) / 2) + jQuery(window).scrollLeft() + "px");
	return this;
}

$(function(){

	// 숫자만 입력 받기
	$('.tnum').keypress(function(event){
	  //alert(event.which);
	  if (event.which && (event.which  > 47 && event.which  < 58 || event.which == 8)) {
	  } else {
		event.preventDefault();
	  }
	});

	// 핸드폰 번호만 입력 받기 ('-' 허용)
	$('.phone').keypress(function(event){
	  //alert(event.which);
	  if (event.which && (event.which  > 47 && event.which  < 58 || event.which == 8 || event.which == 45)) {
	  } else {
		event.preventDefault();
	  }
	});

	// 기본 리스트 전체 체크 ( Check Box )
	$("input[name='check_all']").click(function(){
		var sel = $(this).attr('checked');		
		if(sel=='checked') $('.check_all').attr('checked',true);
		else $('.check_all').attr('checked',false);	
	});


	$('#start_day').datepicker({dateFormat: 'yy-mm-dd'});
	$('#end_day').datepicker({dateFormat: 'yy-mm-dd'});

	/* 날짜 선택에 따른 Value Sets */
	$('.set_day').click(function(){
		var sel_date = $(this).attr('date');
		var todate = new Date();

		switch(sel_date){
			case 'all': $('#start_day, #end_day').val(''); break;
			case 'today': $('#start_day, #end_day').datepicker('setDate', 'd'); break;
			case 'week':	// 이번주
				startDate = new Date(todate.getFullYear(), todate.getMonth(), todate.getDate() - todate.getDay());
				endDate = new Date(todate.getFullYear(), todate.getMonth(), todate.getDate() - todate.getDay() + 6);
				$('#start_day').datepicker('setDate', startDate);
				$('#end_day').datepicker('setDate', endDate); 
			break;
			case 'month':	 // 이번달
				startDate = new Date(todate.getFullYear(), todate.getMonth());
				endDate = new Date(todate.getFullYear(), todate.getMonth(), LastDayOfMonth(todate.getFullYear(), todate.getMonth()));
				$('#start_day').datepicker('setDate', startDate);
				$('#end_day').datepicker('setDate', endDate); 
			break;
			case 'yesterday': 
				$('#start_day').datepicker('setDate', '-1d');
				$('#end_day').datepicker('setDate', '-1d'); 
			break;
			case '3day': 
				$('#start_day').datepicker('setDate', '-3d'); 
				$('#end_day').datepicker('setDate', 'd'); 
			break;
			case '7day': 
				$('#start_day').datepicker('setDate', '-7d'); 
				$('#end_day').datepicker('setDate', 'd'); 
			break;
			case '15day': 
				$('#start_day').datepicker('setDate', '-15d'); 
				$('#end_day').datepicker('setDate', 'd'); 
			break;
			case '30day': 
				$('#start_day').datepicker('setDate', '-30d'); 
				$('#end_day').datepicker('setDate', 'd'); 
			break;
			case '60day': 
				$('#start_day').datepicker('setDate', '-60d'); 
				$('#end_day').datepicker('setDate', 'd'); 
			break;
			case '90day': 
				$('#start_day').datepicker('setDate', '-90d'); 
				$('#end_day').datepicker('setDate', 'd'); 
			break;
			case '120day': 
				$('#start_day').datepicker('setDate', '-120d'); 
				$('#end_day').datepicker('setDate', 'd'); 
			break;
		}
	});

});

(function($){
     $.fn.extend({
          centers: function (options) {
               var options =  $.extend({ // Default values
                    inside:window, // element, center into window
                    transition: 0, // millisecond, transition time
                    minX:0, // pixel, minimum left element value
                    minY:0, // pixel, minimum top element value
                    withScrolling:true, // booleen, take care of the scrollbar (scrollTop)
                    vertical:true, // booleen, center vertical
                    horizontal:true // booleen, center horizontal
               }, options);
               return this.each(function() {
                    var props = {position:'absolute'};
                    if (options.vertical) {
                         var top = ($(options.inside).height() - $(this).outerHeight()) / 2;
                         if (options.withScrolling) top += $(options.inside).scrollTop() || 0;
                         top = (top > options.minY ? top : options.minY);
                         $.extend(props, {top: top+'px'});
                    }
                    if (options.horizontal) {
                          var left = ($(options.inside).width() - $(this).outerWidth()) / 2;
                          if (options.withScrolling) left += $(options.inside).scrollLeft() || 0;
                          left = (left > options.minX ? left : options.minX);
                          $.extend(props, {left: left+'px'});
                    }
                    if (options.transition > 0) $(this).animate(props, options.transition);
                    else $(this).css(props);
                    return $(this);
               });
          }
     });
})(jQuery);

/* 사용자 기본 함수(들) */
$(function(){
	$('#login_passwd').keydown(function(event){
		if(event.keyCode==13){	 // 엔터키 이벤트
			member_login();
		}
	});
});
var member_login = function(){	// 회원 로그인
	$('#MemberLoginFrm').submit();
}
var member_logout = function(){	// 회원 로그 아웃
	if(mb_id){
		if(confirm('로그아웃 하시겠습니까?')){
			$.post(base_path + "/member/process/logout.php", { mb_id:mb_id }, function(result){
				if(result=='0015'){
					alert("회원만 접근 가능합니다.");
					location.href = base_path;
				} else {
					location.href = base_path;
				}
			});
		}
	} else {
		alert("회원만 접근 가능합니다.");
	}
}
var more_no_views = function( vals, cookies, page_name, ids ){
	var sel = vals.value;
	var checked = vals.checked;
	var expire = Number(cookies);

	if(checked==true){

		$('#topBanner_quest_info').show();
		$('#topBanner_confirm_msg').html("최상단 위치의 광고를 "+expire+"일 동안 보지 않길 원하십니까?");
		
		$('#topBanner_questionAnswerYes').html('<input type="button" onClick="topBanner_questionAnswer(\'yes\', \'TopbannerClose\',\''+page_name+'\',\''+expire+'\',\''+sel+'\',\''+ids+'\');" value="예" />');
		
		// 질의(Confirm) 창 띄우기
		$.blockUI({ 
			theme: true,
			title: "<p align='left'>최상단 광고 출력 유무</p>",
			showOverlay: false,
			message: $('#topBanner_question')
		});

		/*
		if(confirm('3일간 보지 않으시겠습니까?')){
			$.cookie(page_name+'_banner_'+sel, 'done', { expires: expire, domain:domain, path:'/', secure:0 } );
		}
		*/
	}

}
var topBanner_questionAnswer = function(answer, mode, page_name, cookies, sel, ids){	 // 최상단 배너 질의 응답에 따른 처리

	if(answer=='yes'){
		switch(mode){
			// 최상단 배너 1일 동안 안보이기
			case 'TopbannerClose':
				var expire = Number(cookies);
				var banner = page_name+'_banner_'+sel;
				$.cookie(banner, 'done', { expires: expire, domain:domain, path:'/', secure:0 } );
				$.unblockUI();
				$('#'+ids).fadeOut();
				//$('#'+banner).hide();
				/*
				$('#ad_banner').load('./views/_load/banner.php', { mode:'top_banner_refresh', position:'main_top' }, function(result){
					//alert(result);
				});
				*/
			break;
		}
	} else {
		$("input[name='more_no_view']").attr('checked',false);
		$.unblockUI();
	}

}

// Infinite blink/fade 
var effectFadeIn = function( classname, time ) {
	$("."+classname).fadeOut(time).fadeIn(time, effectFadeOut(classname));
}
var effectFadeOut = function( classname, time ) {
	$("."+classname).fadeIn(time).fadeOut(time, function(){
		effectFadeIn(classname);
	});
}
// 사용법 :: effectFadeIn('fade_image', 1000);

var fade_images = function( classname ){	// 단순히 1초만에 사라지고 다시 나타남
	$('.'+classname).fadeOut(1000, function(){
		$(this).show();
	});
}
/* 사용법
	fade_images('fade_image');
	setInterval(function(){
		fade_images('fade_image');
	}, 3000);
*/

var blink = function( classname, time, interval ){	// 깜빡깜빡 거림
    var timer = window.setInterval(function(){
        $("."+classname).css("opacity", "0.1");
        window.setTimeout(function(){
            $("."+classname).css("opacity", "1");
        }, 100);
    }, interval);
    window.setTimeout(function(){clearInterval(timer);}, time);
}
// 사용법 :: blink('blink_image',900000,1500);

/* //사용자 기본 함수(들) */

// 공통으로 사용하는 helper 함수
var util = {

	// template을 parsing한 문자열 반환
	parseTemplate : function(tpl, data, regExp) {
		var regExp = regExp || new RegExp("##([a-zA-Z0-9_-]+)##", "gi");
		var result = tpl.replace(regExp, function(str, p1) {
			if (data[p1]) {
				return data[p1];
			} else {
				return "";
			}
		});
		return result;
	},

	isNumInput : function(keyCode, value) {
		if (keyCode === 9) { // tab key
			return true;
		}

		// 0-9(키패드 포함), backspace, left & right arrow, home & end, delete만 허용
		if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || keyCode === 8 || keyCode === 37 || keyCode === 39 || keyCode === 35 || keyCode == 36 || keyCode === 46) {
			if (!$.trim(value) && keyCode === 48) { // 첫 자리가 0일 경우에는 무시
				return false;
			}
			return true;
		}
		return false;
	},

	addComma : function(num) {
		num += '';
		x = num.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	},

	inArray : function(arr, cmp) {
		var i = 0;

		for (i = 0; i < arr.length; i++) {
			if (arr[i] !== "") {
				if (cmp === arr[i]) {
					return true;
				}
			}
		}
		return false;
	},

	isIOS : function() {
		var userAgent = window.navigator.userAgent;
		return (userAgent.match(/iPhone/i) || userAgent.match(/iPad/i));
	},

	specailChar : function (charVal) {
		var result = charVal;

		if (result != "") {
			result = escape(result);
			result = result.replace(/\%B7/g, "%A1%A4");
			result = result.replace(/\+/g, "%2B");
			result = result.replace(/\//g, "%2F");
			result = result.replace(/\,/g, "%2C");
			result = result.replace(/\:/g, "%3A");
			result = result.replace(/\#/g, "%23");
		}
		return result;
	},

	getAPIHost : function() {
		var href = window.location.href.toLowerCase();

		if (href.indexOf("consulting") > -1 || href.indexOf("jobkorea.co.kr") < 0 || href.indexOf("admintest") > -1) {
			return "http://consulting.jobkorea.co.kr:5271";
		} else {
			return "http://api.jobkorea.co.kr";
		}
	}
};

function strtotime (text, now) {
    // Convert string representation of date and time to a timestamp
    //
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/strtotime
    // +   original by: Caio Ariede (http://caioariede.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: David
    // +   improved by: Caio Ariede (http://caioariede.com)
    // +   bugfixed by: Wagner B. Soares
    // +   bugfixed by: Artur Tchernychev
    // +   improved by: A. Matías Quezada (http://amatiasq.com)
    // +   improved by: preuter
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: Examples all have a fixed timestamp to prevent tests to fail because of variable time(zones)
    // *     example 1: strtotime('+1 day', 1129633200);
    // *     returns 1: 1129719600
    // *     example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200);
    // *     returns 2: 1130425202
    // *     example 3: strtotime('last month', 1129633200); 
    // *     returns 3: 1127041200
    // *     example 4: strtotime('2009-05-04 08:30:00');
    // *     returns 4: 1241418600
    var parsed, match, year, date, days, ranges, len, times, regex, i;

    if (!text) {
        return null;
    }

    // Unecessary spaces
    text = text.trim()
        .replace(/\s{2,}/g, ' ')
        .replace(/[\t\r\n]/g, '')
        .toLowerCase();

    if (text === 'now') {
        return now === null || isNaN(now) ? new Date().getTime() / 1000 | 0 : now | 0;
    }
    if (!isNaN(parsed = Date.parse(text))) {
        return parsed / 1000 | 0;
    }
    if (text === 'now') {
        return new Date().getTime() / 1000; // Return seconds, not milli-seconds
    }
    if (!isNaN(parsed = Date.parse(text))) {
        return parsed / 1000;
    }

    match = text.match(/^(\d{2,4})-(\d{2})-(\d{2})(?:\s(\d{1,2}):(\d{2})(?::\d{2})?)?(?:\.(\d+)?)?$/);
    if (match) {
        year = match[1] >= 0 && match[1] <= 69 ? +match[1] + 2000 : match[1];
        return new Date(year, parseInt(match[2], 10) - 1, match[3],
            match[4] || 0, match[5] || 0, match[6] || 0, match[7] || 0) / 1000;
    }

    date = now ? new Date(now * 1000) : new Date();
	
    days = {
        'sun': 0,
        'mon': 1,
        'tue': 2,
        'wed': 3,
        'thu': 4,
        'fri': 5,
        'sat': 6
    };
    ranges = {
        'yea': 'FullYear',
        'mon': 'Month',
        'day': 'Date',
        'hou': 'Hours',
        'min': 'Minutes',
        'sec': 'Seconds'
    };

    function lastNext(type, range, modifier) {
        var diff, day = days[range];

        if (typeof day !== 'undefined') {
            diff = day - date.getDay();

            if (diff === 0) {
                diff = 7 * modifier;
            }
            else if (diff > 0 && type === 'last') {
                diff -= 7;
            }
            else if (diff < 0 && type === 'next') {
                diff += 7;
            }

            date.setDate(date.getDate() + diff);
        }
    }
    function process(val) {
        var splt = val.split(' '), // Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes
            type = splt[0],
            range = splt[1].substring(0, 3),
            typeIsNumber = /\d+/.test(type),
            ago = splt[2] === 'ago',
            num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

        if (typeIsNumber) {
            num *= parseInt(type, 10);
        }

        if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
            return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
        }
        if (range === 'wee') {
            return date.setDate(date.getDate() + (num * 7));
        }

        if (type === 'next' || type === 'last') {
            lastNext(type, range, num);
        }
        else if (!typeIsNumber) {
            return false;
        }
        return true;
    }

    times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
        '|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
        '|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
    regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

    match = text.match(new RegExp(regex, 'gi'));
    if (!match) {
        return false;
    }

    for (i = 0, len = match.length; i < len; i++) {
        if (!process(match[i])) {
            return false;
        }
    }

    // ECMAScript 5 only
    //if (!match.every(process))
    //    return false;

    return (date.getTime() / 1000);
}
var $time = Date.now || function() {
  return +new Date;
};


var timeConverter = function(UNIX_timestamp){
 var a = new Date(UNIX_timestamp*1000);
 var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
     var year = a.getFullYear();
     var month = months[a.getMonth()];
     var date = a.getDate();
     var hour = a.getHours();
     var min = a.getMinutes();
     var sec = a.getSeconds();
     var time = date+','+month+' '+year+' '+hour+':'+min+':'+sec ;
     return time;
 }

var numbersonly = function(e, decimal) {
    var key;
    var keychar;

    if (window.event) {
        key = window.event.keyCode;
    } else if (e) {
        key = e.which;
    } else {
        return true;
    }
    keychar = String.fromCharCode(key);

    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13)
            || (key == 27)) {
        return true;
    } else if ((("0123456789").indexOf(keychar) > -1)) {
        return true;
    } else if (decimal && (keychar == ".")) {
        return true;
    } else
        return false;
}

var scrollLink = function (obj){
	var position = $("#"+obj).offset();
	$('html, body').animate({scrollTop : position.top}, 800);
}
var leadingZeros = function (n, digits) {
	var zero = '';
	n = n.toString();
	if (n.length < digits) {
	for (i = 0; i < digits - n.length; i++)
	  zero += '0';
	}
	return zero + n;
}