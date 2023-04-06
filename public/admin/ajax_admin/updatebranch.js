const submitBtnEditBranch = document.querySelector(".jbe__editbranch-submit");

if(submitBtnEditBranch){
    console.log("Clicked");
    submitBtnEditBranch.onclick = () => {
        let branchregionEditId = document.querySelector(".branchregioneditid");
        let branchEditId = document.querySelector(".brancheditid");
        let branchEditName = document.querySelector(".branchedit");
        let errorMsgRegister = document.querySelector(".jbe__error-msg3");
        let successMsgRegister = document.querySelector(".jbe__success-msg3");
        
        if(branchregionEditId.value != "" && branchEditId.value != "" && branchEditName.value != ""){
            let region_id = branchregionEditId.value;
            let branch_id = branchEditId.value;
            let branch = branchEditName.value;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "./ajax_admin/updatebranch.php?region_id="+region_id+"&branch_id="+branch_id+"&branch="+branch, true);
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
                            regionEditId.focus();
                        }
                    }
                }
            }
            xhr.send();
        }

    }
}