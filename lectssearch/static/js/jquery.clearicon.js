function tog(v){return v?'addClass':'removeClass';} 

$(document).on('input', '.clearable', function() {
    $(this)[tog(this.value)]('x');
}).on('mousemove', '.x', function(e) {
    $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');
    //console.log("MOUSE MOVE");   
}).on('click', '.onX', function(){
    $(this).removeClass('x onX').val('').change();
    localStorage.removeItem("input");
	//localStorage.removeItem("keyword");
	//localStorage.removeItem("cDB");
});