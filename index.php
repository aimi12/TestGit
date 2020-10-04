<!doctype html>
<html>
    <head>
        <title>Change number of rows show in the Pagination using PHP</title>
        <link href="style.css" type="text/css" rel="stylesheet">
        <script src="jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="script.js" type="text/javascript"></script>
        <?php
            include("config.php");

            $row = 0;

            // number of rows per page
            $rowperpage = 5;
            if(isset($_POST['num_rows'])){
                $rowperpage = $_POST['num_rows'];
            }

            // Previous Button
            if(isset($_POST['but_prev'])){
                $row = $_POST['row'];
                $row -= $rowperpage;
                if( $row < 0 ){
                    $row = 0;
                }
            }

            // Next Button
            if(isset($_POST['but_next'])){
                $row = $_POST['row'];
                $allcount = $_POST['allcount'];

                $val = $row + $rowperpage;
                if( $val < $allcount ){
                    $row = $val;
                }
            }
        ?>
    </head>
    <body>
    <div class="container">

        <table width="100%" id="emp_table" border="0">
            <tr class="tr_header">
                <th>S.no</th>
                <th>Name</th>
                <th>Salary</th>
            </tr>
            <?php
            // count total number of rows
            $sql = "SELECT COUNT(*) AS cntrows FROM employee";
            $result = mysqli_query($con,$sql);
            $fetchresult = mysqli_fetch_array($result);
            $allcount = $fetchresult['cntrows'];

            // selecting rows
            $sql = "SELECT * FROM employee  ORDER BY ID ASC limit $row,".$rowperpage;
            $result = mysqli_query($con,$sql);
            $sno = $row + 1;

            while($fetch = mysqli_fetch_array($result)){
                $name = $fetch['emp_name'];
                $salary = $fetch['salary'];
                ?>
                <tr>
                    <td align='center'><?php echo $sno; ?></td>
                    <td align='center'><?php echo $name; ?></td>
                    <td align='center'><?php echo $salary; ?></td>
                </tr>
            <?php
                $sno ++;
            }
            ?>
        </table>

        <!-- Pagination control -->
        <form method="post" action="" id="form">
            <div id="div_pagination">
                <input type="hidden" name="row" value="<?php echo $row; ?>">
                <input type="hidden" name="allcount" value="<?php echo $allcount; ?>">
                <input type="submit" class="button" name="but_prev" value="Previous">
                <input type="submit" class="button" name="but_next" value="Next">

                <!-- Number of rows -->
                <div class="divnum_rows">
                <span class="paginationtextfield">Number of rows:</span>&nbsp;
                <select id="num_rows" name="num_rows">
                    <?php
                    $numrows_arr = array("5","10","25","50","100","250");
                    foreach($numrows_arr as $nrow){
                        if(isset($_POST['num_rows']) && $_POST['num_rows'] == $nrow){
                            echo '<option value="'.$nrow.'" selected="selected">'.$nrow.'</option>';
                        }else{
                            echo '<option value="'.$nrow.'">'.$nrow.'</option>';
                        }
                    }
                    ?>
                </select>
                </div>
            </div>
        </form>

    </div>
    </body>
</html>
