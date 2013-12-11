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

### PCurl.php

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
$response = $pcurl->post('/igipigiel/xml', '<a>makapaka</a>');
```

### PJsonCurl.php

Class similar to PCurl, the only difference is that the input/output is passed through json_encode/json_decode.
```
$pcurl = new PJsonCurl('http://www.app.com/json');
$response = $pcurl->put('/', array('a' => 'b'));
echo $response['c'];
```

### PObjectCurl.php

Class similar to PJsonCurl, the difference is that the input/output is passed through serialize/deserialize methods. Requires [JMS\Serializer](https://github.com/schmittjoh/serializer) library or [JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle) Symfony2 bundle.

```
$pcurl = new PObjectCurl('http://www.prettifier.com/json', JMS\Serializer\SerializerInterface $serializer);
$pcurl->responseClass('My\App\Preety');
$uglyObject =  new My\App\Ugly();
$preetyObject = $pcurl->put('/', $uglyObject);
```
Enjoy!
