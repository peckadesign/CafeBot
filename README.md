# CafeBot [![Build Status](https://travis-ci.org/peckadesign/CafeBot.svg?branch=master)](https://travis-ci.org/peckadesign/CafeBot)

Připomínač úklidu kávovaru.

Comamnd pošle do Slacku notifikaci s tím, od koho by si přál ten den úklid.

## Spuštění

Do lokálního nastavení v `config/config.local.neon` je potřeba uvést URL webhooku pro Slack a cestu k CSV s rozpisem služeb.

```
> git clone git@github.com:peckadesign/StandUpBot.git
> cd StandUpBot
> cp config/config.local.example.neon config/config.local.neon
> composer install
> php bin/index.php
```
