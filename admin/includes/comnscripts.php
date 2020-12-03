<!-- It is recommended to put javascript files at the end of the page, because it increases the page load speed -->
<!-- Jquery (it should be before bootstrap js file)-->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- the slim version of jquerey-3.3.1 removed the depricated functions and excluded the ajax and effect modules -->
<!-- jQuery plugin -->
<script src="plugins/jQuery-3.4.1/jquery.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap uses propper.js file from https://popper.js.or, there we should either includes its cdn links or include it manually
Bootstrap 4 use jQuery and Popper.js for JavaScript components (like modals, tooltips, popovers etc). However, if you just use the CSS
part of Bootstrap, you don't need them.-->
<script src="plugins/propper/propper.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/Bootstrap-4-4.1.1/js/bootstrap.js"></script>
<script src="plugins/Bootstrap-4-4.1.1/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- bootbox script for pop up alert -->
<script src="plugins/bootbox/bootbox.min.js"></script>
<script src="plugins/bootbox/bootbox.locales.min.js"></script>

<!-- data tables and reports plugins-->
<script src="plugins/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script src="plugins/DataTables-1.10.20/js/dataTables.bootstrap4.js"></script>
<script src="plugins/Buttons-1.6.1/js/dataTables.buttons.min.js"></script>
<script src="plugins/Buttons-1.6.1/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/JSZip-2.5.0/jszip.js"></script>
<script src="plugins/pdfmake-0.1.36/pdfmake.js"></script>
<script src="plugins/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="plugins/Buttons-1.6.1/js/buttons.html5.js"></script>
<script src="plugins/Buttons-1.6.1/js/buttons.print.js"></script>
<script src="plugins/Buttons-1.6.1/js/buttons.colVis.js"></script>

<!-- Charts -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- data table report buttons -->
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>

<script src="dist/js/script.js"></script>
<script>
/* input file (picture)*/
$(document).ready(function () {
  bsCustomFileInput.init()
});
/* text editor */
$(function () {
  // Summernote
  $('.textarea').summernote()
});

/* function for deleting the record */
function deleteRecord(id,url,status) {
  var value = window.confirm("Are you sure! You want to delete selected item?");
  console.log(id);
  if(value === true) {
    $.ajax({
      url: url,
      type: "POST",
      data:'id='+id,
      success: function(data){
        alert('Record has been deleted successfully!');
        window.location = "<?php echo $_SERVER['PHP_SELF']; ?>";
      }
      });
  } else {
    // Do something else
    alert('The record deletion has been cancelled!');
    console.log("There is an error! Please try again");
  }
}
/* data table primary functin to load the data table and display the sorting and search option */
$(function () {
  $("#dataTable").DataTable();
});

// changing the color of clicked row in datable
$("tbody tr").on("click", function(){
    $("tr").removeClass("activeRow");
    $(this).toggleClass('activeRow');
});

/* select 2 function*/
  $(function () {
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })

</script>
