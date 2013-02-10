stable-marriage-problem
=======================

A PHP Class for use to solve the Stable Marriage Problem (http://en.wikipedia.org/wiki/Stable_marriage_problem).

Example usage
-------------
The Class needs to be passed four arguments; an array of "male" identifiers, an array of identifiers for potential "female" partners for the males, plus a list each of the peference order of parters for both the males and female. An example, identical to the one used on Rosetta Code (http://rosettacode.org/wiki/Stable_marriage_problem) can be found below:

    <?php
    require_once('stable_marriage_problem.class.php');

    $guys = array("abe","bob", "col", "dan", "ed", "fred", "gav", "hal", "ian", "jon");

    $girls = array("abi", "bea", "cath", "dee", "eve", "fay", "gay", "hope", "ivy", "jan");

    $guyPrefers = array(
        "abe" => array(
            "abi", "eve", "cath", "ivy", "jan", "dee", "fay", "bea", "hope", "gay"),
        "bob" => array(
            "cath", "hope", "abi", "dee", "eve", "fay", "bea", "jan", "ivy", "gay"),
        "col" => array(
            "hope", "eve", "abi", "dee", "bea", "fay", "ivy", "gay", "cath", "jan"),
        "dan" => array(
            "ivy", "fay", "dee", "gay", "hope", "eve", "jan", "bea", "cath", "abi"),
        "ed" => array(
            "jan", "dee", "bea", "cath", "fay", "eve", "abi", "ivy", "hope", "gay"),
        "fred" => array(
            "bea", "abi", "dee", "gay", "eve", "ivy", "cath", "jan", "hope", "fay"),
        "gav" => array(
            "gay", "eve", "ivy", "bea", "cath", "abi", "dee", "hope", "jan", "fay"),
        "hal" => array(
            "abi", "eve", "hope", "fay", "ivy", "cath", "jan", "bea", "gay", "dee"),
        "ian" => array(
            "hope", "cath", "dee", "gay", "bea", "abi", "fay", "ivy", "jan", "eve"),
        "jon" => array(
            "abi", "fay", "jan", "gay", "eve", "bea", "dee", "cath", "ivy", "hope"),
    );

    $girlPrefers = array(
        "abi" => array(
            "bob", "fred", "jon", "gav", "ian", "abe", "dan", "ed", "col", "hal"),
        "bea" => array(
            "bob", "abe", "col", "fred", "gav", "dan", "ian", "ed", "jon", "hal"),
        "cath" => array(
            "fred", "bob", "ed", "gav", "hal", "col", "ian", "abe", "dan", "jon"),
        "dee" => array(
            "fred", "jon", "col", "abe", "ian", "hal", "gav", "dan", "bob", "ed"),
        "eve" => array(
            "jon", "hal", "fred", "dan", "abe", "gav", "col", "ed", "ian", "bob"),
        "fay" => array(
            "bob", "abe", "ed", "ian", "jon", "dan", "fred", "gav", "col", "hal"),
        "gay" => array(
            "jon", "gav", "hal", "fred", "bob", "abe", "col", "ed", "dan", "ian"),
        "hope" => array(
            "gav", "jon", "bob", "abe", "ian", "dan", "hal", "ed", "col", "fred"),
        "ivy" => array(
            "ian", "col", "hal", "gav", "fred", "bob", "abe", "ed", "jon", "dan"),
        "jan" => array(
            "ed", "hal", "gav", "abe", "bob", "jon", "col", "ian", "fred", "dan"),
        );

    $Stable_Marriage = new Stable_Marriage($guys, $girls, $guyPrefers, $girlPrefers);

    echo 'Matches';
    echo '<pre>';
    var_dump($Stable_Marriage->matches);
    echo '</pre>';
    echo 'Test';
    echo '<pre>';
    $Stable_Marriage->test();
    echo '</pre>'; ?>