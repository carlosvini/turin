Turin - PHP transpiler
====

Under development. 

Goals
----

* Add chaining to types such as *items:a.filter().implode()* (no neet to wait for the PHP team to add autoboxing!)
* Add automatic conversion between Turin and PHP with Sublime Plugin (other programmers don't even need to know) 
* Better syntax:
** Add shortcuts to *$this* and *self* (@property = 1)
** Remove **$** from variables (var = 1)
** Change **->** and **::** to **.** (concatenate with ~)

Motivation
----

I knew LadyPHP for a while, and it provides a better syntax to PHP and implements a Sublime Plugin to autoconvert files to Lady. When you save your Lady file the PHP file is saved too. It allows me to code with Lady without anyone having to read or know Lady.

But what really has annoyed me in PHP is this:

```php
$foo = str_replace('b', 'f', split(' ', 'foo bar baz')[1]) . ' from readable';
//$foo = 'far from readable'
```

It's hard to read things when paremeters and functions are all mixed together. So you are forced to break your code in many lines. There's also the problem that there are too many functions starting with str or array, and the order of parameters is hard to remember. If PHP had autoboxing things would be better:

```php
$foo = 'foo bar baz'->split(' ')[1]->replace('b', 'f') . ' better';
//$foo = 'far better'
```

or in Turin:

```php
foo = 'foo bar baz'.split(' ')[1].replace('b', 'f') + ' better';
//$foo = 'far better'
```


Similar Projects
----

* Mammouth - http://mammouth.wamalaka.com/ (Can't convert PHP back to mammouth)
* LadyPHP - http://ladyphp.honzanovak.com/ (Can't solve chaining problem)

About Turin
----
Turin Turambar is a dragon slayer in Tolkien mythology. So Turin language will help you get rid of any ugly PHP code.