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
<!--[if IE 6]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script><![endif]-->
<style type="text/css">
@font-face {
	font-family: 'Prelude';
	src: url('fonts/preludeflf-webfont.eot');
	src: local('☺'), url('fonts/preludeflf-webfont.woff') format('woff'), url('fonts/preludeflf-webfont.ttf') format('truetype'), url('fonts/preludeflf-webfont.svg#webfont') format('svg');
}
@font-face {
	font-family: 'Prelude';
	src: url('fonts/preludeflf-bold-webfont.eot');
	src: local('☺'), url('fonts/preludeflf-bold-webfont.woff') format('woff'), url('fonts/preludeflf-bold-webfont.ttf') format('truetype'), url('fonts/preludeflf-bold-webfont.svg#webfont') format('svg');
	font-weight: bold;
}
body {
	margin: 0;
	padding: 0;
	background: #CCC url(images/background.gif);
	color: #333;
	font-size: 87.5%;
	font-family: Georgia, "Times New Roman", Times, serif;
	line-height: 1.6;
}
#paper {
	float: left; /* float containment */
	min-width: 600px;
	max-width: 80em;
	padding: 3.2em 1.6em 1.6em 1.6em;
	margin: 40px;
	border-width: 0 0 0 50px; 
	-moz-border-image: url(images/edge.png) 0 0 0 50 round; 
	-o-border-image: url(images/edge.png) 0 0 0 50 round; 
	-webkit-border-image: url(images/edge.png) 0 0 0 50 round; 
	border-image: url(images/edge.png) 0 0 0 50 round;
	background: url(images/paperlines.gif) #FBFBF9;
 	/* IE, old FF */
	background: url(images/thumbtack.png) 50% 5px no-repeat, url(images/stains1.png) 90% -20px no-repeat, url(images/stains2.png) 30% 8% no-repeat, url(images/stains3.png) 20% 50% no-repeat, url(images/stains4.png) 40% 60% no-repeat, url(images/paperlines.gif) #FBFBF9;
	-moz-background-size: auto, auto, auto, auto, auto, auto 1.6em;
	-webkit-background-size: auto, auto, auto, auto, auto, auto 1.6em;
	background-size: auto, auto, auto, auto, auto, auto 1.6em; /* Chrome, Opera 10.5 */
	-moz-background-clip: padding;
	-webkit-background-clip: padding-box;
	background-clip: padding-box; /* Chrome, Opera 10.5 */
	-moz-box-shadow: 6px 5px 3px hsla(0,0%,0%,.2);
	-webkit-box-shadow: 6px 5px 3px hsla(0,0%,0%,.2);
	box-shadow: 6px 5px 3px hsla(0,0%,0%,.2);
}
h1 {
	margin: -.3em 0 .14em 0;
	color: #414141;
	font-family: Prelude, Helvetica, "Helvetica Neue", Arial, sans-serif;
	font-size: 3.5em;
	font-weight: normal;
}
h2 {
	clear: left;
	margin: 0 0 -.14em 0;
	color: #414141;
	font-family: Prelude, Helvetica, "Helvetica Neue", Arial, sans-serif;
	font-size: 2.17em;
	font-weight: bold;
}
h3 {
	float: left;
	margin: .3em 0 0 0;
	font-size: .8em;
	font-weight: normal;
	text-transform: uppercase;
	letter-spacing: 2px;
}
p {
	margin: 0 0 1.6em 0;
}
ul {
	overflow: hidden; /* float containment */
	margin: 0 0 1.6em 0;
	padding: 0;
	list-style: none;
}
li {
	float: left;
	margin: 0;
	padding: 0 0 0 1em;
}
a {
	color: #146DA3;
}
ul a[href] {
	display: block;
	min-height: 15px;
	padding-left: 20px;
	background-repeat: no-repeat;
	background-position: 0 3px;
}
.ie6 ul a[href] {
	display: inline-block;
	white-space: nowrap;
}
a[href$=".pdf"] {
	background-image: url(images/icon_pdf.png);
}
a[href$=".doc"] {
	background-image: url(images/icon_doc.png);
}
a[href$=".mov"] {
	background-image: url(images/icon_film.png);
}
a[href$=".jpg"] {
		background-image: url(images/icon_photo.png);
}
img {
	float: right;
	margin: 0 0 10px 20px;
	border: 1px solid #ccc;
}
img[src*=thumbnails] {
	float: left;
	margin: 0 20px 10px 0;
}
img[src*=photos] {
	padding: 5px 5px 30px 5px;
	background: #fff;
	-moz-box-shadow: 3px 6px 8px -4px #999;
	-webkit-box-shadow: 3px 6px 8px -4px #999;
	box-shadow: 3px 6px 8px -4px #999;
	-moz-transform: rotate(2deg);
	-o-transform: rotate(2deg);
	-webkit-transform: rotate(2deg);
	transform: rotate(2deg);
}
</style>
</head>

