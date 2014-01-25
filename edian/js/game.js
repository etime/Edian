/**
 * @name        ../../js/game.js
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-25 10:44:40
*/
window.onload = function () {
    document.getElementById('bton').addEventListener("click" , game);
    // 规定了色子面积的大小
    var radius = 2;
    // 色子的高度和宽度 ,间距
    var wl = 40 , padding = 10;
    var ctx = document.getElementById('canvas').getContext('2d');
    function game() {
        drawRect( padding , padding , 1);
        drawRect( 2 * padding + wl,padding , 2);
        drawRect( 3 * padding + wl * 2 , padding , 3);
        drawRect( 4 * padding + wl * 3 , padding , 4);
        drawRect( 5 * padding + wl * 4 , padding , 5);
        drawRect( padding , 2 * padding + wl , 6);
    };
    function fill() {
        ctx.beginPath();
        ctx.fillStyle  = 'rgb(200,100,200)';
        ctx.fillRect(50,50,100,50);
        ctx.strokeStyle = 'rgb(255, 100 , 100)';
        ctx.closePath();
    }
    function drawRect(stx , sty , num) {
        ctx.lineWidth = 1;
        ctx.strokeStyle = 'rgb(2, 0 , 0)';
        ctx.strokeRect(stx ,  sty , wl , wl);
        //drawPoint( 100 , 100);
        function draw1() {
            drawPoint(stx + wl / 2 , sty + wl / 2 , 2);
        }
        switch (num) {
            case 1:
                drawPoint(stx + wl / 2 , sty + wl / 2 , 2);
                break;
            case 2:
                drawPoint(stx + wl / 2 , sty + wl / 3);
                drawPoint(stx + wl / 2 , sty + wl * 2 / 3);
                break;
            case 3:
                drawPoint(stx + wl / 2 , sty + wl / 3);
                drawPoint(stx + wl / 3 , sty + wl * 2 / 3);
                drawPoint(stx + wl / 3 * 2 , sty + wl * 2 / 3);
                break;
            case 4:
                drawPoint(stx + wl / 3 , sty + wl / 3);
                drawPoint(stx + wl / 3 , sty + wl * 2 / 3);
                drawPoint(stx + wl / 3 * 2 , sty + wl / 3);
                drawPoint(stx + wl / 3 * 2 , sty + wl * 2 / 3);
            break;
            case 5:
                drawPoint(stx + wl / 3 , sty + wl / 3);
                drawPoint(stx + wl / 3 , sty + wl * 2 / 3);
                drawPoint(stx + wl / 3 * 2 , sty + wl / 3);
                drawPoint(stx + wl / 3 * 2 , sty + wl * 2 / 3);
                drawPoint(stx + wl / 2 , sty + wl / 2);
            break;
            case 6:
                drawPoint(stx + wl / 3 , sty + wl / 3);
                drawPoint(stx + wl / 3 , sty + wl * 2 / 3);
                drawPoint(stx + wl / 3 , sty + wl / 2);
                drawPoint(stx + wl / 3 * 2 , sty + wl * 2 / 3);
                drawPoint(stx + wl / 3 * 2 , sty + wl / 2);
                drawPoint(stx + wl / 3 * 2 , sty + wl / 3);
            break;
            default:
                console.log("now");
        }
    }
    function drawPoint(centX,centY , bei ) {
        if(bei === undefined)
            bei = 1;
        ctx.fillStyle  = 'rgb(255 , 0,0)';
        ctx.arc(centX, centY , radius * bei ,2 * Math.PI, 0,true);
        ctx.fill();
        ctx.closePath();
    }
    //drawRect();
    game();
}
