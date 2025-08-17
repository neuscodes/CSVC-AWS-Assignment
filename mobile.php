 <a href="query.php">Pick another query</a>
 
 <?php
        //Query to get the GDP
        $sql = "select name, mobilephones from countrydata_final;";
       
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            
            echo '<table style="width: 80%">';
            echo '<tr>';
            echo '<th style="text-align:left">This is a Country Name</th>';
            echo '<th style="text-align:left">Number of mobile phone providers</th>';
            echo '</tr>';
            
            while($row = $result->fetch_assoc()) {
          
            echo '<tr>';
            echo '<td>';
            echo $row["name"];
            echo '&nbsp';
            echo '<td>';
            echo $row["mobilephones"];
            echo '&nbsp';
            echo '<br>';
            echo '</tr>';
            }
            echo '</table>';
                                                }
                                        
    ?>