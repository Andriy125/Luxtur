
// додавання обробників івентів
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
    $('#orders').click();
});

// закриття меню
const CloseMenu = () => {
    $('.side_menu').toggleClass('active', false);
}

// відображення контенту після натискання на пункт меню 
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

const sortTable = (table, sort_by) => {
    let sortedRows = Array.from(table.rows)
    .slice(1)
    .sort((rowA, rowB) => rowA.cells[sort_by].innerHTML > rowB.cells[sort_by].innerHTML ? 1 : -1);  
    table.tBodies[0].append(...sortedRows);
}

const filterTrByClass = (filter_by, where) => {
    $(`${where} tr.all`).css('display', 'none');
    $(`${where} tr.${filter_by}`).css('display', 'table-row');
}

document.querySelectorAll('.update_review_showing').forEach(el => {
    el.addEventListener("click", (e) => {
        let form = e.target.closest('.update_review');
        let id = form.elements.id.value;
        let column = "show_review";
        let is_showing = $(form.is_showing).prop("checked");
        updateRequest("review", id, column, is_showing);
    })
});

document.querySelectorAll('.update_order_done').forEach(el => {
    el.addEventListener("click", (e) => {
        let form = e.target.closest('.update_order');
        let id = form.elements.id.value;
        let column = "done";
        let order_done = $(form.order_done).prop("checked");
        updateRequest("orders", id, column, order_done);
    })
});

const deleteReview = (el, id) => {
    $(el).remove();
    deleteRequest(id, "review");
}

const deleteRequest = (id, table_name) => {
    let data = {};
    data["id"] = id;
    data["table"] = table_name;
    data["delete"] = true;
    sendRequest(data);
}

const updateRequest = (table_name, id, column, value) => {
    let data = {};
    data["id"] = id;
    data["update"] = true;
    data["table"] = table_name;
    data["value"] = value;
    data["column"] = column;
    sendRequest(data);
}


document.querySelector('.filter_review').addEventListener("change", (e)=>{
    e.preventDefault();
    let filter_by = e.target.value;
    filterTrByClass(filter_by, '.review_table');
});

document.querySelector('.sort_review').addEventListener("change", (e)=>{
    let table = document.querySelector('.review_table');
    let sort_by = e.target.selectedIndex;
    sortTable(table, sort_by);
});