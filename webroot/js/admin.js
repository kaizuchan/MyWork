const olduserpass = document.getElementById('olduserpass');
const userpass = document.getElementById('userpass');
const passconf = document.getElementById('password_confirm');
const oldpasscheck = document.getElementById('oldPassCheck');
const passcheck = document.getElementById('passCheck');
const passconfcheck = document.getElementById('passconfCheck');
const logincheck = document.getElementById('exampleInputPassword1');

passcheck.addEventListener('change',function() {
    if(passcheck.checked) {
        logincheck.type = 'text';
        logincheck.textContent = 'パスワードを非表示';
    } else {
        logincheck.type = 'password';
    }
});
passcheck.addEventListener('change',function() {
    if(passcheck.checked) {
        userpass.type = 'text';
        userpass.textContent = 'パスワードを非表示';
    } else {
        userpass.type = 'password';
    }
});
passconfcheck.addEventListener('change',function() {
    if(passconfcheck.checked) {
        passconf.type = 'text';
        passconf.textContent = 'パスワードを非表示';
    } else {
        passconf.type = 'password';
    }
});
oldpasscheck.addEventListener('change',function() {
    if(oldpasscheck.checked) {
        olduserpass.type = 'text';
        olduserpass.textContent = 'パスワードを非表示';
    } else {
        olduserpass.type = 'password';
    }
});
function addRecord() {
    var addrecord = document.getElementById('addRecord');
    addrecord.classList.remove('hidden');
}
function removeRecord() {
    var addrecord = document.getElementById('addRecord');
    addrecord.classList.add('hidden');
}