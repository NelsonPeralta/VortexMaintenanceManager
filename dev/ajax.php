<?php
    require_once("action/AjaxAction.php");

    $controler = new AjaxAction();
    $data = $controler->execute();

    echo json_encode($data);