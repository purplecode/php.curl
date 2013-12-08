# php.curl

**PCurl** is a PHP client library for [RESTful](http://en.wikipedia.org/wiki/Representational_State_Transfer) 
web services.

PCurl supports GET/POST/PUT/DELETE request methods. Unlike other similar libaries supoprts also HTTPS certificates verification.

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

# Usage

Simple GET
```
$pcurl = new PCurl('http://www.google.pl');
$response = $cut->get('/');
```

Simple GET via HTTPS with certificate verification (more examples in test package)
```
$pcurl = new PCurl('https://www.google.pl');
$cut->useSSLCertificate(<path to crt/pem file>);
$response = $cut->get('/');
```
and a similar example without it
```
$pcurl = new PCurl('https://www.google.pl');
$cut->ignoreSSLCertificate();
$response = $cut->get('/');
```

Sample POST
```
$pcurl = new PCurl('http://some.fancy.page');
$cut->proxy(host, port);
$cut->auth(user, pass);
$cut->header('Cache-Control: no-cache');
$cut->contentType('application/xml');
$response = $cut->get('/');
```

Enjoy!
