
const sendRequest = (data, currTab = "") => {
    //  send request to server
    $.ajax({
        url: `/request_api.php`,
        type: "POST",
        data: JSON.parse(JSON.stringify(data)),    
        success: function (response) {
            if(currTab !== ""){
                //  save current tab to local storage
                redirect(currTab);
                //  reload page
                location.reload(true);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
    });
}