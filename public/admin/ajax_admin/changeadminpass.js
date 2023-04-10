const formChangeAdminPassword = document.querySelector(".jbe__changepassword");
const submitBtnChangeAdminPassword = document.querySelector(".jbe__changepassword-submit");

if(formChangeAdminPassword){
    formChangeAdminPassword.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitBtnChangeAdminPassword){
    submitBtnChangeAdminPassword.onclick = () => {
        let employeeId = document.querySelector(".employeeid");
        let currPassword = document.querySelector(".password");
        let newPassword = document.querySelector(".newpassword");
        let confirmPassword = document.querySelector(".confirmpassword");
        let errorMsgRegister = document.querySelector(".jbe__error-msg");
        let successMsgRegister = document.querySelector(".jbe__success-msg");
        
        if(currPassword.value != "" && newPassword.value != "" && confirmPassword.value != "" && (newPassword.value == confirmPassword.value)){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax_admin/changeadminpass.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        let dataParsed = JSON.parse(data);
                        if (dataParsed['status'] == "success") {
                            errorMsgRegister.style.display = "none";
                            successMsgRegister.textContent = dataParsed['message'];
                            successMsgRegister.style.display = "block";
                            currPassword.value = "";
                            newPassword.value = "";
                            confirmPassword.value = "";
                        }else if (dataParsed['status'] == "error"){
                            successMsgRegister.style.display = "none";
                            errorMsgRegister.textContent = dataParsed['message'];
                            errorMsgRegister.style.display = "block";
                            currPassword.value = "";
                            newPassword.value = "";
                            confirmPassword.value = "";
                            newPassword.focus();
                        }
                    }
                }
            }
            ///we have to send the form data through AJAX to php
            let formData = new FormData(formChangeAdminPassword); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }else if(newPassword.value == "" || confirmPassword.value == "" || currPassword.value != ""){
            successMsgRegister.style.display = "none";
            errorMsgRegister.textContent = "Input box(s) cannot be empty";
            errorMsgRegister.style.display = "block";
            newPassword.focus();
        }else if(newPassword.value != confirmPassword.value) {
            successMsgRegister.style.display = "none";
            errorMsgRegister.textContent = "Both Passwords have to be the samae";
            errorMsgRegister.style.display = "block";
            newPassword.value = "";
            confirmPassword.value = "";
            newPassword.focus();
        }

    }
}