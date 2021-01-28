function checkDetSignup(){
if(document.getElementById("name").value == "" || document.getElementById("mail").value == "" || document.getElementById("pswd").value == "")
{alert("Fill all details!!");return false;}
else if(! ValidateEmail(document.getElementById("mail").value)){alert("Invalid email address!!");return false;}
else if(document.getElementById("name").value.includes("#")){alert("# not allowed in name");return false;}
else if(document.getElementById("pswd").value.length<8){alert("Use a stronger password");return false;}
else if(document.getElementById("pswd").value != document.getElementById("cpwd").value){alert("Password missmatch");return false;}
}

function checkDetSignin(){
if(document.getElementById("mail").value == "" || document.getElementById("pswd").value == ""){alert("Fill all details!!");return false;}
else if(! ValidateEmail(document.getElementById("mail").value)){alert("Invalid email address!!");return false;}
}


function ValidateEmail(mail)
{
 if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail))
  {
    return (true)
  }
    return (false)
}

function pswdView()
{
if(document.getElementById('pswd').type == 'text'){
document.getElementById('pswd').type = 'password';
document.getElementById('eyeP').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19.604 2.562l-3.346 3.137c-1.27-.428-2.686-.699-4.243-.699-7.569 0-12.015 6.551-12.015 6.551s1.928 2.951 5.146 5.138l-2.911 2.909 1.414 1.414 17.37-17.035-1.415-1.415zm-6.016 5.779c-3.288-1.453-6.681 1.908-5.265 5.206l-1.726 1.707c-1.814-1.16-3.225-2.65-4.06-3.66 1.493-1.648 4.817-4.594 9.478-4.594.927 0 1.796.119 2.61.315l-1.037 1.026zm-2.883 7.431l5.09-4.993c1.017 3.111-2.003 6.067-5.09 4.993zm13.295-4.221s-4.252 7.449-11.985 7.449c-1.379 0-2.662-.291-3.851-.737l1.614-1.583c.715.193 1.458.32 2.237.32 4.791 0 8.104-3.527 9.504-5.364-.729-.822-1.956-1.99-3.587-2.952l1.489-1.46c2.982 1.9 4.579 4.327 4.579 4.327z"/></svg>';
}
else{
document.getElementById('pswd').type = 'text';document.getElementById('eyeP').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.015 7c4.751 0 8.063 3.012 9.504 4.636-1.401 1.837-4.713 5.364-9.504 5.364-4.42 0-7.93-3.536-9.478-5.407 1.493-1.647 4.817-4.593 9.478-4.593zm0-2c-7.569 0-12.015 6.551-12.015 6.551s4.835 7.449 12.015 7.449c7.733 0 11.985-7.449 11.985-7.449s-4.291-6.551-11.985-6.551zm-.015 3c-2.209 0-4 1.792-4 4 0 2.209 1.791 4 4 4s4-1.791 4-4c0-2.208-1.791-4-4-4z"/></svg>';
}
}

function lgout()
{
if(confirm("Are you sure you wanna logout?"))
{
document.cookie = "userID=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
location.replace("index.php");
}
}


function checkSearch(){
if(document.getElementById("srchQ").value==""){return false}
}

function saveDet(){
if(document.getElementById("name").value == "" || document.getElementById("mail").value == "")
{alert("Name or email can't be blank");return false;}
else if(! ValidateEmail(document.getElementById("mail").value)){alert("Invalid email address!!");return false;}
else if(document.getElementById("name").value.includes("#")){alert("# not allowed in name");return false;}
}

function updtPswd(){
if(document.getElementById("mpwd").value == ""){alert("Please fill the current password");return false;}
else if(document.getElementById("pswd").value == ""){alert("Password can't be blank");return false;}
else if(document.getElementById("pswd").value.length < 8){alert("Password can't be smaller than 8 characters");return false;}
else if(document.getElementById("pswd").value != document.getElementById("cpwd").value){alert("New password mismatch");return false;}
}

function rmvLast(n,str){
for(i=0;i<n;i++){
str = str.substring(0, str.length-1) + str.substring(str.length-1 + 1);
}
return str;
}

try{var msgsBox = document.getElementById("chatWin").innerHTML;}
catch{}
function prntMsg(msg,tsk){
if(msg.replace(" ","") != "")
{
msgsBox = document.getElementById("chatWin").innerHTML = rmvLast(8,msgsBox) + '<p class="'+tsk+'">'+msg+'</p><br><br>'
window.scrollTo(0,document.body.scrollHeight);
}
}

function sendMsg(from,to,msg)
{
$.post("chatWorker.php", {"from": from,"to":to,"msg":msg}, function(data){prntMsg(data,"send")});
}

function rtrnLast(lst){
if(lst != undefined){last = lst;}
}
function recvMsg(from,to,last)
{
var data;
$.post("chatWorker.php", {"from": from,"to":to,"last":last,"recv":""}, function(data){
try{data=JSON.parse(data);}catch{data=" ";}
prntMsg(data[0],"recv");
rtrnLast(data[1]);
});
}
