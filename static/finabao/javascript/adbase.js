//首页幻灯片
var currentindex=1;

function changeflash(i) {	
	currentindex=i;
	var length=jQuery("#flash .marquee-item").length;
	for (j=1;j<=length;j++){
		if (j==i){
			jQuery("#flash"+j).fadeIn("normal");
			jQuery("#flash"+j).css("display","block");
			jQuery("#f"+j).removeClass();
			jQuery("#f"+j).addClass("dq");
			jQuery("#flashBg").css("background-color",jQuery("#flash"+j).attr("name"));
		}else{
			jQuery("#flash"+j).css("display","none");
			jQuery("#f"+j).removeClass();
			jQuery("#f"+j).addClass("no");
		}
}}
function startAm(){
	timerID = setInterval("timer_tick()",8000);//8000代表间隔时间设置
}
function stopAm(){
	clearInterval(timerID);
}
function timer_tick() {
	var length=jQuery("#flash .marquee-item").length;
    currentindex=currentindex>=length?1:currentindex+1;//此处的5代表幻灯片循环遍历的次数
		changeflash(currentindex);
}

//首页幻灯片（小）
var spcurrentindex=1;
function spChangeflash(i) {	
spcurrentindex=i;
var len=jQuery("#flashSp a").length;
if(len==1){
	jQuery(".sp-flash-bar-lite").hide();
	return;
}
for (j=1;j<=len;j++){
	if (j==i) 
	{jQuery("#flashSp"+j).fadeIn("normal");
	jQuery("#flashSp"+j).css("display","block");
	jQuery("#sf"+j).removeClass();
	jQuery("#sf"+j).addClass("dq");
	}
	else
	{jQuery("#flashSp"+j).css("display","none");
	jQuery("#sf"+j).removeClass();
	jQuery("#sf"+j).addClass("no");}
}}
function spStartAm(){
spTimerID = setInterval("spTimer_tick()",8000);
}
function spStopAm(){
clearInterval(spTimerID);
}
function spTimer_tick() {
	var len=jQuery("#flashSp a").length;
    spcurrentindex=spcurrentindex>=len?1:spcurrentindex+1;
	spChangeflash(spcurrentindex);}
	
startAm();
spStartAm();
jQuery(".sp-flash-bar div").mouseover(function(){stopAm();}).mouseout(function(){startAm();});
jQuery(".sp-flash-bar-lite div").mouseover(function(){spStopAm();}).mouseout(function(){spStartAm();});


jQuery(document).ready(function(){
	jQuery("#flashBg").css("background-color",jQuery("#flash1").attr("name"));
});

