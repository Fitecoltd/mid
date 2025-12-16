<?php

function debug()
{
    //        return true; /// Test mode
    return isset($_REQUEST['debug']);
}

function test()
{
    //        return true; /// Test mode
    return isset($_REQUEST['test']);
}
