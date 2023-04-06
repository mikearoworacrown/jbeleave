const formBranch = document.querySelector(".jbe__addbranch");
const submitBtnBranch = document.querySelector(".jbe__addbranch-submit");

if(formBranch){
    formBranch.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitBtnBranch){
    submitBtnBranch.onclick = () => {
        let regionId = document.querySelector("#region_id");
        let branchName = document.querySelector(".branch");
        let errorMsgRegister = document.querySelector(".jbe__error-msg5");
        let successMsgRegister = document.querySelector(".jbe__success-msg5");
        
        if(branchName.value != "" && regionId.value != ""){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax_admin/addbranch.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        let dataParsed = JSON.parse(data);
                        if (dataParsed['status'] == "success") {
                            errorMsgRegister.style.display = "none";
                            successMsgRegister.textContent = dataParsed['message'];
                            successMsgRegister.style.display = "block";
                            branch.value = "";
                        }else if (dataParsed['status'] == "error"){
                            successMsgRegister.style.display = "none";
                            errorMsgRegister.textContent = dataParsed['message'];
                            errorMsgRegister.style.display = "block";
                            branch.focus();
                        }
                    }
                }
            }
            ///we have to send the form data through AJAX to php
            let formData = new FormData(formBranch); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }

    }
}