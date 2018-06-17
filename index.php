<?php
require 'DbConn.php';
$c = new Conn();
$conn = $c->DbConn();
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $api_key = $_GET["key"];
    $query = "SELECT * FROM api_keys WHERE api_key = :key";
    $pdostm = $conn->prepare($query);
    $pdostm->bindValue(':key', $api_key, PDO::PARAM_STR);
    $pdostm->execute();
    $count = count($pdostm->fetchAll());
    if($count == 1) {
        $header = (object) ['Code' => '200', 'Message' => 'OK'];
        header("HTTP/1.1 200 OK");
        if(isset($_GET["position"]) && isset($_GET["team"]) && isset($_GET["year"])) {
            $pos = strtoupper($_GET["position"]);
            $team = $_GET["team"];
            $year = $_GET["year"];
            $query = "SELECT * FROM hof WHERE team LIKE :team AND position LIKE :pos AND year_in LIKE :year";
            $pdostm = $conn->prepare($query);
            $pdostm->bindValue(':pos', "%$pos%", PDO::PARAM_STR);
            $pdostm->bindValue(':team', "%$team%", PDO::PARAM_STR);
            $pdostm->bindValue(':year', "%$year%", PDO::PARAM_STR);
            $pdostm->execute();
            $results = $pdostm->fetchAll(PDO::FETCH_OBJ);
        } else if(isset($_GET["position"]) && isset($_GET["team"])) {
            $pos = strtoupper($_GET["position"]);
            $team = $_GET["team"];
            $query = "SELECT * FROM hof WHERE team LIKE :team AND position LIKE :pos";
            $pdostm = $conn->prepare($query);
            $pdostm->bindValue(':pos', "%$pos%", PDO::PARAM_STR);
            $pdostm->bindValue(':team', "%$team%", PDO::PARAM_STR);
            $pdostm->execute();
            $results = $pdostm->fetchAll(PDO::FETCH_OBJ);
        } else if(isset($_GET["position"]) && isset($_GET["year"])) {
            $pos = strtoupper($_GET["position"]);
            $year = $_GET["year"];
            $query = "SELECT * FROM hof WHERE year_in LIKE :year AND position LIKE :pos";
            $pdostm = $conn->prepare($query);
            $pdostm->bindValue(':pos', "%$pos%", PDO::PARAM_STR);
            $pdostm->bindValue(':year', "%$year%", PDO::PARAM_STR);
            $pdostm->execute();
            $results = $pdostm->fetchAll(PDO::FETCH_OBJ);
        } else if(isset($_GET["year"]) && isset($_GET["team"])) {
            $year = $_GET["year"];
            $team = $_GET["team"];
            $query = "SELECT * FROM hof WHERE team LIKE :team AND year_in LIKE :year";
            $pdostm = $conn->prepare($query);
            $pdostm->bindValue(':year', "%$year%", PDO::PARAM_STR);
            $pdostm->bindValue(':team', "%$team%", PDO::PARAM_STR);
            $pdostm->execute();
            $results = $pdostm->fetchAll(PDO::FETCH_OBJ);
        } else if(isset($_GET["position"])) {
            $pos = strtoupper($_GET["position"]);
            $query = "SELECT * FROM hof WHERE position LIKE :pos";
            $pdostm = $conn->prepare($query);
            $pdostm->bindValue(':pos', "%$pos%", PDO::PARAM_STR);
            $pdostm->execute();
            $results = $pdostm->fetchAll(PDO::FETCH_OBJ);
        } else if(isset($_GET["team"])) {
            $team = $_GET["team"];
            $query = "SELECT * FROM hof WHERE team LIKE :team";
            $pdostm = $conn->prepare($query);
            $pdostm->bindValue(':team', "%$team%", PDO::PARAM_STR);
            $pdostm->execute();
            $results = $pdostm->fetchAll(PDO::FETCH_OBJ);
        } else if(isset($_GET["year"])) {
            $year = $_GET["year"];
            $query = "SELECT * FROM hof WHERE year_in LIKE :year";
            $pdostm = $conn->prepare($query);
            $pdostm->bindValue(':year', "%$year%", PDO::PARAM_STR);
            $pdostm->execute();
            $results = $pdostm->fetchAll(PDO::FETCH_OBJ);
        } 
        else {
            $results = $conn->query("SELECT * FROM hof")->fetchAll(PDO::FETCH_OBJ);
        }
    } else {
        $header = (object) ['Code' => '401', 'Message' => 'User is unauthorized, please enter API Key correctly'];
        header("HTTP/1.1 401 Unauthorized");
    }
    echo json_encode(array(
        'Status' => $header,
        'Results' => $results
    ));
}
catch(PDOException $e) {
    $header = (object) ['Code' => '500', 'Message' => 'Server Error, please try again'];
    echo json_encode(array(
        'Status' => $header,
        'Results' => $results
    ));
    die();
}
