# CafeBot ![Build Status](https://github.com/peckadesign/CafeBot/actions/workflows/php-package-ci.yml/badge.svg)

Připomínač úklidu kávovaru.

Command pošle do Slacku notifikaci s tím, od koho by si přál ten den úklid.

## Spuštění

Do ENV proměnných **CAFEBOT_WEBHOOK** a **CAFEBOT_CLEANERS** je potřeba uvést URL webhooku pro Slack a cestu k CSV s rozpisem služeb.

```
> git clone git@github.com:peckadesign/StandUpBot.git
> cd StandUpBot
> composer install
> php bin/index.php
```
