document.querySelector(`#loginBtn`).addEventListener('click', function (e) {
    e.preventDefault();
    resetForm();
    let modalLogin = new bootstrap.Modal(document.querySelector(`#loginModal`));
    modalLogin.show();
})
// untuk submit regist form
document.querySelector(`form#registForm`).addEventListener('submit', function (e) {
    e.preventDefault();
    resetForm(true);
    document.querySelector(`form#registForm button[type=submit]`).disabled = true;
    let myData = new FormData(document.querySelector(`form#registForm`));
    fetch('/regist', { method: "POST", body: myData })
    .then(e=>e.json())
    .then(res=>{
        if(res.debug){
            console.log(res);
            window.debugRegist = res;
            return;
        }
        if(res.status){
            document.querySelector(`#registFormMessage`).innerHTML = res.message;
            document.querySelector(`#registFormMessage`).classList.replace('alert-warning','alert-success');
            document.querySelectorAll(`#registForm input:not([name="_token"])`).forEach(elem=>elem.classList.add('is-valid'));
        }else{
            document.querySelector(`#registFormMessage`).innerHTML = res.message;
            document.querySelector(`#registFormMessage`).classList.replace('alert-success','alert-warning');
            document.querySelector(`#registFormMessage`).style.display = '';
            document.querySelectorAll(`#registForm input:not([name="_token"])`).forEach(elem=>{
                if(res.validation[elem.name]){
                    elem.classList.add('is-invalid');
                    document.querySelector(`[id="${elem.name}-regist-msg"]`).classList.add('invalid-feedback');
                    document.querySelector(`[id="${elem.name}-regist-msg"]`).innerHTML = res.validation[elem.name][0];
                }else{
                    elem.classList.add('is-valid');
                }
            })
        }
    })
    .catch(_ => document.querySelector(`form#registForm button[type=submit]`).disabled = false)
    .finally(_ => document.querySelector(`form#registForm button[type=submit]`).disabled = false)
})
// untuk submit login form
document.querySelector(`form#loginForm`).addEventListener('submit', function (e) {
    e.preventDefault();
    resetForm(true);
    document.querySelector(`form#loginForm button[type=submit]`).disabled = true;
    let myData = new FormData(document.querySelector(`form#loginForm`));
    fetch('/login', { method: "POST", body: myData })
        .then(e => e.json())
        .then(res => {
            console.log(res)
        })
        // .catch(_=>document.querySelector(`form#loginForm button`).disabled = false)
        .finally(_ => document.querySelector(`form#loginForm button`).disabled = false)
})
// untuk tampilkan form register
document.querySelector(`button#toRegistForm`).addEventListener('click', function (e) {
    e.preventDefault();
    resetForm();
    document.querySelector(`form#loginForm`).style.display = 'none';
    document.querySelector(`form#registForm`).style.display = 'block';
})
// untuk tampilkan form login
document.querySelector(`button#toLoginForm`).addEventListener('click', function (e) {
    e.preventDefault();
    resetForm();
    document.querySelector(`form#registForm`).style.display = 'none';
    document.querySelector(`form#loginForm`).style.display = 'block';
})

function resetForm(error = false){
    // kalau error sama dengan true maka hanya akan menghapus pesan error
    if(!error){
        document.querySelectorAll(`form input:not([name="_token"])`).forEach(elem=>{
            elem.value = '';
        })
    }
    document.querySelectorAll(`form input:not([name="_token"])`).forEach(elem=>{
        elem.classList.remove('is-invalid');
        elem.classList.remove('is-valid');
    })
    document.querySelectorAll(`[id$="-msg"]`).forEach(elem=>{
        elem.classList.remove('invalid-feedback');
        elem.classList.remove('valid-feedback');
        elem.innerHTML = '';
    });
    document.querySelectorAll(`[id$="FormMessage"]`).forEach(elem=>{
        elem.style.display = 'none';
        elem.innerHTML = '';
    })
}