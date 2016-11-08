$(document).ready(function (e) {
    $('.search-panel .dropdown-menu').find('a').click(function (e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#", "");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });

    $("a#del").click(function (e) {
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function () {
                var href = $('a#del').attr('href');
                window.location = href;
            });
    });

    $('#photo').filer({
        limit: 3,
        maxsize: 2,
        extensions: ["jpg", "png"],
        addMore: true,
        showThumbs: true,
        allowDuplicates: false,
        dialogs: {
            alert: function (text) {
                return swal("Oops...", text, "error");
            },
            confirm: function (text, callback) {
                swal({
                        title: "Are you sure?",
                        text: "You want to delete the image ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function () {
                        callback();
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    });
            }
        }
    });
});