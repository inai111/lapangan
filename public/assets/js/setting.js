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
//     // document
})