var x =10;
var timerdiv = document.querySelector('#timer_div');
function timer(){
  timerdiv.innerHTML = x;
  if((x-1)>0){
    setTimeout(function(){timer();},1000);
  }else{
    window.location.href = 'http://localhost';
  }
  x--;
}
timer();