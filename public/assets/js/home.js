document.querySelector(`#loginBtn`).addEventListener('click', function (e) {
    e.preventDefault();
    console.log('asd')
    let modalLogin = new bootstrap.Modal(document.querySelector(`#loginModal`));
    modalLogin.show();
})
document.querySelector(`form#loginForm`).addEventListener('submit',function(e){
    e.preventDefault();
    document.querySelector(`form#loginForm button`).disabled = true;
    let myData = new FormData(document.querySelector(`form#loginForm`));
    fetch('/login',{method:"POST",body:myData})
    .then(e=>e.json())
    .then(res=>{
        console.log(res)
    })
    // .catch(_=>document.querySelector(`form#loginForm button`).disabled = false)
    .finally(_=>document.querySelector(`form#loginForm button`).disabled = false)
})