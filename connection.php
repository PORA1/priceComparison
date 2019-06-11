<?php
$currency = 'Ksh: '; //Currency Character or code
$shipping_cost      = 1.50; //shipping cost
$taxes              = array( //List your Taxes percent here.
                            'VAT' => 16, 
                            'Service Tax' => 5
                            );				
$connection = mysqli_connect("localhost","Maritime","MayCry1996","compareprices") or die("unable to connect");

?>
