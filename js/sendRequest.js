//  функція відправлення запиту
const sendRequest = (data, currTab = "") => {
    if(currTab !== ""){
        redirect(currTab);
        location.reload(true);
    }
    $.ajax({
        url: `/request_api.php`,
        type: "POST",
        data: JSON.parse(JSON.stringify(data)),    
        success: function (response) {
            //alert("Все пройшло вдало!");
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
    });
}