<body>
<div id="paper">
	<h1></h1>
  <h1>hi! my dear girl<a href="./ci/index.php">主页</a></h1>
    	<p> 当你看到这个的时候，很感谢你的光临，这个是我的第一个放到网上的网页，</p>
    <h2>Itinerary</h2>
    <img src="thumbnails/map.png" width="100" height="100" alt="">
    <p>The trip began on May 19, 2007, when we flew into the Manchester airport. We flew back home from London on June 3. We rented a car for the entire non-London portion of our trip, so we were able to explore around quite a bit. You can download the documents listed below to get an overview of where we went and what we did each day.</p>
    <h3>Download:</h3>
    <ul>
        <li><a href="documents/itinerary.pdf">Itinerary (PDF)</a></li>
        <li><a href="documents/itinerary.doc">Itinerary (Word)</a></li>
        <li><a href="documents/map.pdf">Map of trip locations (PDF)</a></li>
    </ul>
    <h2>Derbyshire</h2>
    <img src="photos/derbyshire.jpg" width="320" height="214" alt="">
    <p>We visited Derbyshire on the first three days of our trip. We stayed at a B&amp;B called <a href="www.bassettwoodfarm.co.uk">Bassett Wood Farm</a> in the little village of Tissington, where the annual <a href="http://en.wikipedia.org/wiki/Well_dressing">well dressing</a> happened to be occuring at the same time. The landscape of Derbyshire was gorgeous; I can see why Elizabeth Bennet was so impressed. My highlights were visiting the two houses used for Pemberley in the Pride &amp; Prejudice mini-series. I even got to see the little pond where Colin Firth's famous wet shirt scene occurs.</p>
    <h3>Download:</h3>
    <ul>
        <li><a href="video/cary.mov">Cary riding a horse for the first time (MOV)</a></li>
        <li><a href="photos/lymepark.jpg">Zoe at Lyme Park</a></li>
        <li><a href="photos/dovedale.jpg">Cary and Zoe in Dovedale Valley</a></li>
        <li><a href="photos/sudburyhall.jpg">Zoe at Sudbury Hall</a></li>
    </ul>
    <h2>Cotswolds</h2>
    <img src="photos/cotswolds.jpg" width="320" height="240" alt="">
    <p>The next seven days were spent traveling all around the Cotswolds and the surrounding area. We stayed at a cottage in the famously picturesque village of Bibury. We explored more than a dozen other Cotswolds villages.</p>
    <p>One of our favorite towns in the Cotswolds was Cirencester, because of the great food we had there and the <a href="http://www.cirencester.co.uk/coriniummuseum/">Corinium Museum</a>. The collection of Roman (and earlier) artifacts at the museum was much larger than we expected and quite fascinating.</p>
    <p>The more ancient something is, the better Cary loves it, especially if it's all in ruins. So, Cary's highlights in the Cotswolds were not just the Roman museum but also the unearthed <a href="http://www.chedworthromanvilla.com/">Chedworth Roman Villa</a> and the ruins of Minster Lovell Hall. One of our favorite memories from the area was our wet, cold trek to the Belas Knap burial mound, built around 2500 BC. Drying out and warming up in the pub afterwards was lovely, and the whole thing was just so English.</p>
    <h3>Download:</h3>
    <ul>
        <li><a href="photos/sheep.jpg">Zoe and Cary in a field of sheep</a></li>
        <li><a href="photos/bibury.jpg">Zoe in Bibury</a></li>
        <li><a href="photos/ruins.jpg">Cary at Minster Lovell Hall</a></li>
    </ul>
    <h2>Day-trips from the Cotswolds</h2>
    <img src="photos/chepstow.jpg" width="320" height="240" alt="">
    <p>While staying in Bibury, we took a couple trips out of the Cotswolds proper.</p>
    <p>One day-trip was to Bath to see the Jane Austen sites and, of course, the <a href="http://www.romanbaths.co.uk/">Roman Baths</a> (which are also Jane Austen related, incidentally). On the way back from Bath, we stopped at the village of Lacock, which was used for Meryton in the Pride &amp; Prejudice mini-series (along with a bunch of other movies).</p>
    <p>Another day-trip took us into Wales to see the ruins of Chepstow Castle. This was one of Cary's highlights during the trip. It was very large and quite impressive. On the way to Wales, we successfully hunted down the private home used for Longbourne House in Pride &amp; Prejudice.</p>
    <h3>Download:</h3>
    <ul>
        <li><a href="photos/baths.jpg">The Roman Baths</a></li>
        <li><a href="photos/chepstow.jpg">Cary at Chepstow Castle</a></li>
        <li><a href="photos/longbourne.jpg">Zoe at "Longbourne House"</a></li>
    </ul>
    <h2>Winchester and Surrounding Area</h2>
    <img src="photos/stonehenge.jpg" width="320" height="427" alt="">
    <p>We finally had to say goodbye to our cute cottage in Bibury and moved on to Winchester, where we spent two days. On the way, we saw the annual Gloucestershire <a href="http://www.cheese-rolling.co.uk/">cheese-rolling</a>, which was one of our highlights of not only this trip, but all the trips I've ever taken. So bizarrely fun.</p>
    <p>Winchester was a cool town that I'd love to spend more time in. The Cathedral was beautiful, and it was so interesting to see its mixture of architectural styles that happened as it was built up over the centuries. I visited Jane Austen's grave in the Cathedral, of course, and cried outside the house where she died. Yes, I love Jane Austen that much.</p>
    <p>While staying in Winchester, we took a short jaunt down to the New Forest to see the wild ponies. I am still a 12-year-old girl when it comes to horses, and standing in a field among wild ponies, a good portion of which were adorable little foals, made me giddy. That same day, Cary was giddy with excitement at getting to not only see Stonehenge but walk among it and touch the stones. You have to pay extra for this and reserve it way in advance, but it's so worth it. Everyone was so excited to be there, that even if you didn't care much about Stonehenge (like me), it was impossible to not get caught up in the excited happiness.</p>
    <p>We visisted Chawton Cottage, where Jane Austen lived for many years and wrote most of her novels, on our way out of Winchester and up to London. It was amazing to touch the table she wrote on (which was against the rules, but I promise I didn't hurt it). We also stopped by the village where she was born and grew up; we visited the little church where she was baptized and her father was rector for many years.</p>
    <h3>Download:</h3>
    <ul>
        <li><a href="video/cheeserolling.mov">Cheese rolling (MOV)</a></li>
        <li><a href="photos/janeausten.jpg">Zoe at Jane Austen's grave</a></li>
        <li><a href="video/ponies.mov">Wild ponies (MOV)</a></li>
        <li><a href="photos/stonehenge.jpg">Cary fixing Stonehenge</a></li>
    </ul>
    <h2>London</h2>
    <img src="photos/london.jpg" width="320" height="240" alt="">
    <p>We spent our last three days in London in a cool apartment in Lambeth. We saw some of the main attractions, but there's no way to squeeze them all in in three days&#8212;at least not enjoyably. We had a great time at the Tower of London. The British Museum was amazing, but we didn't have nearly enough time there. Cary particularly enjoyed the Cabinet War Rooms and Museum. We saw Les Miserables as well as Othello at the Globe, and we ate great food.</p>
    <p>The Jane Austen fun wasn't done yet though! We saw her writing desk and some of her writings at the British Library, and in the Naitonal Portrait Gallery we saw the only known portrait of her.</p>
    <p>Our last full day in England, June 2, was our wedding anniversary. We had a lovely dinner  at a Turkish restaurant called <a href="http://www.tasrestaurant.com/ev_restaurant/index.htm">Ev</a>, sitting out on their lovely plant-decked patio on a mild summer evening.</p>
    <h3>Download:</h3>
    <ul>
        <li><a href="photos/parliament.jpg">Parliament and Big Ben</a></li>
        <li><a href="photos/stjames.jpg">Zoe in St. James Gardens</a></li>
        <li><a href="video/trafalgar.mov">Cary in Trafalgar Square (MOV)</a></li>
    </ul>
</div>
</body>
</html>