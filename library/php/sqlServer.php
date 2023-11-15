<?php
    function sqlTest() {
        echo "<script>alert(\"Hello World!\")</script>";
    }

    /**
     * loading data from a table
     */
    function sqlLoadData($sqlQuery) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        $result = mysqli_query($sqlConnection, $sqlQuery);
        
        $sqlConnection->close();

        return $result;
    }  

    /**
     * saves data to table
     */
    function sqlSaveData($data) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        
        
        $sqlConnection->close();
    }

?>