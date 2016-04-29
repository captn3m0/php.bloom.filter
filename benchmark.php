<?php
require "vendor/autoload.php";

use Razorpay\BloomFilter\Bloom;

define("NL", "\n");

function get_stat()
{
    return array(
    'memory' => memory_get_usage(),
    'timestamp' => gettimeofday(true)
    );
}
function advantage($koef)
{
    if ($koef < 1) {
        echo '<span style="color:green">advantage <strong>'.(1/$koef).'</strong> times</span>', NL;
    } else {
        echo '<span style="color:red">disadvantage <strong>'.$koef.'</strong> times</span>', NL;
    }
}
function lnk($number)
{
    echo ' # <a href="?number='.$number.'">'.$number.'</a> # ';
}

require "benchmarks/counter.php";
require "benchmarks/default.php";
require "benchmarks/deceze.php";
