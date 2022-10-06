document.querySelector(`form .profilpic`).addEventListener('click', function (e) {
    e.preventDefault();
    let changeModal = new bootstrap.Modal(document.querySelector(`#changePicModal`));
    changeModal.show();
})
document.querySelectorAll('#changePicModal .profilpic').forEach(elem=>{
    elem.addEventListener('click',function(e){
        if(!elem.classList.contains('choosen')){
            document.querySelector('#changePicModal .profilpic.choosen').classList.remove('choosen');
            elem.classList.add('choosen')
        }
    })
})
document.querySelector('#changePicModal button#changeImage').addEventListener('click',function(e){
    document.querySelector(`form .profilpic`).style.backgroundImage = document.querySelector('#changePicModal .profilpic.choosen').style.backgroundImage;
})
document.querySelector(`form`).addEventListener('submit',function(e){
    e.preventDefault();
    let myData = new FormData(e.target);
    myData.append('photo',document.querySelector('#changePicModal .profilpic.choosen').dataset.image);
    fetch('/settings',{method:"POST",body:myData})
    .then(ee=>ee.json())
    .then(res=>{
        console.log(res)
        if(res.status){
            if(res.message)
            {
                this.querySelector(`#form-msg`).innerHTML = `<div class="alert alert-success alert-dismissible" role="alert">
                ${res.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
            }

        }else{
            if(res.message)
            {
                this.querySelector(`#form-msg`).innerHTML = `<div class="alert alert-warning alert-dismissible" role="alert">
                ${res.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
            }
        }
    })
})