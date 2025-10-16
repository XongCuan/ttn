@push('js')
<script>
    function updateTotalBill()
    {
        let subTotalBill = 0;
        let totalBill = 0;
        let totalPayment = 0;

        $('.serv-amount').each(function (i, e) { 
            subTotalBill += parseInt($(e).val());
        });
        $('.pay-amount').each(function (i, e) { 
            totalPayment += parseInt($(e).val());
        });
        totalBill = subTotalBill;
        $('.total-bill').text(number_format(totalBill));

        $('.total-payment').text(number_format(totalPayment));

        $('.sub-total-bill').text(number_format(subTotalBill));

        $('.total-not-payment').text(number_format(subTotalBill - totalPayment));
    }

    const observer = new MutationObserver($.debounce(1000, () => updateTotalBill()));

    observer.observe($("#listService")[0], {
        childList: true,
        subtree: true,
        characterData: true
    });
    observer.observe($("#listPayment")[0], {
        childList: true,
        subtree: true,
        characterData: true
    });
</script>
@endpush