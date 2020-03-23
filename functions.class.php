<?php

require_once "db.class.php";

class Functions {

    static function html_header($title = "Untitled") {
        $bgImage = BG_IMAGE;
        $string = <<<END
	<!DOCTYPE html>
	
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>$title</title>
		
		<!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		
	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	
		<meta name="viewport" content="width=device-width, initial-scale=1">
END;
        if ($bgImage != "none") {
            $string .= <<<END
	    <style>
            body {
                /*noinspection CssUnknownTarget*/
                background: url('{$bgImage}') no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
                -o-background-size: cover;
            }
        </style>
END;
        }
        $string .= <<<END
	</head>
	<body class="text-center">
END;
        echo $string;
    } // End html_header()

    static function html_footer($text = "") {
        return "\n$text\n</div></body>\n</html>";
    }// End html_footer()


    static function isAnyoneBusy() {
        $db = new DB();
        $data = $db->getAllRowsFromTable("*", "status","");
        $busy = 0;

        foreach ($data as $row) {
            if ($row['status'] != 0) {
                $busy++;
            }
        }

        if ($busy == 0) {
            return "<div class='alert-success' style='height: 100%'><h1 class='display-1'>All Clear!</h1></div>";
        } else if ($busy == 1) {
            return "<div class='alert-danger' style='height:100%'><h1 class='display-1'>Quiet Please!</h1><h3 class='display-4'>There is $busy person working.</h3></div>";
        } else {
            return "<div class='alert-danger' style='height: 100%'><h1 class='display-1'>Quiet Please!</h1><h3 class='display-4'>There are $busy people working.</h3></div>";
        }
    }

    static function buildTable() {
        $db = new DB();
        $data = $db->getAllRowsFromTable("*", "status","");
        $table = "<div class='pb-2 container-fluid col-sm-12 table-responsive'><table class='table table-striped'>\n<thead class='thead-dark'><tr><th>House Member</th><th>Status (Tap to change)</th></tr></thead>";
        foreach ($data as $row) {
            $member = $row['member'];
            $status = $row['status'];

            $table .= "<tr><td><h2>$member</h2></td>";
            switch ($status) {
                case 0:
                    $table .= "<td><form action='{$_SERVER['REQUEST_URI']}' method='post'><input name='id' type='hidden' value='$member'><button style='width:100%' class='btn btn-large btn-success' name='button' value='setToBusy'>Free</button></form></div></td>";
                    break;
                case 1:
                    $table .= "<td class='danger'><form action='{$_SERVER['REQUEST_URI']}' method='post'><input name='id' type='hidden' value='$member'><button style='width:100%; height:100%' class='btn btn-large btn-danger' name='button' value='setToFree'>Busy</button></form></div></td>";
                    break;
            }
            $table .= "</tr>";
        }

        echo $table;

    }

    static function setToBusy($id) {
        $db = new DB();
        $db->setStatus($id, 1);
    }

    static function setToFree($id) {
        $db = new DB();
        $db->setStatus($id, 0);
    }
}