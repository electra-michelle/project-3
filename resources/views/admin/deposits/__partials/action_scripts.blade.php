<script>
    $(document).ready(function () {
        $('.cancel').click(function () {
            var depositId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure to cancel deposit request #' + depositId + '?',
                text: 'Deposit #' + depositId + ' will be cancelled.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/felicita/deposits/' + depositId, {}).then((response) => {
                        Swal.fire({
                            title: 'Cancelled!',
                            text: 'Deposit #' + depositId + ' has been cancelled.',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload()
                            }
                        })
                    }).catch((error) => {
                        Swal.fire({
                            title: 'Whoops! Something went wrong!',
                            text: 'Unable to cancel withdraw request #' + depositId + '. Message: ' + error.response.data.message,
                            icon: 'error'
                        })
                    });
                }
            })
        });
        $('.recover').click(function () {
            var depositId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure to recover deposit request #' + depositId + '?',
                text: 'Deposits #' + depositId + ' status will be changed to pending',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, recover it!',
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/felicita/deposits/' + depositId + '/recover', {}).then((response) => {
                        Swal.fire({
                            title: 'Recovered!',
                            text: 'Deposit #' + depositId + ' has been recovered.',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload()
                            }
                        })
                    }).catch((error) => {
                        Swal.fire({
                            title: 'Whoops! Something went wrong!',
                            text: 'Unable to recover withdraw request #' + depositId + '. Message: ' + error.response.data.message,
                            icon: 'error'
                        })
                    });
                }
            })
        });
    })
</script>
