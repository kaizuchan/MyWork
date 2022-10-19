'use strict';
{
  const open = document.getElementById('open');
  const yesClose = document.getElementById('yesClose');
  const noClose = document.getElementById('noClose');
  const modal = document.getElementById('modal');
  const mask = document.getElementById('mask');

  open.addEventListener('click', function () {
    modal.classList.remove('hidden');
    mask.classList.remove('hidden');
  });
  yesClose.addEventListener('click', function () {
    modal.classList.add('hidden');
    mask.classList.add('hidden');
  });  
  noClose.addEventListener('click', function () {
    modal.classList.add('hidden');
    mask.classList.add('hidden');
  });
  mask.addEventListener('click', function () {
    modal.classList.add('hidden');
    mask.classList.add('hidden');
  });
}

function myCheck() {
  var checkbox = document.getElementsByClassName('check');
  var username = document.getElementsByClassName('uName');
  var userinfo = document.getElementsByClassName('userInfo');
  var deleteList = document.getElementsByClassName('deleteList');

  for (var i = 0; i < checkbox.length; i++) {
 
    if (checkbox[i].checked) {
      deleteList[i].type = 'text';
      deleteList[i].value = userinfo.item(i).textContent + ':' + username.item(i).textContent;
    } else {
      deleteList[i].type = 'hidden';
    }
  }
}