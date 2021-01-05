<?php
session_start();
date_default_timezone_set("Asia/Seoul");

$con = new PDO(
    "mysql:host=;
    dbname=;
    charset=utf8mb4", "", "");

function query($con, $sql, $param = []){
    $q = $con->prepare($sql);
    $cnt = $q->execute($param);
    return $cnt;
}

function fetch($con, $sql, $param = []){
    $q = $con->prepare($sql);
    $q->execute($param);
    return $q->fetch(PDO::FETCH_OBJ);
}

function fetchAll($con, $sql, $param = []){
    $q = $con->prepare($sql);
    $q->execute($param);
    return $q->fetchAll(PDO::FETCH_OBJ);
}

function msgAndGo($msg, $link){
    echo "<script>";
    echo "alert('$msg');";
    echo "location.href='$link';";
    echo "</script>";
}

function msgAndBack($msg){
    echo "<script>";
    echo "alert('$msg');";
    echo "history.back();";
    echo "</script>";
}

function msg($msg) {
    echo "<script>";
    echo "alert('$msg');";
    echo "</script>";
}

function move($link) {
    echo "<script>";
    echo "location.href='$link';";
    echo "</script>";
}

function dump($var) { 
    echo "<pre>";
    var_dump($var);
    echo "</pre>";   
}