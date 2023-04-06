const formDeleteRegion = document.querySelector(".jbe__deleteregion");
const submitBtnDeleteRegion = document.querySelector(".jbe__deleteregion-submit");

if(submitBtnDeleteRegion){
    submitBtnDeleteRegion.onclick = () => {
        console.log("CLICKED");
        let regionDeleteId = document.querySelector(".regiondeleteid");
        let regionDeleteName = document.querySelector(".regiondelete");
        let errorMsgRegister = document.querySelector(".jbe__error-msg2");
        let successMsgRegister = document.querySelector(".jbe__success-msg2");
        if(regionDeleteId.value != "" && regionDeleteName.value != ""){
            let region_id = regionDeleteId.value;
            let region = regionDeleteName.value;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "./ajax_admin/deleteregion.php?region_id="+region_id+"&region="+region, true);
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