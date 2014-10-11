function popoutfunction()
{
$(document).ready(function() {
				$(".inline").colorbox({inline:true, innerWidth:800, innerHeight:500 });
	});

}
// --------------------------------Filter latest news-----------------------------------------------
filter("latest");

function filter(value) {
if(value=='latest')
{
var doc=new XMLHttpRequest();
doc.open("GET","latest.php?id="+value,true);
doc.onreadystatechange=function(){
if (doc.readyState==4 && doc.status==200){
	document.getElementById('list').innerHTML="<div id=latest>Latest News</div><hr /><div id=page><br></div><div id=fill></div>";
	document.getElementById("fill").innerHTML=doc.responseText;}
	popoutfunction();
	}
	doc.send();}

else
{
var doc=new XMLHttpRequest();
doc.open("GET","latest.php?id="+value,true);
doc.onreadystatechange=function(){
if (doc.readyState==4 && doc.status==200){
	document.getElementById("fill").innerHTML=doc.responseText;}
	popoutfunction();
	}
	doc.send();
}
}


//---------------------------------------------------------------------------------------------------


//---------------------------------Showing full story for single news (without search)---------------------
function singlenews(str)
{

var che=new XMLHttpRequest();
che.open("GET","singlenews.php?id="+str,true);
che.onreadystatechange=function(){
if (che.readyState==4 && che.status==200){
	document.getElementById("list").innerHTML=che.responseText;}
	popoutfunction();
	}
	che.send();
}
//-------------------------------------------------------------------------------------------------------


//------------------------------------Showing full story for single news (with search)------------------------
function singlenewsforsearch(str)
{
var che=new XMLHttpRequest();
che.open("GET","singlenewsforsearch.php?id="+str,true);
che.onreadystatechange=function(){
if (che.readyState==4 && che.status==200){
	document.getElementById("list").innerHTML=che.responseText;}
	popoutfunction();
	}
	che.send();
}
//-------------------------------------------------------------------------------------------------------------

//-------------------------------------------Sort by news------------------------------------------------------


function news()
{
var che=new XMLHttpRequest();
value=1;
che.open("GET","sortbynews.php?id="+value,true);
che.onreadystatechange=function(){
if (che.readyState==4 && che.status==200){
	document.getElementById('list').innerHTML="<div id=latest>News</div><hr /><div id=page><br></div><div id=fill></div>";
	document.getElementById("fill").innerHTML=che.responseText;}
	popoutfunction();
	}
	che.send();
}



function indinews(val)
{
value=val.split(',');

var doc=new XMLHttpRequest();
doc.open("GET","sortbynews.php?id="+value[0],true);
doc.onreadystatechange=function(){
if (doc.readyState==4 && doc.status==200){
	document.getElementById('list').innerHTML="<div id=latest><a href='#' onclick='news();'>News</a>> "+value[1]+"</div><hr /><div id=page><br></div><div id=fill></div>";
	document.getElementById("fill").innerHTML=doc.responseText;}
	popoutfunction();
	}
	doc.send();
}
//---------------------------------------------------------------------------------------------------------------



function aboutus()
{
string="<p>Dear all user,</p> <p>I am Xu Shiyang from the school of Computer Engineering, majoring in Computer Science. I am currently at my fourth year of studies and my project title for my Final year project (FYP) is called 'Broadcast News Navigation'.</p> <p>I hope you will enjoy using the navigator, and learn something out of it :)</p> "
document.getElementById('list').innerHTML="<div id=latest>About Us</div><hr /><div id=page><br></div><div id=fill></div>";
document.getElementById("fill").innerHTML=string;
}


//---------------------------------radio button for search by keyword and search by story---------------------------
function getRadioValue()
{
    for (var i = 0; i < document.getElementsByName('stor').length; i++)
    {
    	if (document.getElementsByName('stor')[i].checked)
    	{
    		return document.getElementsByName('stor')[i].value;
    	}
    }
}

//------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------Keyword search--------------------------------------------------------------

function keysearch(str){
var mov=new XMLHttpRequest();
mov.open("GET","search.php?id="+str,true);
mov.onreadystatechange=function(){
if (mov.readyState==4 && mov.status==200){
	numberofnews=mov.responseText;
	numberofpages=Math.ceil(numberofnews/5);
	stringoftext="<div id=searchlist>Search Results</div><hr /><div id=page>";

	for (var x=1; x<=numberofpages; x++)
	{	fulltext='"'+x+','+str+'"';
		stringoftext=stringoftext+"<a id="+x+" class='number' href='#'  onClick='showResult("+fulltext+"); bold("+x+"); return false;'>"+x+"</a>";
		if(x!=numberofpages)
			stringoftext=stringoftext+",";
		
	}
	if(numberofpages!=0)
		stringoftext=stringoftext+'</div>';
	else
		stringoftext=stringoftext+'<br></div>';
	showResult(1+","+str);

	document.getElementById("list").innerHTML=stringoftext+"<div id=fill></div>"
	bold(1);}
	};

mov.send();

}

function showResult(str){
	var mov=new XMLHttpRequest();
	mov.open("GET","searchResults.php?id="+str,true);
	mov.onreadystatechange=function(){
	if (mov.readyState==4 && mov.status==200){
		document.getElementById("fill").innerHTML=mov.responseText;}
		popoutfunction();
		}
mov.send();} 


//--------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------bold the number in red--------------------------------------------------------------------
function bold(number)
{
	$(".number").each(function() {
	$(this).css('color','white');
	});
	$('#'+number).css('color','red');

}
//-------------------------------------------------------------------------------------------------------------------------

//----------------------------------------------Need to find out the total number of page for topics---------------------------------------------------
function topicpage(str)
{
fulltext='';
var mov=new XMLHttpRequest();
mov.open("GET","topicpage.php?id="+str,true);
mov.onreadystatechange=function(){
if (mov.readyState==4 && mov.status==200){
	numberofnews=mov.responseText;
	numberofpages=Math.ceil(numberofnews/10);
	stringoftext="<div id=topiclist>Topics</div><hr /><div id=page>";

	for (var x=1; x<=numberofpages; x++)
	{	fulltext='"'+x+'~'+str+'"';
		stringoftext=stringoftext+"<a id="+x+" class='number'; href='#' onClick='filter("+fulltext+"); bold("+x+"); return false;'>"+x+"</a>";
		if(x!=numberofpages)
			stringoftext=stringoftext+",";

	}
	if(numberofpages!=0)
		stringoftext=stringoftext+'</div>';
	else
		stringoftext=stringoftext+'<br></div>';
	filter(1+"~"+str);
	document.getElementById("list").innerHTML=stringoftext+"<div id=fill></div>"
	bold(1);}
	};

mov.send();
}
//---------------------------------------------------------------------------------------------------------------------------------------------------


//--------------------------------------------------------The topic checkbox list-----------------------------------------------------------------
function topicbar()
{
	var topicList='';
	var topiclist;
	var chks=document.getElementsByName('chek[]')
	for (var i=0; i<chks.length; i++)
	{
		if(chks[i].checked)
			topicList=topicList+chks[i].value+",";
	}
	topiclist=topicList.substring(0,topicList.length-1);
	if(topiclist=='')
		topiclist='topic';
	topicpage(topiclist);
}
//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------put script on name------------------------------------------------------------------------


