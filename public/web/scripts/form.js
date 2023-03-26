$(document).ready(function () {
    var isFormValid = false;
    $(".AttachmentPlaceholder").css("display", "none");
    $(".input-upload").css("display", "none");
    $(".previousPageUrl").css("display", "none");
    $(".scfFileUploadBorder").addClass("hide");
    $(".attachmentLabel").css("display", "none");
    var prevpageURL = "";
    if (document.referrer.indexOf(window.location.hostname) != -1) {
        prevpageURL = document.referrer;
    }
    

  /*  $(":submit").click(function () {
        var prePageUrl1 = document.getElementById("fxb_bcf7cc5a-80ac-4cf7-8889-a3c357343681_Fields_065a1d6c-c637-419a-92df-b8cedb5ab24e__Value");
        prePageUrl1.innerHTML = prevpageURL;
        $("#fxb_bcf7cc5a-80ac-4cf7-8889-a3c357343681_Fields_065a1d6c-c637-419a-92df-b8cedb5ab24e__Value").val(prevpageURL);
        $("form").addClass("parent");
        $(".custom-form").valid();
        var allowedFiles = [".png", ".gif", ".jpeg", ".pdf"];
        var fileUpload = document.getElementById("fxb_bcf7cc5a-80ac-4cf7-8889-a3c357343681_Fields_b266f6dc-2064-4cd2-8577-fba8e2eda4c1__Value") || document.getElementById("fxb_2ba3b26d-6849-4c66-bc60-994a314eb24e_Fields_b266f6dc-2064-4cd2-8577-fba8e2eda4c1__Value") || document.getElementById("fxb_6409e74c-3315-40ca-a23e-de77cb7eb818_Fields_b266f6dc-2064-4cd2-8577-fba8e2eda4c1__Value");
        var lblError = document.getElementById("lblError");
        var lblErrorMaxSize = document.getElementById("lblErrorFileSize");
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
        if (fileUpload.value == "")
            isFormValid = true;
        return isFormValid;
    });*/

    $('.interest').change(function () {
        var interestName = $('.interest').find(":selected").text();
        var interestIndex = $('.interest').find(":selected").index();
        if (interestIndex == 4) {
            $(".input-upload").css("display", "block");
            $(".AttachmentPlaceholder").css("display", "block");
            $(".attachment").css("display", "block");
            $(".scfFileUploadBorder").removeClass("hide");

            $(".input-upload").change(function () {

                $(".custom-form").valid();
                var allowedFiles = [".png", ".gif", ".jpeg", ".pdf"];
                var fileUpload = document.getElementById("fxb_bcf7cc5a-80ac-4cf7-8889-a3c357343681_Fields_b266f6dc-2064-4cd2-8577-fba8e2eda4c1__Value") || document.getElementById("fxb_2ba3b26d-6849-4c66-bc60-994a314eb24e_Fields_b266f6dc-2064-4cd2-8577-fba8e2eda4c1__Value") || document.getElementById("fxb_6409e74c-3315-40ca-a23e-de77cb7eb818_Fields_b266f6dc-2064-4cd2-8577-fba8e2eda4c1__Value");
                var lblError = document.getElementById("lblError");
                var lblErrorMaxSize = document.getElementById("lblErrorFileSize");
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
                if (fileUpload.value != "") {
                    if (!regex.test(fileUpload.value.toLowerCase())) {
                        isFormValid = false;
                        lblError.innerHTML = "Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.";
                        lblErrorMaxSize.innerHTML = "";
                        return false;
                    }
                    else {
                        lblError.innerHTML = "";
                        isFormValid = true;
                    }
                    if (fileUpload.files[0].size > 18000000) {
                        isFormValid = false;
                        lblErrorMaxSize.innerHTML = "The file size is too large.";
                    }
                    else {
                        lblErrorMaxSize.innerHTML = "";
                        isFormValid = true;
                    }
                }
            })
        }
        else {
            $(".input-upload").css("display", "none");
            $(".AttachmentPlaceholder").css("display", "none");
            $(".attachment").css("display", "none");
        }
    });
});