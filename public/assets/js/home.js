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
            resetForm();
            document.querySelector(`#registFormMessage`).classList.replace('alert-warning','alert-success');
            document.querySelector(`#registFormMessage`).innerHTML = res.message;
            document.querySelector(`#registFormMessage`).style.display = '';
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
            if(res.debug){
                console.log(res);
                window.debugRegist = res;
                document.querySelector(`form#loginForm button[type=submit]`).disabled = false
                return;
            }
            if(res.status){
                document.querySelector(`#loginFormMessage`).classList.replace('alert-warning','alert-success');
                document.querySelector(`#loginFormMessage`).innerHTML = res.message;
                document.querySelector(`#loginFormMessage`).style.display = '';
                if(res.href) window.location.href = res.href;
            }else{
                document.querySelector(`#loginFormMessage`).innerHTML = res.message;
                document.querySelector(`#loginFormMessage`).classList.replace('alert-success','alert-warning');
                document.querySelector(`#loginFormMessage`).style.display = '';
                document.querySelectorAll(`#loginForm input:not([name="_token"])`).forEach(elem=>{
                    if(res.validation[elem.name]){
                        elem.classList.add('is-invalid');
                        document.querySelector(`[id="${elem.name}-msg"]`).classList.add('invalid-feedback');
                        document.querySelector(`[id="${elem.name}-msg"]`).innerHTML = res.validation[elem.name][0];
                    }else{
                        elem.classList.add('is-valid');
                    }
                })
                document.querySelector(`form#loginForm button[type=submit]`).disabled = false
            }
        })
        .catch(_=>document.querySelector(`form#loginForm button[type=submit]`).disabled = false)
})
// untuk tampilkan form register
document.querySelector(`a#toRegistForm`).addEventListener('click', function (e) {
    e.preventDefault();
    resetForm();
    document.querySelector(`#loginModalLabel`).innerHTML = 'Register Form';
    document.querySelector(`form#loginForm`).style.display = 'none';
    document.querySelector(`form#registForm`).style.display = 'block';
})
// untuk tampilkan form login
document.querySelector(`button#toLoginForm`).addEventListener('click', function (e) {
    e.preventDefault();
    resetForm();
    document.querySelector(`#loginModalLabel`).innerHTML = 'Login Form';
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
// document.querySelector(`form#autoCompleteSearch input[name=search]`).addEventListener('focus',function(e){
//         document.querySelector('#hasilSearch').style.display = 'none';
// })
if(document.querySelector(`.searchBar`))document.querySelector(`.searchBar`).addEventListener('click',e=>{
    e.preventDefault();
    let modal = new bootstrap.Modal(searchModal);
    resetSearchBarFunction()
    modal.show();
})
resetSearchBar.addEventListener('click',e=>{
    e.preventDefault();
    resetSearchBarFunction()
})
function resetSearchBarFunction()
{
    nullHasilSearch.style.display = '';
    hasilSearch.style.display = 'none';
    hasilSearch.innerHTML = '';
    sortHasilSearch.style.display = 'none';
    document.querySelector(`input[name="search"]`).value = '';
}
document.querySelector(`input[name="search"]`).addEventListener('keyup',function(){
    let myData = new FormData();
    myData.append('search',this.value);
    let sort = 'newest';
    if(document.querySelector(`[data-sort].btn-dark`)) sort = document.querySelector(`[data-sort].btn-dark`).dataset.value;
    myData.append('sort',sort);
    fetchingDataLapangan(myData);
})
let fetchAllow = true;
function fetchingDataLapangan(params)
{
    if(!fetchAllow)return;
    if(fetchAllow)fetchAllow=false;
    let sort = params.get('sort');
    if(document.querySelector(`[data-sort].btn-dark`)) document.querySelector(`[data-sort].btn-dark`).classList.replace('btn-dark','btn-secondary');
    document.querySelector(`[data-sort][data-value="${sort}"]`).classList.replace('btn-secondary','btn-dark');
    params = new URLSearchParams(params).toString();
    fetch(`/fetching-lapangan?${params}`)
    .then(ee=>ee.json())
    .then(res=>{
        console.log(res);
    })
    .catch(_=>fetchAllow = true)
    .finally(_=>fetchAllow = true)
}
`<a href="#" class="list-group-item list-group-item-action" aria-current="true">
<div class="row">
    <div class="col-3 autocomplete-img"
        style="background-image:url(https://akcdn.detik.net.id/community/media/visual/2021/06/13/lapangan-galuh-pakuan-lapangan-bola-desa-3_169.jpeg?w=700&q=90)">
    </div>
    <div class="col-9">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">List group item heading</h5>
            <small>3 days ago</small>
        </div>
        <p class="mb-1">Some placeholder content in a paragraph.</p>
        <small>And some small print.</small>
    </div>
</div>
</a>`