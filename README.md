# informa FizzBuzz

[![Build Status](https://travis-ci.org/mark-newman/informa-fizzbuzz.svg?branch=master)](https://travis-ci.org/mark-newman/informa-fizzbuzz)

### Getting started

After cloning the repo run the below to install the dependencies.

```shell
composer install
```
If you do not have composer installed locally let me know and I will commit a phar to the repo.

### Tags

There are four tags pushed to the repo: step1, step2, step3 and step3-rafactored which represent the completion of
each step in the test, plus a refactored final version. You can just checkout to each tag to check the code at that 
time and run the tests. The refactored version isn't a perfect solution, there are still improvements and todos
in there, it's just a slightly cleaner version than step 3 with a repeating loop removed and some minor refactoring. 

### Testing

Once the dependencies are installed you can run the unit tests against each tag with the below command.

```shell
bin/phpunit -c app
```
If you have any issues here it could be related to your command line PHP version. If you'd like
me to add a docker container to the repo just let me know, that way we can be certain it will be
the same for everyone.

The console command can be run using the below which will then prompt you for the start and end
values for the range you wish to FizzBuzz.

```shell
php app/console app:fizzbuzz
```

### Travis CI
I've set up a basic travis.yml so that the tests are run when pushes are made to master and included the Markdown
at the top of the README to show the build status.

### Approach

My approach evolved through the 3 steps so that the end step was very different to the first (good test!).
The final result has a more abstract string replacement method which has the triggers injected to make it more
reusable and extensible. I switched to that approach after the 'lucky' part of the test which made me realise I was
too fixed on modding the numbers. It now uses closures which means it's a simple change to add new rules for a given range. 

### Comments

The description from the recruitment consultant mentioned to use Symfony2 for this test, so I have
used 2.8 which is the current LTS version. The test document itself suggests a much more stripped back solution
so I wasn't sure whether to use the framework or not. I decided if I was going to use it I should use
it properly so FizzBuzz has been created as a service and also as a console command dependent on the service.
If I misinterpreted the brief or if you'd like me to complete it outside of a framework I'm happy to
have another go.

### Improvements

Lots of room for improvement here. I didn't want to spend too long on this as I'm guessing that's not what you want either,
but as a result there are a number of things I'd like to refactor and improve. Let me know if you're interested and I'll 
list them out or we can discuss.