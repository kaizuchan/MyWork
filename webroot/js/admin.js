const userpass = document.getElementById('userpass');
const passconf = document.getElementById('password_confirm');
const passcheck = document.getElementById('passCheck');
const passconfcheck = document.getElementById('passconfCheck');

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

function addRecord() {
    var addrecord = document.getElementById('addRecord');
    addrecord.classList.remove('hidden');
}
function removeRecord() {
    var addrecord = document.getElementById('addRecord');
    addrecord.classList.add('hidden');
}