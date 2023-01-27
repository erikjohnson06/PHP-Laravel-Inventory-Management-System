
$(function () {
    $(document).on('click', 'a.deleteItem', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: "Are you sure you want to delete?",
            text: "Please confirm",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                        'Success!',
                        'This data has been deleted.',
                        'success'
                        );
            }
        });
    });

    $(document).on('click', 'a.approveItem', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: "Are you sure you want to approve?",
            text: "Please confirm",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                        'Success!',
                        'This data has been updated.',
                        'success'
                        );
            }
        });
    });

    $(document).on('click', 'a.cancelItem', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: "Are you sure you want to cancel?",
            text: "Please confirm",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                        'Success!',
                        'This data has been cancelled.',
                        'success'
                        );
            }
        });
    });
});

