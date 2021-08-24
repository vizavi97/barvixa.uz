<?php

namespace Tim\Barviha\Helpers;

use Backend\Classes\Controller;

use Illuminate\Http\Request;
use TelegramBot\Api\Client; // подключение библиотеки Telegram API

use TelegramBot\Api\Types\ReplyKeyboardMarkup; // использование ReplyKeyboardMarkup (основное меню)

use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup; // использование InlineKeyboardMarkup (кнопки под сообщением)

class TelegramController extends Controller
{
    const telegram_bot_token = "1841844094:AAGWRE8Vj-eUNRhQ7bAVTMByc8VWNQgo6B0";
//    const methods_send_message = "sendMessage";
    public function index() {

        // Подключение сайта к Telegram API

        // Пример token - 375466075:AAEARK0r2nXjB67JiB35JCXXhKEyT42Px8s

        $bot = new Client(self::telegram_bot_token);


        // Стандартная команда /start

        // Таким образом можно создать любую команду

        $bot->command('start', function ($message) use ($bot) {

            $answer = 'Добро пожаловать!';

            $bot->sendMessage($message->getChat()->getId(), $answer);

        });


        // Пример кнопок у сообщений - команда /keyboard

        $bot->command('keyboard', function ($message) use ($bot) {

            $answer = 'Предоставленные кнопки!';

            $testKey = new InlineKeyboardMarkup(

                [

                    [

                        ['callback_data' => 'test', 'text' => 'Тестовая кнопка']

                    ]

                ]

            );

            $bot->sendMessage($message->getChat()->getId(), $answer, 'HTML', true, null, $testKey);

        });


        // пример кнопок меню под строкой ввода /menu

        $bot->command('menu', function ($message) use ($bot) {

            $answer = 'Сообщение показывается и снизу появятся кнопки';

            $StartKeyboard = new ReplyKeyboardMarkup(

                [

                    [

                        "Привет"

                    ],

                    [

                        "/start",

                        "/keyboard"

                    ]

                ], true, true

            );

            $bot->sendMessage($message->getChat()->getId(), $answer, 'HTML', true, null, $StartKeyboard);

        });


        // Обработка кнопок у сообщений

        $bot->on(function ($Update) use ($bot) {

            $callback = $Update->getCallbackQuery();

            $message = $callback->getMessage(); // получаем сообщение

            $cid = $callback->getFrom()->getId(); // уникальный идентификатор chat_id

            $data = $callback->getData(); // название команды переданный с кнопки у сообщения


            // пример обработки команды с кнопки

            if ($data == "test") {

                $answer = "Пример сообщения с кнопки :)";

                // данная функция будет не отправлять сообщение, а редактировать предыдущее сообщение с кнопками

                $bot->editMessageText($message->getChat()->getId(), $message->getMessageId(), $answer, 'HTML');

                $bot->answerCallbackQuery($callback->getId()); // убираем загрузку на кнопке

                //$bot->answerCallbackQuery($callback->getId(), 'Всплывающее сообщение'); // убирает загрузку на кнопке и показывает сообщение

            }


            // убираем вечное обновление (данная проблема только на Laravel, на чистом php вечного обновления нету)

            if (empty($data)) return true; else return false;


        }, function ($Update) {

            try {

                $callback = $Update->getCallbackQuery();

                if (is_null($callback) || !strlen($callback->getData()))

                    return false;

                return true;

            } catch (\Exception $e) {

                return false;

            }

        });


        // Отлов любых сообщений + обработка reply-кнопок

        $bot->on(function ($Update) use ($bot) {

            $message = $Update->getMessage(); // получаем инфо о сообщениях

            $mtext = $message->getText(); // получаем текст отправленого сообщения пользователем

            $cid = $message->getChat()->getId(); // получаем chat_id (уникальный ид пользователя в телеграм)


            // Пример проверки сообщения

            if (mb_stripos($mtext, "Привет") !== false) {

                $answer = "Привет, " . $message->getChat()->getFirstName(); // будет отправлено сообщение в ответ "Привет, Konstantin"

                $bot->sendMessage($message->getChat()->getId(), $answer, 'HTML', true, null);

            }

        }, function ($message) {

            return true;

        });


        // Запуск бота

        if (!empty($bot->getRawBody())) {

            try {

                $bot->run();

            } catch (\Exception $e) {

                // можно добавить функцию уведомления администратора о возможных ошибках

            }

        }
    }



        /*    public function sendTelegramBot(Request $request)
            {
                if (isset($request)) {
                    $test = new Test;
                    $test->info = json_encode($request);
                    $test->save();
                }
                return response()->json('fuck you');
        //        return $this->sendTelegram(self::methods_send_message, '12321');
            }


            function sendTelegram($method, $data, $headers = [])
            {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://api.telegram.org/bot' . self::telegram_bot_token . '/' . $method,
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
                ]);
                $result = curl_exec($curl);
                curl_close($curl);
                return (json_decode($result, 1) ? json_decode($result, 1) : $result);
            }*/

}

?>