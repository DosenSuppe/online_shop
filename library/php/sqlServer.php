<?php
    function sqlTest() {
        echo "<script>alert(\"Hello World!\")</script>";
    }

    /**
     * DEPRICATED
     * loading data from a table
     */
    function sqlLoadData($sqlQuery) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        $result = mysqli_query($sqlConnection, $sqlQuery);
        
        $sqlConnection->close();

        return $result;
    }  

    /**
     * DEPRICATED
     * saves data to table
     */
    function sqlSaveData($sqlQuery) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        $result = mysqli_query($sqlConnection, $sqlQuery);
        
        $sqlConnection->close();

        return $result;
    }


    /**
     * 
     * PLEASE MIGRATE TO THIS FUNCTION!
     * 
     * executes a mysql query
     */
    function sqlExecute($sqlQuery) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        $result = mysqli_query($sqlConnection, $sqlQuery);
        
        $sqlConnection->close();

        return $result;
    }

?>