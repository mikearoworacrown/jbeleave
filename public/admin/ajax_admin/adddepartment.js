const formDepartment = document.querySelector(".jbe__adddepartment");
const submitBtnDepartment = document.querySelector(".jbe__adddepartment-submit");

if(formDepartment){
    formDepartment.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitBtnDepartment){
    submitBtnDepartment.onclick = () => {
        let departmentName = document.querySelector(".department");
        let errorMsgRegister = document.querySelector(".jbe__error-msg1");
        let successMsgRegister = document.querySelector(".jbe__success-msg1");
        if(departmentName.value != ""){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax_admin/adddepartment.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        let dataParsed = JSON.parse(data);
                        if (dataParsed['status'] == "success") {
                            errorMsgRegister.style.display = "none";
                            successMsgRegister.textContent = dataParsed['message'];
                            successMsgRegister.style.display = "block";
                            departmentName.value = "";
                        }else if (dataParsed['status'] == "error"){
                            successMsgRegister.style.display = "none";
                            errorMsgRegister.textContent = dataParsed['message'];
                            errorMsgRegister.style.display = "block";
                            departmentName.focus();
                        }
                    }
                }
            }
            ///we have to send the form data through AJAX to php
            let formData = new FormData(formDepartment); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }

    }
}