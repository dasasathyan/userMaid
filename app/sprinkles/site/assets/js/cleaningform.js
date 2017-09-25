$('#cleaningform').ufForm().on("submitSuccess.ufForm", function() {
      // Reload page on success

      $(function() {
        $("#submitCleaning").click(function() {
var link = 'cleaning/book?format=json&cleaning_area=';
var cleaning = $("#cleaning_area").val();
window.location = link + cleaning;
});
});
    });
