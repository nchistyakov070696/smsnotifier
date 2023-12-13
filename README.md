## 1. Running the application

This project fully works and there is a possibility to run application locally with
`docker-compose` using following command:

```bash
docker-compose up -d --build
```

`RabbitMQ` is used as message broker. For consuming messages from queue run the following
command inside the `web` container:

```bash
php bin/console messenger:consume async
```

## 2. Sending requests

In a course of using the newest `Symfony 7` version, it's not possible to use `Swagger` and `Codeception` yet
(used `PhpUnit` instead).

There are two endpoints available in the application. Use [this file](requests.http) to see the list of endpoints
and make http requests. You can execute this requests using `PhpStorm`.

## 3. Usage

There are several static `customers` (users who can send sms messages via this application) with personal access tokens
and `providers` (clients who provide sending SMS messages itself) with their own APIs.
Personal keys are used for authentication of users due to lack of authorization.
The list of customers:

| Customer name | Access token        |
|---------------|---------------------|
| Customer_0    | some_hashed_token_0 |
| Customer_1    | some_hashed_token_1 |
| Customer_2    | some_hashed_token_2 |
| Customer_3    | some_hashed_token_3 |
| Customer_4    | some_hashed_token_4 |
| Customer_5    | some_hashed_token_5 |
| Customer_6    | some_hashed_token_6 |
| Customer_7    | some_hashed_token_7 |
| Customer_8    | some_hashed_token_8 |
| Customer_9    | some_hashed_token_9 |

The list of providers:

| Provider name | Rate per message | Url for sms                          |
|---------------|------------------|--------------------------------------|
| Provider_0    | 0.20             | http://provider-0-host.test/send-sms |
| Provider_1    | 0.30             | http://provider-1-host.test/send-sms |
| Provider_2    | 0.40             | http://provider-2-host.test/send-sms |

## 4. SMS lifecycle
After sending a message via `/api/sms/send` endpoint application generates internal `SmsNotificationEvent` event
and push it to the queue. In parallel with it `SmsNotificationEventHandler` listen to the queue and trying to send
sms via each of the providers one by one until success send. If no one of the providers is available to get the sms
or any error appears, `SmsNotificationEvent` returns back to the queue with 2 minutes delay of handling again.
## 5. Testing
There are several integration tests are written. To run the use the following command inside the `web` container:
```bash
php bin/phpunit
```
## 6. Notes from the author
There are a lot of things that could and has to be improved (for instance usage of additional table for attempts,
using cache in some cases and etc.). The main goals was to build working application and integrate queue into
lifecycle of events and to do minimal test coverage. For comments and suggestions, write to my telegram @nchystsiakov.
