import './bootstrap';
import '../sass/app.scss';
import '../css/app.css';
import jQuery from 'jquery';
window.$ = jQuery;
function fetch_customer_data(query) {
    $.ajax
        ({
            url: "show",
            method: 'GET',
            data: {
                query: query
            },
            dataType: 'json',
            success: function (data) {
                $('#message').val(data.message);
                $('#sender_id').val(data.sender_id);
            }
        })
}

$('#countries').on('change', function () {
    var query = this.value;
        fetch_customer_data(query);
});
(() => {
    'use strict'
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(tooltipTriggerEl => {
      new bootstrap.Tooltip(tooltipTriggerEl)
    })
  })();
