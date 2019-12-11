### About
Api client for [Infinity call center](https://www.inteltelecom.ru)

[![Build Status](https://travis-ci.org/walkerus/infinity-call-center-api-client.svg?branch=master)](https://travis-ci.org/walkerus/infinity-call-center-api-client)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cc97ce05a35a4ffaa216cd18f9df7a93)](https://www.codacy.com/manual/walkerus/infinity-call-center-api-client?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=walkerus/infinity-call-center-api-client&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/cc97ce05a35a4ffaa216cd18f9df7a93)](https://www.codacy.com/manual/walkerus/infinity-call-center-api-client?utm_source=github.com&utm_medium=referral&utm_content=walkerus/infinity-call-center-api-client&utm_campaign=Badge_Coverage)

### Usage

```php
$client = Client::make('http://192.168.0.1');
$userState = $client->getUserState(1);
```
