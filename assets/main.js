$(document).ready(function() {
    $("input").keyup(function(e) {
        $(this).next().empty();
    });
});

function logout() {
    swal({
        title: "Logout?",
        text: "Anda yakin akan logout?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4fa7f3",
        cancelButtonColor: "#d57171",
        showCancelButton: true,
        confirmButtonText: "Logout",
        cancelButtonText: "Batal",
        confirmButtonClass: "btn btn-danger",
        cancelButtonClass: "btn btn-default m-l-10",
        buttonsStyling: false,
    }).then(
        function() {
            $.ajax({
                url: $("meta[name=app-url]").attr("content") + "admin/auth/logout",
                type: "POST",
                success: function(data) {
                    swal({
                        title: "Sukses!",
                        text: "Logout berhasil",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000,
                    }).then(
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        },
                        function() {
                            window.location.href =
                                $("meta[name=app-url]").attr("content") + "admin/login";
                        }
                    );
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Gagal!",
                        text: "Proses gagal!",
                        type: "error",
                        showConfirmButton: false,
                        timer: 1000,
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        }
                    );
                },
            });
        },
        function(dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === "cancel") {
                if (dismiss === "timer") {}
            }
        }
    );
}
// ganti password
function ganti_pass() {
    $("#ganti_pass_modal").modal("show");
    $("#form_ganti_pass")[0].reset();
    $(".text-danger").empty();
    $(".modal-title").text("Ganti Password"); // Set title to Bootstrap modal title
}
// Save Pass
function save_pass() {
    $("#Btn-savePass").text("Menyimpan..."); //change button text
    $("#Btn-savePass").attr("disabled", true); //set button disable
    // ajax adding data to database
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/user/update/password",
        type: "POST",
        data: $("#form_ganti_pass").serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $("#ganti_pass_modal").modal("hide"); // hide bootstrap modal
                swal({
                    title: "Sukses!",
                    text: "Password berhasil disimpan!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                //if success close modal and reload ajax table
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]')
                        .next()
                        .text(data.error_string[i]); //select span text-danger class set text error string
                }
            }
            $("#Btn-savePass").text("Simpan"); //change button text
            $("#Btn-savePass").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
            $("#Btn-savePass").text("Simpan"); //change button text
            $("#Btn-savePass").attr("disabled", false); //set button enable
        },
    });
}

// Allow Edit profil
function allowEditProfil() {
    $(".edit-profil").prop("disabled", false); // enable form
    $("#Btn-editProfil").hide();
    $("#Btn-saveProfil").show(); //show button save
    $(".modal-title").text("Edit Profil"); // Set title to Bootstrap modal title
}

// profil user
function profil_user(id) {
    $("#photo-preview div").empty();
    $(".edit-profil").prop("disabled", true); // disabled form
    $("#Btn-editProfil").show();
    $("#Btn-saveProfil").hide();
    $("#profil_user_modal").modal("show");
    $("#form_profil_user")[0].reset();
    $(".text-danger").empty();
    $(".modal-title").text("Profil"); // Set title to Bootstrap modal title
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/user/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_user"]').val(data.id_user);
            $('[name="nama"]').val(data.nama);
            $('[name="username"]').val(data.username);
            var photo =
                $("meta[name=app-url]").attr("content") + "upload/users/" + data.photo;
            if (data.photo) {
                $("#label-photo").text("Ganti Foto"); // label foto upload
                $("#foto-user").html(
                    '<img src="' +
                    photo +
                    '" class="img-circle img-thumbnail" alt="profile-image">'
                );

                $("#photo-preview div").append(
                    '<input type="checkbox" disabled="disabled" class="form-check-input edit-profil" name="remove_photo" value="' +
                    data.photo +
                    '"/> Remove file when saving'
                ); // remove photo
            } else {
                $("#label-photo").text("Upload Foto"); // label foto upload
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
        },
    });
}

// Save Profil
function save_profil() {
    console.log($("#form_profil_user").serialize());
    $("#Btn-saveProfil").text("Menyimpan..."); //change button text
    $("#Btn-saveProfil").attr("disabled", true); //set button disable
    // ajax adding data to database
    var formData = new FormData($("#form_profil_user")[0]);
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/user/update/profil",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $("#profil_user_modal").modal("hide"); // hide bootstrap modal
                swal({
                    title: "Sukses!",
                    text: "Password berhasil disimpan!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                //if success close modal and reload ajax table
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]')
                        .next()
                        .text(data.error_string[i]); //select span text-danger class set text error string
                }
            }
            $("#Btn-saveProfil").text("Simpan"); //change button text
            $("#Btn-saveProfil").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
            $("#Btn-saveProfil").text("Simpan"); //change button text
            $("#Btn-saveProfil").attr("disabled", false); //set button enable
        },
    });
}