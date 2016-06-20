<?php session_start(); ?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/style.css">
        <title>Pizzeria</title>
    </head>
    <h1 class="pizzeria">Pizzeria</h1>
    <div class="horizBar"></div>
    <br>
    <div class="fixed">
        <form action="index.php">
            <input type="submit" value="Return">
        </form>
    </div>
    <div class="rightFix">
        <form style="float: right" action="Cart.php" method="">
            <input type="submit" value="Cart">
        </form>
    </div>
