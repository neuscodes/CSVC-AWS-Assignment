<a href="query.php">Pick another query</a>
 
 <?php
 
        //Query for childhood mortality rate
        $sql = "select name, mortalityunder5 from countrydata_final;";
        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //echo "success";
            echo '<table style="width: 80%">';
            echo '<tr>';
            echo '<th style="text-align:left">Country Name</th>';
            echo '<th style="text-align:left">Childhood Mortality</th>';
            echo '</tr>';
            
            while($row = $result->fetch_assoc()) {
            //echo '<p>';
           
            echo '<tr>';
            echo '<td>';
            echo $row["name"];
            echo '&nbsp';
            echo '<td>';
            echo $row["mortalityunder5"];
            echo '&nbsp';
            echo '<br>';
            echo '</tr>';
            }
            echo '</table>';
                                                }
                                        
    ?>