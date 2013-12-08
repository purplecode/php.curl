# php.curl

**PCurl** is a PHP client library for [RESTful](http://en.wikipedia.org/wiki/Representational_State_Transfer) 
web services.

PCurl supports GET/POST/PUT/DELETE request methods. Unlike other similar libaries supports also HTTPS certificates verification.

Composer Installation
------------

To install PCurl, use the following composer `require` statement:
```
{
    "require": {
        "purplecode/pcurl": "dev-master"
    }
}

```
or just copy-paste content of `src/` to your `libs`.

Usage
------------

Simple GET
```
$pcurl = new PCurl('http://www.google.pl');
$response = $pcurl->get('/');
```

Simple GET via HTTPS with certificate verification (more examples in test package)
```
$pcurl = new PCurl('https://www.google.pl');
$pcurl->useSSLCertificate(<path to crt/pem file>);
$response = $pcurl->get('/');
```
and a similar example without it
```
$pcurl = new PCurl('https://www.google.pl');
$pcurl->ignoreSSLCertificate();
$response = $pcurl->get('/');
```

Sample POST
```
$pcurl = new PCurl('http://some.fancy.page');
$pcurl->proxy(host, port);
$pcurl->auth(user, pass);
$pcurl->header('Cache-Control: no-cache');
$pcurl->contentType('application/xml');
$response = $pcurl->post('<a>makapaka</a>');
```

Enjoy!
