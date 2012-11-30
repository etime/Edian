<!DOCTYPE html>
<!--[if lt IE 7]><html lang="en" class="ie6"><![endif]--> 
<!--[if IE 7]><html lang="en" class="ie7"><![endif]--> 
<!--[if IE 8]><html lang="en" class="ie8"><![endif]--> 
<!--[if IE 9]><html lang="en" class="ie9"><![endif]--> 
<!--[if gt IE 9]><html lang="en"><![endif]-->
<!--[if !IE]>--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Stunning CSS3</title>
<style>
body {
	margin: 0;
	padding: 40px;
	background: url("../../bgimage/leftdir-main.gif");
	font-family: "Segoe UI", Segoe, Calibri, Arial, sans-serif;
}
ol {
	margin: 0;
	padding: 0;
	list-style: none;
}
.comment {
	float: left; /* float containment */
	width: 100%;
	margin: 0 0 20px 0;
}
.comment-meta {
	float: left;
	width: 100px;
	font-size: 84%;
	text-align: right;
	text-shadow: 1px 1px 0 hsla(0,0%,100%,.7);
}
.comment-meta img {
	-moz-transform: rotate(-5deg);
	-o-transform: rotate(-5deg);
	-webkit-transform: rotate(-5deg);
	transform: rotate(-5deg);
}
.ie8 .comment-meta img {
	-ms-filter: "progid:DXImageTransform.Microsoft.Matrix(SizingMethod='auto expand', M11=0.9961946980917455, M12=0.08715574274765817, M21=-0.08715574274765817, M22=0.9961946980917455)";
	position: relative;
	top: -5px;
	left: -5px;
}
h4 {
	margin: 0;
	font-size: 100%;
	font-weight: normal;
	line-height: 1;
}
.comment-meta span {
	font-size: 84%;
	color: #666;
}
blockquote p {
	margin: 0;
	padding: 0 0 10px 0;
}
blockquote {
	position: relative;
	min-height: 42px;
	margin: 0 0 0 112px;
	padding: 10px 15px 5px 15px;
	-moz-border-radius: 20px;
	-webkit-border-radius: 20px; /* Safari 4 and earlier */
	border-radius: 20px; /* Opera, Chrome, Safari 5, IE 9 */
	border-top: 1px solid #fff;
	background-color: hsla(282,54%,06%,.6);
/*
	background-color:		#C7C7E2;
*/
	background-image: -moz-linear-gradient(hsla(0,0%,100%,.6), hsla(0,0%,100%,0) 30px);
	background-image: -webkit-gradient(linear, 0 0, 0 30, from(hsla(0,0%,100%,.6)), to(hsla(0,0%,100%,0)));
/*
	background-image: -webkit-gradient(linear, 0 0, 0 30, from(#5B5B5B), to(	#E0E0E0));
*/
	-moz-box-shadow: 1px 1px 2px hsla(0,0%,0%,.3);
/*
	-webkit-box-shadow: 1px 1px 2px hsla(0,0%,0%,.8);
	box-shadow: 1px 1px 2px hsla(0,0%,0%,.3);
*/ /* Opera, IE 9 */
	word-wrap: break-word;
}
/*
.ie6 blockquote, .ie7 blockquote {  IE 5.5, 6, 7 
	background: none;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99E3F4EE, endColorstr=#99A6DADC);
	zoom: 1;
}
*/
.ie8 blockquote {
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99E3F4EE, endColorstr=#99A6DADC)";
}
blockquote:after {
	content: "\00a0"; /* &nbsp; */
	display: block;
	position: absolute;
	top: 19px;
	left: -20px; /* width of right border */
	width: 0;
	height: 0;
	border-width: 10px 20px 16px 0;
	border-style: solid;
/*
	border-color: transparent hsla(182,44%,76%,.5) transparent transparent;
*/
	border-color: hsla(193,22%,12%,0.3) #81C0C0 transparent transparent;
}
blockquote:hover {
	top: -2px;
	left: -2px;
/*
	-moz-box-shadow: 3px 3px 2px hsla(0,0%,0%,.3);
	-webkit-box-shadow: 3px 3px 2px hsla(0,0%,0%,.3);
*/
/*
	box-shadow: 3px 3px 2px hsla(0,0%,0%,.3); 
*/
	box-shadow: 3px 3px 2px		#8E8E8E; 
/*
	text-shadow: 1px 1px 1px hsla(0,0%,100%,.7); */
/* FF, Opera, Safari, Chrome */

}
</style>
</head>

<body>
<ol>
    <li class="comment">
      <div class="comment-meta">
          <img src="images/zoe.jpg" width="80" height="80" alt="">
        <h4>Zoe Gillenwater</h4>
          <span>February 28, 2010</span>
      </div>
        <blockquote>
          <p>Thanks for posting this article. Lots of good info. The only thing I still don't really understand is why these blog comments are so plain. Why don't you apply some CSS3 and jazz them up?</p>
        </blockquote>
    </li>
    <li class="comment">
        <div class="comment-meta">
            <img src="images/cary.jpg" width="80" height="80" alt="">
            <h4>Cary Gillenwater</h4>
            <span>March 1, 2010</span>
      </div>
        <blockquote>
          <p>I agree with Zoe. Make it cooler looking.</p>
        </blockquote>
    </li>
    <li class="comment">
        <div class="comment-meta">
            <img src="images/faith.jpg" width="80" height="80" alt="">
            <h4>Faith Mickley</h4>
            <span>March 1, 2010</span>
      </div>
        <blockquote>
          <p>This is one of my favorite posts so far. Thanks so much for posting it. I agree 100%.</p>
          <p>Zoe and Cary, I think the comment area is going to look great by the end of the chapter. Just wait and see!</p>
        </blockquote>
    </li>
    <li class="comment">
        <div class="comment-meta">
            <img src="images/asha.jpg" width="80" height="80" alt="">
          <h4>Asha Gillenwater</h4>
            <span>March 10, 2010</span>
        </div>
        <blockquote>
          <p>I really enjoy reading your blog, but what happens when I put a long URL in my comment text, like this one: http://forabeautifulweb.com/blog/about/what_does_browser_testing_mean_today/</p>
        </blockquote>
    </li>
</ol>
</body>
</html>

