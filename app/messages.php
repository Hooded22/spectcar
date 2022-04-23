<?php
    include_once "classes/Page.php";
    include_once "classes/Db.php";
    Page::display_header("messages");
    $db = new Db("localhost", "root", "", "integracja");
    // adding new message
?>
<!---------------------------------------------------------------------->
<hr>
<P> Transactions</P>
<ol>
    <?php
		 $sql = "SELECT * from transactions";
		 $messages = $db->select($sql);
		 foreach ($messages as $msg)://returned as objects
		 echo "<li>";
		 //echo $msg->id;
		 echo $msg->client_first_name;
		 echo " ";
		 echo $msg->client_last_name;
		 echo " ";
		 echo $msg->client_age;
		 echo " ";
		 echo $msg->client_gender;
		 echo " ";
		 echo $msg->transaction_city;
		 echo " ";
		 echo $msg->transaction_date;
		 echo " ";
		 echo $msg->car_price;
		 echo " ";
		 echo $msg->car_model;
		 echo " ";
		 echo $msg->car_make;
		 echo " ";
		 echo $msg->car_model_year;
		 echo " ";
		 echo $msg->car_color;
		 echo " ";
		 
		 echo "</li>";
		 endforeach;
    ?>
</ol>
<!---------------------------------------------------------------------->
<hr>
<P>Navigation</P>
<?php
    Page::display_navigation();
?>
    </body>
</html>