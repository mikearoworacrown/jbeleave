const formRegion = document.querySelector(".jbe__addregion");
const submitBtnRegion = document.querySelector(".jbe__addregion-submit");

if(formRegion){
    formRegion.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitBtnRegion){
    submitBtnRegion.onclick = () => {
        let regionName = document.querySelector(".regionadd");
        let errorMsgRegister = document.querySelector(".jbe__error-msg1");
        let successMsgRegister = document.querySelector(".jbe__success-msg1");
        if(regionName.value != ""){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax_admin/addregion.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        let dataParsed = JSON.parse(data);
                        if (dataParsed['status'] == "success") {
                            errorMsgRegister.style.display = "none";
                            successMsgRegister.textContent = dataParsed['message'];
                            successMsgRegister.style.display = "block";
                            regionName.value = "";
                        }else if (dataParsed['status'] == "error"){
                            successMsgRegister.style.display = "none";
                            errorMsgRegister.textContent = dataParsed['message'];
                            errorMsgRegister.style.display = "block";
                            regionName.focus();
                        }
                    }
                }
            }
            ///we have to send the form data through AJAX to php
            let formData = new FormData(formRegion); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }

    }
}