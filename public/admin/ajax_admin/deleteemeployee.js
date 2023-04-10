const formDeleteEmployee = document.querySelector(".jbe__deleteemployee");
const submitBtnDeleteEmployee = document.querySelector(".jbe__deleteemployee-submit");

if(formDeleteEmployee){
    formDeleteEmployee.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitBtnDeleteEmployee){
    submitBtnDeleteEmployee.onclick = () => {
        let employeeId = document.querySelector(".employeeid");
        let errorMsgRegister = document.querySelector(".jbe__error-msg");
        let successMsgRegister = document.querySelector(".jbe__success-msg");
        
        if(employeeId.value != ""){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax_admin/deleteemployee.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        let dataParsed = JSON.parse(data);
                        if (dataParsed['status'] == "success") {
                            errorMsgRegister.style.display = "none";
                            successMsgRegister.textContent = dataParsed['message'];
                            successMsgRegister.style.display = "block";
                        }else if (dataParsed['status'] == "error"){
                            successMsgRegister.style.display = "none";
                            errorMsgRegister.textContent = dataParsed['message'];
                            errorMsgRegister.style.display = "block";
                        }
                    }
                }
            }
            ///we have to send the form data through AJAX to php
            let formData = new FormData(formDeleteEmployee); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }

    }
}