### About
Api client for [Infinity call center](https://www.inteltelecom.ru)

[![Code Quality](https://img.shields.io/codacy/grade/8d3f114c909c4c548cc1f60a0b910bcc.svg?style=flat-square)](https://app.codacy.com/manual/walkerus/infinity-call-center-api-client)

### Usage

```php
$client = Client::make('http://192.168.0.1');
$userState = $client->getUserState(1);
```
