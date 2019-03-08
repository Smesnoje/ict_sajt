$(document).ready(function () {
    if(localStorage.getItem("voted")=="true"){
        getVote(3);


    }
    
  });
function getVote(int) {
    
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("poll").innerHTML=this.responseText;
        ifVoted=this.responseText;
      }
    }
    xmlhttp.open("GET","poll_vote.php?vote="+int,true);
    xmlhttp.send();
    localStorage.setItem("voted", "true");
  }