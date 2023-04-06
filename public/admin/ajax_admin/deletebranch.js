const submitBtnDeleteBranch = document.querySelector(".jbe__deletebranch-submit");

if(submitBtnDeleteBranch){
    submitBtnDeleteBranch.onclick = () => {
        let branchregionDeleteId = document.querySelector(".branchregiondeleteid");
        let branchDeleteId = document.querySelector(".branchdeleteid");
        let branchDeleteName = document.querySelector(".branchdelete");
        let errorMsgRegister = document.querySelector(".jbe__error-msg4");
        let successMsgRegister = document.querySelector(".jbe__success-msg4");
        if(branchregionDeleteId.value != "" && branchDeleteId.value != "" && branchDeleteName.value != ""){
            let region_id = branchregionDeleteId.value;
            let branch_id = branchDeleteId.value;
            let branch = branchDeleteName.value;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "./ajax_admin/deletebranch.php?region_id="+region_id+"&branch_id="+branch_id+"&branch="+branch, true);
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
                            branchDeleteName.focus();
                        }
                    }
                }
            }
            xhr.send();
        }

    }
}