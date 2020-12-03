<?php
$logMsg = "";
if(isset($_GET['ticketId'])){
  $ticketId = $_GET['ticketId'];

  $countOfTicket = $database->countOf("ticket","ticketId like '%$ticketId'");
  if($countOfTicket != 1){
    $_SESSION['bookTicketMsg'] = "Invalid Ticket Id!";
    $_SESSION['bookTicketStatus'] = 'error';
  }else{
    if(!isset($_SESSION['username'])){
      $_SESSION['bookTicketMsg'] = "Please login first to book a ticket";
      $_SESSION['bookTicketStatus'] = 'error';
    }else{
      $_SESSION['bookTicketMsg'] = "You are about to book a ticket!";
      $_SESSION['bookTicketStatus'] = 'success';
      
    }
  }

}

    if(isset($_SESSION['bookTicketStatus']) && isset($_SESSION['bookTicketMsg'])){
      if($_SESSION['bookTicketStatus'] === 'success'){
          $_SESSION['ticketId'] = $_GET['ticketId'];
          $_SESSION['bookTicketMsg'] = '<script>
          var r = confirm("Dear '.$_SESSION['username'].', please confirm booking the tocket!");
              if (r == true) {
                alert("You confirmed booking!");
                location.href = "http://localhost/tms/ticket.php";
                } else {
                alert("Your booking ticket cancelled!");
              }
          </script>';

      }else{
          $_SESSION['bookTicketMsg'] = '<script>bootbox.alert({title:"Booking Ticket Failed",message: "'.$_SESSION['bookTicketMsg'].'"});</script>';
      }
    }


  ?>
