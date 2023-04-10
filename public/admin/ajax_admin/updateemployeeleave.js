const formEmployeeLeaveRequest = document.querySelector(".leave-request-form");
const submitEmployeeBtnLeave = document.querySelector(".jbe__adminupdateLeave-submit");

if(formEmployeeLeaveRequest){
    formEmployeeLeaveRequest.onsubmit = (e) => {
        e.preventDefault();
    }
}

if(submitEmployeeBtnLeave) {
    submitEmployeeBtnLeave.onclick = () => {
        let loading = document.querySelector(".loader");
        loading.style.display = "block";
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax_admin/updateemployeeleave.php", true);
        xhr.onload = () => {
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    let dataParsed = JSON.parse(data);
                    // console.log(dataParsed);
                    if (dataParsed['status'] == "success" || dataParsed['status'] == "error")  {
                        location.href = "approvedleave.php";
                    }
                }
            }
        }
        //we have to send the form data through AJAX to php
        let formData = new FormData(formProcessLeaveRequest); //creating new formData object
        xhr.send(formData); //sending the form data to php
    }
}
