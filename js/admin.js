$(document).ready(function(){
    document.querySelector('.menu_icon').addEventListener('click', (e) => {
        $('.side_menu').toggleClass('active', true);
    })
    document.querySelector('.close_icon').addEventListener('click', (e) => {
        CloseMenu();
    })
    document.querySelectorAll('.side_menu__item').forEach((el) => {
        el.addEventListener('click', (e) => ShowContent(e, `id-${el.getAttribute('id')}`));
    });
    $('#main').click();
});

const CloseMenu = () => {
    $('.side_menu').toggleClass('active', false);
}

const ShowContent = (e, name) => {
    // Declare all variables
    let tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("side_menu__item");
    for (let i = 0; i < tablinks.length; i++) {
        $(tablinks[i]).toggleClass('active', false);
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(name).style.display = "block";
    $(e.currentTarget).toggleClass("active", true);
    $('.admin_main_title').html($(e.currentTarget).text());
    CloseMenu();
}