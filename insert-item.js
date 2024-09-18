
jQuery(document).ready(function () {

    jQuery('#w_add_item_form_').validate({
        
        rules: {
            'w_item_type[]': {
                required: true,
            },
            'w_weight[]': {
                required: true,
                minlength: 1
            },
            'w_unit[]': {
                required: true,
            },
            'w_quantity[]': {
                required: true,
                minlength: 1
            },
            'w_item_name[]': {
                required: true,
                minlength: 2
            },
            'w_fname[]': {
                required: true,
                minlength: 2
            },
            'w_lname[]': {
                required: true,
                minlength: 2
            },
            'w_pnumber[]': {
                required: true,
            },
            'w_date': {
                required: true,
            },
            'w_country': {
                required: true,
            },
            'w_state': {
                required: true,
            },
            'w_city': {
                required: true,
            },
            'w_office': {
                required: true,
            },
        },
        submitHandler: function () {
            var formData = new FormData(document.getElementById("w_add_item_form_"));
            jQuery.ajax({
                type: 'POST',
                url: 'insert-item.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (parseInt(data) === parseInt(1)) {
                        let timerInterval
                        Swal.fire({
                            title: 'your data successfully registered!',
                            html: 'milliseconds.',
                            position: 'top-end',
                            icon: 'success',
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                            }
                        })
                        setInterval('location.reload()', 1000);
                    }
                    console.log(data);
                    if (parseInt(data) !== parseInt(1)) {
                        
                        let alertBody = "Something was wrong!";
                        if(data.includes("No connection could be made because the target machine actively refused it")){
                            alertBody = "Connection Refused!";
                        }
                        let timerInterval
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, error occurred!',
                            text: alertBody,
                            position: 'top-end',
                            timer: 6000,
                            showCancelButton: true,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                // console.log('I was closed by the timer')
                            }
                        })
                    }
                },
                error: function (err) {
                    let timerInterval
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops, error occurred!',
                        text: data,
                        // html: '<b></b>milliseconds.',
                        position: 'top-end',
                        timer: 30000,
                        showCancelButton: true,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    })
                }
            });
        }
    });
});
