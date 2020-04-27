//  функція відправлення запиту
const sendRequest = (data) => {
    $.ajax({
        url: `/request_api.php`,
        type: "POST",
        data: JSON.parse(JSON.stringify(data)),    
        success: function (response) {
            alert("Все пройшло вдало!");
            console.log(response);
            location.reload(true);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
    });
}