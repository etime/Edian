<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
 
    <script type="text/javascript">
        /*
        t:currentCount 当前执行第t次
        b:initPos 初始值
        c:targetPos - initPos 发生偏移的距离值
        d:count 一共执行d次
        效果：http://www.robertpenner.com/easing/easing_demo.html 
        JavaScript Tween算法及缓动效果 http://www.cnblogs.com/cloudgamer/archive/2009/01/06/tween.html
        */
        var Tween = {
            Linear: function(initPos, targetPos, currentCount, count) {
                var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                return c * t / d + b;
            },
            Quad: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * (t /= d) * t + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return -c * (t /= d) * (t - 2) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if ((t /= d / 2) < 1) return c / 2 * t * t + b;
                    return -c / 2 * ((--t) * (t - 2) - 1) + b;
                }
            },
            Cubic: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * (t /= d) * t * t + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * ((t = t / d - 1) * t * t + 1) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
                    return c / 2 * ((t -= 2) * t * t + 2) + b;
                }
            },
            Quart: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * (t /= d) * t * t * t + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return -c * ((t = t / d - 1) * t * t * t - 1) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
                    return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
                }
            },
            Quint: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * (t /= d) * t * t * t * t + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b;
                    return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
                }
            },
            Sine: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * Math.sin(t / d * (Math.PI / 2)) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
                }
            },
            Expo: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (t == 0) return b;
                    if (t == d) return b + c;
                    if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
                    return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
                }
            },
            Circ: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
                    return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
                }
            },
            Elastic: {
                easeIn: function(initPos, targetPos, currentCount, count, a, p) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (t == 0) return b; if ((t /= d) == 1) return b + c; if (!p) p = d * .3;
                    if (!a || a < Math.abs(c)) { a = c; var s = p / 4; }
                    else var s = p / (2 * Math.PI) * Math.asin(c / a);
                    return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count, a, p) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (t == 0) return b; if ((t /= d) == 1) return b + c; if (!p) p = d * .3;
                    if (!a || a < Math.abs(c)) { a = c; var s = p / 4; }
                    else var s = p / (2 * Math.PI) * Math.asin(c / a);
                    return (a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b);
                },
                easeInOut: function(initPos, targetPos, currentCount, count, a, p) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (t == 0) return b; if ((t /= d / 2) == 2) return b + c; if (!p) p = d * (.3 * 1.5);
                    if (!a || a < Math.abs(c)) { a = c; var s = p / 4; }
                    else var s = p / (2 * Math.PI) * Math.asin(c / a);
                    if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
                    return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
                }
            },
            Back: {
                easeIn: function(initPos, targetPos, currentCount, count, s) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (s == undefined) s = 1.70158;
                    return c * (t /= d) * t * ((s + 1) * t - s) + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count, s) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (s == undefined) s = 1.70158;
                    return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
                },
                easeInOut: function(initPos, targetPos, currentCount, count, s) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (s == undefined) s = 1.70158;
                    if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
                    return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
                }
            },
            Bounce: {
                easeIn: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    return c - Tween.Bounce.easeOut(d - t, 0, c, d) + b;
                },
                easeOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if ((t /= d) < (1 / 2.75)) {
                        return c * (7.5625 * t * t) + b;
                    } else if (t < (2 / 2.75)) {
                        return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
                    } else if (t < (2.5 / 2.75)) {
                        return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
                    } else {
                        return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
                    }
                },
                easeInOut: function(initPos, targetPos, currentCount, count) {
                    var b = initPos, c = targetPos - initPos, t = currentCount, d = count;
                    if (t < d / 2) return Tween.Bounce.easeIn(t * 2, 0, c, d) * .5 + b;
                    else return Tween.Bounce.easeOut(t * 2 - d, 0, c, d) * .5 + c * .5 + b;
                }
            }
        }
 
        ///------------------------------------------------------------------------------------------------------        
        Animation = {
            timer: 10,
            SetOpacity: function(obj, n) {
                if (document.all) {
                    obj.filters.alpha.opacity = n;
                }
                else {
                    obj.style.opacity = n / 100;
                }
            },
            fade: function(obj, target, count, Func) {
                obj = this.getItself(obj);
                var currentCount = 0;
                count = Math.abs(count) || 1;
                target = target < 0 ? 0 : (target > 100) ? 100 : target;
                var init = document.all ? obj.filters.alpha.opacity : window.getComputedStyle(obj, null).opacity * 100;
                Func = Func || Tween.Linear;
                var opr = this;
                var flag = setInterval(function() {
                    if (currentCount > count) {
                        clearInterval(flag);
                    }
                    else {
                        currentCount++;
                        var tmp = Func(init, target, currentCount, count);
                        opr.SetOpacity(obj, tmp);
                        //清除小数点的误差
                        if (Math.abs(tmp - target) < 1) {
                            opr.SetOpacity(obj, target);
                        }
                    }
                }
                , this.timer);
            },
            resize: function(obj, targetPos, count, Func) {
                obj = this.getItself(obj);
                var currentCount = 0;
                count = Math.abs(count) || 1;
                var initPos = { x: obj.offsetWidth, y: obj.offsetHeight }
                Func = Func || Tween.Linear;
                targetPos = { x: targetPos.x < 0 ? 0 : targetPos.x, y: targetPos.y < 0 ? 0 : targetPos.y }
                var flag = setInterval(function() {
                    if (currentCount > count) {
                        clearInterval(flag);
                    }
                    else {
                        currentCount++;
                        var tmpX = Func(initPos.x, targetPos.x, currentCount, count);
                        var tmpY = Func(initPos.y, targetPos.y, currentCount, count);
                        //width值不能小于0，但是算法返回值有可能出现负值
                        try {
                            obj.style.width = tmpX + "px";
                            obj.style.height = tmpY + "px";
                        }
                        catch (e) {
                        }
                        //清除小数点的误差
                        if (Math.abs(tmpX - targetPos.x) < 1) {
                            obj.style.width = targetPos.x + "px";
                        }
                        if (Math.abs(tmpY - targetPos.y) < 1) {
                            obj.style.height = targetPos.y + "px";
                        }
                    }
                }
                , this.timer);
            },
            move: function(obj, targetPos, count, Func) {
                obj = this.getItself(obj);
                var currentCount = 0;
                count = Math.abs(count) || 1;
                var elPos = this.getElementPos(obj);
                var initPos = { x: elPos.x, y: elPos.y }
                Func = Func || Tween.Linear;//这个不是很理解.by unasm
                var flag = setInterval(function() {
                    if (currentCount > count) {
                        clearInterval(flag);
                    }
                    else {
                        currentCount++;
                        var tmpX = Func(initPos.x, targetPos.x, currentCount, count);
                        var tmpY = Func(initPos.y, targetPos.y, currentCount, count);
                        obj.style.left = tmpX + "px";
                        obj.style.top = tmpY + "px";
                        //清除小数点的误差
                        if (Math.abs(tmpX - targetPos.x) < 1) {
                            obj.style.left = targetPos.x + "px";
                        }
                        if (Math.abs(tmpY - targetPos.y) < 1) {
                            obj.style.top = targetPos.y + "px";
                        }
                    }
                }
                , this.timer);
            },
            getElementPos: function(el) {
                el = this.getItself(el);
                var _x = 0, _y = 0;
                do {
                    _x += el.offsetLeft;
                    _y += el.offsetTop;
                } while (el = el.offsetParent);
			return { x: _x, y: _y };
            },
            getItself: function(id) {
                return "string" == typeof id ? document.getElementById(id) : id;
            }
        }
    </script>
 
    <style type="text/css">
        .div
        {
            position: absolute;
            border: solid 1px #849BCA;
            left: 50px;
            top: 100px;
            width: 160px;
            height: 130px;
            background-color: #DBE4ED;
            white-space: nowrap;
            overflow: hidden;
            opacity: 1; 
            filter: alpha(opacity=100);
        }
    </style>
</head>
<body>
    <input type="button" value="Move" onclick="Animation.move('divObj',{x:500,y:500},100,Tween.Quart.easeInOut);" />
    <input type="button" value="Resize" onclick="Animation.resize('divObj',{x:50,y:50},100,Tween.Cubic.easeIn);" />
    <input type="button" value="SetOpacity" onclick="Animation.fade('divObj',50,100);" />
    <input type="button" value="Move&Resize" onclick="Animation.resize('divObj',{x:300,y:200},100);Animation.move('divObj',{x:300,y:300},100);" />
    <input type="button" value="Move&Resize&SetOpacity" onclick="Animation.fade('divObj',50,100);Animation.resize('divObj',{x:300,y:200},100);Animation.move('divObj',{x:100,y:100},100);" />
    <input type="button" value="Reset" onclick="javascript:window.location.reload();" />
    <div id="divObj" class="div" style="">
        <div style="border: solid 1px green; width: 70px;">
            ~_~ ----></div>
        <input type="text" value="input" style="width: 50px;" /><br />
        <input type="button" value="button" /><br />
        <img src="http://images.cnblogs.com/logo_small.gif" alt="" />
    </div>
</body>
</html>

