var AjaxLibrary = {
    // Hàm tiện ích chung để thực hiện các yêu cầu AJAX
    ajaxRequest: function(url, method, data, successCallback, errorCallback, completeCallback) {
        $.ajax({
            url: url,
            type: method,
            data: data,
            // contentType: method === 'GET' ? 'application/x-www-form-urlencoded; charset=UTF-8' : 'application/json; charset=utf-8',
            success: function(response) {
                if (successCallback) {
                    successCallback(response);
                }
            },
            error: function(response) {
                if (errorCallback) {
                    errorCallback(response);
                }else {
                    handleAjaxError(response);
                }
            },
            complete: function(response) {
                if(completeCallback){
                    completeCallback(response)
                }
            }
        });
    },
    // Hàm gửi yêu cầu GET
    get: function(url, params, successCallback, errorCallback, completeCallback) {
        this.ajaxRequest(url, 'GET', params, successCallback, errorCallback, completeCallback);
    },

    // Hàm gửi yêu cầu POST
    post: function(url, params, successCallback, errorCallback, completeCallback) {
        this.ajaxRequest(url, 'POST', params, successCallback, errorCallback, completeCallback);
    },

    // Hàm gửi yêu cầu PUT
    put: function(url, params, successCallback, errorCallback, completeCallback) {
        this.ajaxRequest(url, 'PUT', params, successCallback, errorCallback, completeCallback);
    },

    // Hàm gửi yêu cầu DELETE
    delete: function(url, params, successCallback, errorCallback, completeCallback) {
        this.ajaxRequest(url, 'DELETE', params, successCallback, errorCallback, completeCallback);
    }
};