$('#drivingform').ufForm().on("submitSuccess.ufForm", function() {
      // Reload page on success

      $(function() {
        $("#submitDriving").click(function() {
var link = 'driving/book?format=json&driving_area=';
var driving = $("#driving_area").val();
window.location = link + driving;
});
});
    });
