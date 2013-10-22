function test() {
    this.key = 100;
    this.value = function (){
	    this.key = 0;
        console.log("11");
    }
    this.show = function(){
        console.log(this.key);
    }
}
$(document).ready(function(){
    var test1 = new test();
    console.log(test1.show());
    console.log(test1.value());
});
