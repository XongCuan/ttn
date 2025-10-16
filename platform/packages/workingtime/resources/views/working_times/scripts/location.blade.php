<x-core_base::input type="hidden" name="route_update_location" :value="route('auth.profile.update_location')" />

<script>
    function currentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(handleSuccessLocation, handleErrorLocation);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function handleSuccessLocation(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        updateLocationCurrent(latitude, longitude);
    }

    function handleErrorLocation(error) {
        updateLocationCurrent();

        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("You denied the request for Geolocation. please allow it.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    function updateLocationCurrent(latitude = '', longitude = '') {
        var url = $('input[name="route_update_location"]').val();

        var params = {
            _token: token,
            latitude: latitude,
            longitude: longitude
        };

        AjaxLibrary.put(
            url,
            params,
            function() {
                removeOverlayLoading('form.form-checkin, form.form-checkout');
            },
            function() {
                msgWarning(window.__trans('Vui lòng tải lại trang để cập nhật vị trí.'));
            },
            null
        );
    }

    $(document).ready(function() {
        addOverlayLoading('form.form-checkin, form.form-checkout');
        currentLocation();
    });

    $(document).on('submit', '.form-checkin, .form-checkout', function(e) {
        e.preventDefault();
        resetAjaxFormLibrary();
        AjaxFormLibrary.target = $(this);
        AjaxFormLibrary.success = function(response) {

            if (response.status == 400) {
                msgWarning(response.msg);
            } else {
                AjaxFormLibrary.target.remove();
                msgSuccess(response.msg);
            }

            if (this.getLoadDatatable()) {
                this.handleLoadDatatable();
            }
        };
        AjaxFormLibrary.ajaxRequest();
    })







</script>
