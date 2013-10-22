function moveImg () {
	var node=document.getElementById("moveimg");
	node.style.right=0;
	move();
}
function move () {
	var node=document.getElementById('moveimg');
	node.style.right=parseInt(node.style.right)+1;
	var right=parseInt(node.style.right);
	var end=240;
	if(right<(end-10)){
		var temp=parseInt(right/40);
		var tt=end-right;
		var an=parseInt(0.8*(end/tt));
		/*
		   var temp=(temp*temp*temp)+an*an*an;
		   var length=parseInt(temp)
		   */
		var length=Math.exp(an);
		setTimeout(move,length);
	}
	return;
}
function easeInOut(initPos,targetPos,currentCount,count){
	var b=initPos,c=targetPos-initPos,t=currentCount,d=count;
	/*
	if((t/=(d/2))<1)return c/2*t*t*t*t+b;
	//if((t/=(d/2))<1)return c/2*t*t*t*t+b;
	t-=2;
	return -c/2*(t*t*t*t-2)+b;
	*/
	var num=1;
	if((targetPos-currentCount)<100){
		if(targetPos-count<0)return targetPos;
		var temp= 0.01*(targetPos-count)*be;//the currentCount and the 10000 need to be changed 1000,shouldn't exist;
		var an=0.01*(targetPos-count);
		//console.log(an*be);
		//be++;
		return parseInt(temp)+count;
	}
	return be+count;
}
function move2 (obj,targetPos,count) {
	obj=document.getElementById(obj);
	var currentCount=0;
	count =Math.abs(count)||1;//这个需要关注以下它的意义
	var elPos=obj;
	obj.style.right=0;
	var initPos=obj.style.right;
	be=3;
	var flag=setInterval(function(){
		console.log(obj.style.right);
		if((targetPos-obj.style.right)<1){
			clearInterval(flag);
		}
		else {
			currentCount++;
			//var tempx=easeInOut(initPos,targetPos,currentCount,count);
			var tempx=easeInOut(initPos,targetPos,currentCount,parseInt(obj.style.right));
		obj.style.right=tempx;
		//	console.log(tempx);
			/*
			if(Math.abs(tempx-targetPos)<1){
				obj.style.right=targetPos+"px";

			}
			*/
		}
	//console.log(currentCount);
	}
	,this.timer);
}
function line (obj,speed,currentPos,tarpos) {
	var pos;
	console.log(speed);
	if(currentPos+100<tarpos){
		pos=currentPos+speed;
	}
	pos=(tarpos - currentPos )*speed*0.00001+currentPos;
	obj.style.right=parseInt(pos);
	return pos;
}
function move3 (obj,tarpos,speed) {
	var obj=document.getElementById(obj);
	obj.style.right=parseInt(obj.style.right);
	var flag;
	if(obj.style.right<tarpos){
		 flag=setInterval(,100);
	}
	else clearInterval(flag);
	var flag=setInterval(function (){
	
		} {
		// body...
	}
			
			)
}
