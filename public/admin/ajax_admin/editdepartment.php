<!-- The Modal -->
<div id="myModal1" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span id="close1">&times;</span>
        <div class="clearfix"></div>
        <form class="jbe__addregion" id="jbe__addregion" action="" autocomplete="off">
            <div class="jbe__error-msg" id="jbe__error-msg">This is an error message</div>
            <div class="jbe__success-msg" id="jbe__success-msg">This is a success message</div>
            <div class="form-group">
                <label for="regionadd" id="label-regionadd">Region Name<span class="jbe__required jbe__error" id="regionadd-info"></span></label>
                <input type="text" class="form-control regionadd" name="regionadd" id="regionadd" placeholder="Region Name" value ="" required/>
            </div>
            <div class="form-group">
                <button type="submit" id="jbe__addregion-submit" class="jbe__addregion-submit" name="jbe__addregion-submit">Add Region</button>
            </div>
        </form>
    </div>
</div>

<!-- The Modal -->
<div id="myModal2" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span id="close2">&times;</span>
        <div class="clearfix"></div>
        <form class="jbe__addbranch" id="jbe__addbranch" action="" autocomplete="off">
            <div class="jbe__error-msg1" id="jbe__error-msg1">This is an error message</div>
            <div class="jbe__success-msg1" id="jbe__success-msg1">This is a success message</div>
            <div class="form-group">
                <label for="region_id" id="label-region_id">Select Region<span class="jbe__required jbe__error" id="region_id-info"></span></label>
                <select class="form-select region-select1" name="region_id" id="region_id">
                    <?php
                        for($i = 0; $i < count($regions); $i++){?>
                            <option value='<?php echo $regions[$i]["region_id"];?>'><?php echo $regions[$i]["region"]?></option>
                    <?php } ?>
                </select>
                <label for="branch" id="label-branch">Branch Name<span class="jbe__required jbe__error" id="branch-info"></span></label>
                <input type="text" class="form-control branch" name="branch" id="branch" placeholder="Branch Name" value ="" required/>
            </div>
            <div class="form-group">
                <button type="submit" id="jbe__addbranch-submit" class="jbe__addbranch-submit" name="jbe__addbranch-submit">Add Branch</button>
            </div>
            
        </form>
    </div>
</div>

<script>
    // Get the modal --- Edit region
    var modal1 = document.getElementById("myModal1");
    // Get the button that opens the modal
    var btn1 = document.getElementById("myBtn1");
    // Get the <span> element that closes the modal
    var span1 = document.getElementById("close1");
    // When the user clicks on the button, open the modal
    btn1.onclick = function() {
        modal1.style.display = "block";
    }
    // When the user clicks on <span> (x), close the modal
    span1.onclick = function() {
        modal1.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
    }


    // Get the modal
    var modal2 = document.getElementById("myModal2");
    // Get the button that opens the modal
    var btn2 = document.getElementById("myBtn2");
    // Get the <span> element that closes the modal
    var span2 = document.getElementById("close2");
    // When the user clicks on the button, open the modal
    btn2.onclick = function() {
        modal2.style.display = "block";
    }
    // When the user clicks on <span> (x), close the modal
    span2.onclick = function() {
        modal2.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }
</script>
