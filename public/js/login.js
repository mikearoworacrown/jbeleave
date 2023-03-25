const formLogin = document.querySelector(".jbe__login-form form");
const submitBtnLogin = document.querySelector(".jbe__login .jbe__submit");

if(formLogin){
    formLogin.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitBtnLogin){
    submitBtnLogin.onclick = () => {
        let username = document.querySelector("#username");
        let password = document.querySelector("#password");
        let errorMsgLogin = document.querySelector(".jbe__error-msg");
    
        if(username.value !== "" && password.value !== ""){
            //Ajax
            let xhr = new XMLHttpRequest(); //creating XML object
            xhr.open("POST", "ajax_php/login.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        if(data == "user"){
                            console.log(data);
                            location.href = "user/";
                        } 
                        else if (data == "supervisor"){
                            console.log(data);
                            location.href = "supervisor/";
                        }
                        else if (data == "hr"){
                            console.log(data);
                            location.href = "hr/";
                        } else if (data == "management"){
                            console.log(data);
                            location.href = "management/";
                        } else if (data == "admin"){
                            console.log(data);
                            location.href = "admin/";
                        }
                        else{
                            errorMsgLogin.textContent = data;
                            errorMsgLogin.style.display = "block";
                            console.log(data);
                        }
                    }
                }
            }
            ///we have to send the form data through AJAX to php
            let formData = new FormData(formLogin); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }
        else if(username.value == "" && password.value !== "") {
            errorMsgLogin.textContent = "Username cannot be empty";
            errorMsgLogin.style.display = "block";
        }
        else if(username.value !== "" && password.value == "") {
            errorMsgLogin.textContent = "Password cannot be empty";
            errorMsgLogin.style.display = "block";
        }
        else {
            errorMsgLogin.textContent = "username and password cannot be empty";
            errorMsgLogin.style.display = "block";
        }
    }
}


