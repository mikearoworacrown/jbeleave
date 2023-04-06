const formEditDepartment = document.querySelector(".jbe__editdepartment");
const submitBtnEditDepartment = document.querySelector(".jbe__editdepartment-submit");

if(submitBtnEditDepartment){
    submitBtnEditDepartment.onclick = () => {
        let departmentEditId = document.querySelector(".departmenteditid");
        let departmentEditName = document.querySelector(".departmentedit");
        let errorMsgRegister = document.querySelector(".jbe__error-msg");
        let successMsgRegister = document.querySelector(".jbe__success-msg");
        
        if(departmentEditId.value != "" && departmentEditName.value != ""){
            let department_id = departmentEditId.value;
            let department = departmentEditName.value;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "./ajax_admin/updatedepartment.php?department_id="+department_id+"&department="+department, true);
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
                            departmentEditId.focus();
                        }
                    }
                }
            }
            xhr.send();
        }

    }
}