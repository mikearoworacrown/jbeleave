const formEditRegion = document.querySelector(".jbe__editregion");
const submitBtnEditRegion = document.querySelector(".jbe__editregion-submit");

if(submitBtnEditRegion){
    submitBtnEditRegion.onclick = () => {
        let regionEditId = document.querySelector(".regioneditid");
        let regionEditName = document.querySelector(".regionedit");
        let errorMsgRegister = document.querySelector(".jbe__error-msg");
        let successMsgRegister = document.querySelector(".jbe__success-msg");
        
        if(regionEditId.value != "" && regionEditName.value != ""){
            let region_id = regionEditId.value;
            let region = regionEditName.value;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "./ajax_admin/updateregion.php?region_id="+region_id+"&region="+region, true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        let dataParsed = JSON.parse(data);
                        console.log(dataParsed);
                        if (dataParsed['status'] == "success") {
                            errorMsgRegister.style.display = "none";
                            successMsgRegister.textContent = dataParsed['message'];
                            successMsgRegister.style.display = "block";
                        }else if (dataParsed['status'] == "error"){
                            successMsgRegister.style.display = "none";
                            errorMsgRegister.textContent = dataParsed['message'];
                            errorMsgRegister.style.display = "block";
                            regionEditId.focus();
                        }
                    }
                }
            }
            xhr.send();
        }

    }
}