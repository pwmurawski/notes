<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

function dump($data): void {
    echo '<br/><div style="
        display: inline-block;
        padding: 10px 20px;
        margin: 5px;
        border-radius: 20px;
        background-color: whitesmoke;
        box-shadow: 0 1px 3px 0 black;
    ">
    <pre>';
    print_r($data);
    echo '</pre>
    </div>
    <br/>';
}