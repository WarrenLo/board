<?php
  function alert_and_location($alert, $location){
    echo "<script>alert('" . $alert . "')</script>";
    echo "<script>window.location = '" . $location ."'</script>";
  }
?>
