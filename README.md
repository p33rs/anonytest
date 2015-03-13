## sup

Some code snippets produced for what I assure my current employer is no reason whatsoever.

### code parser

Take a set of zoning district codes from our fair city's byzantine Zoning Resolution and produce the
list of human-readable categories that each belongs to.
Had to handle some interesting ambiguities here when it came to the code formatting, but this should
be generally reliable. Regex may have been a heavy-handed move, since some of these codes are simple
strings. But the alternative (defining comparison methods for each code) would have been overkill.

### array analyzer

Identify sets of consecutive numbers in an array.
More difficult than originally anticipated, because of possible overlapping:

    1  ^
    2  ^
    3  ^  v
    2     v
    1  ^  v
    2  ^
    3  ^

It was necessary to track ascending trends and descending trends separately.
I have arrived at a solution which is simple, but inelegant.

### website scraper

This was difficult because we are presented with the farthest thing from a REST interface imaginable.
Part of me is afraid I missed API documentation in the FAQ pages or something.
Interesting, since one assumes that dealing with uncooperative government websites comes standard
with the position.
Tried to make it easy to add other scrapers (for Building and Plumbing permits) at a later date.

## setup

Question 1 and 2 use phpunit tests.
Question 3 will require composer and [php-dom](http://php.net/manual/en/book.dom.php).

## invocation

The scripts are run from the command line:

    php question_1/run.php question_1/input.txt
    php question_2/run.php question_2/input.php
    php question_3/run.php --block 259 --lot 26

