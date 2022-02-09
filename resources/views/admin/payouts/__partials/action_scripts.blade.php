<script>
    $(document).ready(function() {
        $('.cancel').click(function() {
            var payoutId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure to cancel withdraw request #' + payoutId + '?',
                text: "Withdrawal request amount will be added to users account balance.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/felicita/payouts/' + payoutId, {}).then((response) => {
                        Swal.fire({
                            title: 'Cancelled!',
                            text: 'Payout #' + payoutId + ' has been cancelled and funds has been returned to users available balance.',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload()
                            }
                        })
                    }).catch((error) => {
                        Swal.fire({
                            title: 'Whoops! Something went wrong!',
                            text: 'Unable to cancel withdraw request #' + payoutId + '. Message: ' + error.response.data.message,
                            icon: 'error'
                        })
                    });
                }
            })
        });

        $('.send').click(function() {
            var payoutId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure to process payout #' + payoutId + '?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.patch('/felicita/payouts/' + payoutId, {}).then((response) => {
                        Swal.fire({
                            title: 'PAID!',
                            text: 'Payout #' + payoutId + ' has been processed with transaction id: ' +  response.data.transaction_id,
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload()
                            }
                        })
                    }).catch((error) => {
                        Swal.fire({
                            title: 'Whoops! Something went wrong!',
                            text: 'Unable to cancel withdraw request #' + payoutId + '. Message: ' + error.response.data.message,
                            icon: 'error'
                        })
                    });
                }
            })
        });
    })
</script>
