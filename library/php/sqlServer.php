<?php

    /**
     * loading data from a table
     */
    function sqlLoadData($tableName, $dataConfig, $orderConfig, $limitConfig) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        
        
        $sqlConnection->close();
    }  

    /**
     * saves data to table
     */
    function sqlLoadData($tableName, $data) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        
        
        $sqlConnection->close();
    }

?>