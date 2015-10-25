# PageBlacklist v0.2.1 beta

Page blacklisting helper module for ProcessWire.

With this simple module you can easily add pages to a global blacklist and use it for filtering of subsequent selector queries.

## Usage

For ease of use, the modules adds a ```$pageBlacklist``` variable to the template scope. Usualy you will only need one method:

    $pageBlacklist->add($something);

```$something``` can be many things and is just a wraper for the internal API. Here is a list of possible values:

    *add(1012)* [integer]
    Will assume page with the ID '1212'.
    
    *add($pageObject)* [Page]
    Instance of Page adds this page.
    
    *add($pageArray)* [PageArray]
    Given an instance of PageArray, will add every page in that array.
    
    Also, you can add arrays containing IDs or Page objects:
    
    add(array(
        1012, 1013, 1025
    ))
    
    or
    
    add(array(
        $pageObject, $pageObject2, $pageObject3
    ))

## Complete list of methods

tbc