<?php
/**
 *  A PHP Class to solving the Stable Marriage Problem
 *
 *  Problem description
 *  Given an equal number of men and women to be paired for marriage, each man ranks all the women in order of his preference and each women ranks all the men in order of her preference.
 *  A stable set of engagements for marriage is one where no man prefers a women over the one he is engaged to, where that other woman also prefers that man over the one she is engaged to. I.e. with consulting marriages, there would be no reason for the engagements between the people to change.
 *  Gale and Shapley proved that there is a stable set of engagements for any set of preferences and the first link above gives their algorithm for finding a set of stable engagements.
 *
 * This PHP Class is the PHP equivalent of the Java class that can be found at http://rosettacode.org/wiki/Stable_marriage_problem#Java
 *
 * @author     Thomas McGregor <leegleeders@yahoo.co.uk>
 */
class Stable_Marriage
{
    public $guys = array();
    public $girls = array();
    public $guyPrefers = array();
    public $girlPrefers = array();

    public $matches = array();

    /**
     * Constructor
     * @param array $guys        List of all men involved in the problem
     * @param array $girls       List of all women involved in the problem
     * @param array $guyPrefers  Ordered list of female partners for each male
     * @param array $girlPrefers Ordered list of male partners for each female
     */
    public function __construct($guys, $girls, $guyPrefers, $girlPrefers)
    {
        $this->guys        = $guys;
        $this->girls       = $girls;
        $this->guyPrefers  = $guyPrefers;
        $this->girlPrefers = $girlPrefers;

        $this->matches     = $this->match();
    }

    /**
     * Match most suitable engagements between each male and female
     * @return array List of engagements
     */
    public function match()
    {
        $engagedTo = array();
        $freeGuys = $this->guys;

        while (!empty($freeGuys)) {
            $thisGuy = array_shift($freeGuys); //get a load of THIS guy
            $thisGuyPrefers = $this->guyPrefers[$thisGuy];

            foreach ($thisGuyPrefers as $girl) {
                if (!isset($engagedTo[$girl])) { //girl is free
                    $engagedTo[$girl] = $thisGuy; //awww
                    break;
                } else {
                    $otherGuy = $engagedTo[$girl];
                    $thisGirlPrefers = $this->girlPrefers[$girl];

                    if (array_search($thisGuy, $thisGirlPrefers) < array_search($otherGuy, $thisGirlPrefers)) { //this girl prefers this guy to the guy she's engaged to
                        $engagedTo[$girl] = $thisGuy;
                        $freeGuys[] = $otherGuy;
                        break;
                    } //else no change...keep looking for this guy
                }
            }
        }

        return $engagedTo;
    }

    /**
     * Verify the marriages are stable
     * @return boolean Are the marriages stable?
     */
    public function checkMatches()
    {
        if (count(array_intersect($this->girls, array_keys($this->matches))) != count($this->matches)) {
            return false;
        }

        if (count(array_intersect($this->guys, $this->matches)) != count($this->matches)) {
            return false;
        }

        $invertedMatches = array();
        foreach ($this->matches as $female => $male) {
            $invertedMatches[$male] = $female;
        }

        foreach ($this->matches as $female => $male) {
            $shePrefers = $this->girlPrefers[$female];
            $sheLikesBetter = array_slice($shePrefers, array_search($male, $shePrefers));

            $hePrefers = $this->guyPrefers[$male];
            $heLikesBetter = array_slice($hePrefers, array_search($female, $hePrefers));

            foreach ($sheLikesBetter as $girl => $guy) {
                $guysFiance = $invertedMatches[$guy];

                $thisGuyPrefers = $this->guyPrefers[$guy];

                if (array_search($guysFiance, $thisGuyPrefers) < array_search($girl, $thisGuyPrefers)) {
                    printf("%s likes %s better than %s and %s likes %s better than their current partner\n", $girl, $guy, $male, $guy, $female);
                    return false;
                }
            }

            foreach ($heLikesBetter as $guy => $girl) {
                $girlsFiance = $this->matches[$girl];
                $thisGirlPrefers = $this->girlPrefers[$girl];

                if (array_search($girlsFiance, $thisGirlPrefers) < array_search($guy, $thisGirlPrefers)) {
                    printf("%s likes %s better than %s and %s likes %s better than their current partner\n", $guy, $girl, $female, $girl, $male);
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Test method - Complete table engagements, swap two partners, check if marriages are stable
     * @return NULL
     */
    public function test()
    {
        foreach ($this->matches as $female => $male) {
            print "{$male} is engaged to {$female}\r\n";
        }

        if ($this->checkMatches()) {
            print "Marriages are stable\r\n";
        } else {
            print "Marriages are unstable\r\n";
        }

        $tmp = $this->girls[0];
        $this->matches[$this->girls[0]] = $this->matches[$this->girls[1]];
        $this->matches[$this->girls[1]] = $tmp;

        print "{$this->girls[0]} and {$this->girls[1]} have swapped partners\r\n";

        if ($this->checkMatches()) {
            print "Marriages are stable\r\n";
        } else {
            print "Marriages are unstable\r\n";
        }
    }
}