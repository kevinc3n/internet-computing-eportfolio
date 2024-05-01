#!/usr/local/bin/php
<?php
    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['searchText'])) {

                $conn = mysqli_connect("mysql.cise.ufl.edu", "kcen", "yhp49bCe8CmpmJB", "Assignment_6");

                //SEE IF IT WORKED
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $searchText = htmlspecialchars($_POST['searchText']);
                $sql = "SELECT * FROM songs_table WHERE title LIKE '%$searchText%' ORDER BY Title ASC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $tableDataTotal .= "<tr>";
                        $tableDataTotal .= "<td class='dataHighlight dataFormat'> <strong> {$row['Title']} </strong> </td>";
                        $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Artist']} </td>";
                        $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Length']} </td>";
                        $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Genre']} </td>";
                        $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Year']} </td>";
                        $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Explicit']} </td>";
                    
                        $tableDataTotal .= "<td class='dataHighlight dataFormat edit-col'>
                        <div class='text-center'>
                        <button class='btn1' value='{$row['id']}' onclick='setEditSelectValue(\"{$row['id']}\")' style='font-size: 14px; padding: 5px 10px; color: #343a40; background-color: #f8f9fa; border-color: #f8f9fa;'> <i class='fas fa-edit'></i> </button>
                        <button class='btn1' value='{$row['id']}' onclick='setDeleteSelectValue(\"{$row['id']}\")' style='font-size: 14px; padding: 5px 10px; color: #343a40; background-color: #f8f9fa; border-color: #f8f9fa;'> <i class='fas fa-trash-alt'></i> </button>
                        </div>
                        </td>";      
                  
                        $tableDataTotal .= "</tr>";   
                    }
                }
                else {
                    $tableDataTotal = "";
                }

                $returnTable .= "<thead>";
                $returnTable .= "<tr>";
                $returnTable .= "<th class=\"headerHighlight dataFormat\"> Title </th>";
                $returnTable .= "<th class=\"headerHighlight dataFormat\"> Artist </th>";
                $returnTable .= "<th class=\"headerHighlight dataFormat\"> Length </th>";
                $returnTable .= "<th class=\"headerHighlight dataFormat\"> Genre(s) </th>";
                $returnTable .= "<th class=\"headerHighlight dataFormat\"> Year </th>";
                $returnTable .= "<th class=\"headerHighlight dataFormat\"> Explicit </th>";
                $returnTable .= "<th class=\"headerHighlight dataFormat\"> Quick Actions </th>";
                $returnTable .= "</tr>";
                $returnTable .= "</thead>";
                $returnTable .= "<tbody>";
                $returnTable .= $tableDataTotal;
                $returnTable .= "</tbody>";

                // SEND HTML BACK
                echo $returnTable;
            }
        }
    }
    else {
        header("Location: index.php");
        die("Unauthorized access! Please complete the original form to see this page.");
    }
?>