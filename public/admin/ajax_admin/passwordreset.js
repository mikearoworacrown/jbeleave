const formResetPassword = document.querySelector(".jbe__resetpassword");
const submitBtnResetPassword = document.querySelector(".jbe__resetpassword-submit");

if(formResetPassword){
    formResetPassword.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitBtnResetPassword){
    submitBtnResetPassword.onclick = () => {
        let employeeId = document.querySelector(".employeeid");
        let newPassword = document.querySelector(".newpassword");
        let confirmPassword = document.querySelector(".confirmpassword");
        let errorMsgRegister = document.querySelector(".jbe__error-msg");
        let successMsgRegister = document.querySelector(".jbe__success-msg");
        
        if(newPassword.value != "" && confirmPassword.value != "" && (newPassword.value == confirmPassword.value)){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax_admin/passwordreset.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        let dataParsed = JSON.parse(data);
                        if (dataParsed['status'] == "success") {
                            errorMsgRegister.style.display = "none";
                            successMsgRegister.textContent = dataParsed['message'];
                            successMsgRegister.style.display = "block";
                            newPassword.value = "";
                            confirmPassword.value = "";
                        }else if (dataParsed['status'] == "error"){
                            successMsgRegister.style.display = "none";
                            errorMsgRegister.textContent = dataParsed['message'];
                            errorMsgRegister.style.display = "block";
                            newPassword.value = "";
                            confirmPassword.value = "";
                            newPassword.focus();
                        }
                    }
                }
            }
            ///we have to send the form data through AJAX to php
            let formData = new FormData(formResetPassword); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }else if(newPassword.value == "" || confirmPassword.value == ""){
            successMsgRegister.style.display = "none";
            errorMsgRegister.textContent = "Input box(s) cannot be empty";
            errorMsgRegister.style.display = "block";
            newPassword.focus();
        }else {
            successMsgRegister.style.display = "none";
            errorMsgRegister.textContent = "Both Passwords have to be the samae";
            errorMsgRegister.style.display = "block";
            newPassword.value = "";
            confirmPassword.value = "";
            newPassword.focus();
        }

    }
}