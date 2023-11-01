import './bootstrap';
import '../sass/app.scss'
import '../css/app.css';
import jQuery from 'jquery';
window.$ = jQuery;


$('#importButton').on('change', function () {
    alert('hidden');
});


function fetch_customer_data(query = '') {
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
function setActiveNavItem() {
    var lastClickedItem = localStorage.getItem('lastClickedNavItem');
    console.log(lastClickedItem);
    if (lastClickedItem) {
        $("#navbarSupportedContent ul li").removeClass("active");
        $("#" + lastClickedItem).addClass("active");
    } else {
        $("#navbarSupportedContent ul li:first-child").addClass("active");
    }
    updateNavbarUnderline();
}
$("#navbarSupportedContent").on("click", "li", function(e) {
    $("#navbarSupportedContent ul li").removeClass("active");
    $(this).addClass("active");

    // Save to local storage. It assumes that your <li> items have unique IDs.
    localStorage.setItem('lastClickedNavItem', $(this).attr('id'));
    updateNavbarUnderline();
});
$(window).on('load', function() {
    setActiveNavItem();
});
function updateNavbarUnderline() {
    var activeItem = $("#navbarSupportedContent .nav-item.active");
    var itemPosition = activeItem.position();
    var itemWidth = activeItem.innerWidth();
    var itemHeight = activeItem.innerHeight();

    $(".hori-selector").css({
        top: itemPosition.top + "px",
        left: itemPosition.left + "px",
        width: itemWidth + "px",
        height: itemHeight + "px"
    });
}

$(window).on('load resize', updateNavbarUnderline);
$(".navbar-toggler").on('click', function() {
    setTimeout(updateNavbarUnderline, 10); // assuming the slideToggle duration is 300ms
});

