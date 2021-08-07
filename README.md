# Mailbox intergration service

![image](https://user-images.githubusercontent.com/55990554/125464904-34781eb8-393a-4ea3-9dde-9f268187e26c.png)

Send emails from mailbox to **Telegram Bot**, **Bitrix24** and **SMS** messaging service using API.
Exist three entry point: 
- **bot.php**
Executed from telegram and contains telegram bot logic.
- **mail.php**
Executed from cron, runs every 5 minutes and check new emails. If new emails exist - send it to API services.
- **send_sms.php**
Executed from cron, runs everyday at 9 am and send sms to phone numbers, which sended at night

To install project on your local machine or server use Composer:
```bash
composer update
```

Telegram-SDK Documentation https://github.com/irazasyed/telegram-bot-sdk
