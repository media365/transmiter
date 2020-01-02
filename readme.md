# Transmitter
SMS gateway integration. Available drivers: Textvertising(UK), Log etc.

## Installation
1. Install the package
```
composer install media365/transmitter
```
2. Publish the configuration file to `config/transmitter.php` using the following command:

```
php artisan vendor:publish --provider="Media365\Transmitter\TransmitterServiceProvider"
```

Don't forget to add the credentials for your sms gateway(Texvertising) in `config/transmitter.php`. 
Feel free to change the SMS gateway driver class. 
To log sms instead of sending sms there is a driver called 'LogSMS' out of the box. To use this set 
`\Media365\Transmitter\Services\LogSMS::class` as driver in the `config/transmitter.php`. 

## Usages

```php
\Media365\Transmitter\Facades\Transmitter::send("<phone number>", "<message here>"); 
```

## Extends
It's not uncommon that you may need to work with SMS gateways other than the available ones. In that case you just
need to make an class that implements `Media365\Transmitter\Services\SMS` interface. Then set your class as `driver` in
the `config/transmitter.php` configuration file. Don't hesitate to make a pull request adding a new SMS gateway
support for this package.  

## License
MIT

