const formUpdateSubLeaveRequest = document.querySelector(".sub-leave-request-form");
const submitUpdateSubBtnLeave = document.querySelector(".jbe__updateSubLeave-submit");

if(formUpdateSubLeaveRequest){
    formUpdateSubLeaveRequest.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitUpdateSubBtnLeave) {
    submitUpdateSubBtnLeave.onclick = () => {
        let loading = document.querySelector(".loader");
        loading.style.display = "block";
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../ajax_php/updateleave.php", true);
        xhr.onload = () => {
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    let dataParsed = JSON.parse(data);
                    console.log(dataParsed);
                    if (dataParsed['status'] == "success" || dataParsed['status'] == "error")  {
                        location.href = "../management"
                    }
                }
            }
        }
        //we have to send the form data through AJAX to php
        let formData = new FormData(formUpdateSubLeaveRequest); //creating new formData object
        xhr.send(formData); //sending the form data to php
    }
}
