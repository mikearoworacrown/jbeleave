const formDeleteDepartment = document.querySelector(".jbe__deletedepartment");
const submitBtnDeleteDepartment = document.querySelector(".jbe__deletedepartment-submit");

if(submitBtnDeleteDepartment){
    submitBtnDeleteDepartment.onclick = () => {
        let departmentDeleteId = document.querySelector(".departmentdeleteid");
        let departmentDeleteName = document.querySelector(".departmentdelete");
        let errorMsgRegister = document.querySelector(".jbe__error-msg2");
        let successMsgRegister = document.querySelector(".jbe__success-msg2");
        if(departmentDeleteId.value != "" && departmentDeleteName.value != ""){
            let department_id = departmentDeleteId.value;
            let department = departmentDeleteName.value;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "./ajax_admin/deletedepartment.php?department_id="+department_id+"&department="+department, true);
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
                        }
                    }
                }
            }
            xhr.send();
        }

    }
}