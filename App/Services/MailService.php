<?php

namespace App\Services;

use App\MailTransport\MailTransport;
use App\MailTransport\Message;
use App\Render\Render;
use App\Services\OrderService;

class MailService
{
    private MailTransport $mailTransport;
    private OrderService $orderService;
    private Render $render;

    public function __construct(OrderService $orderService)
    {
        $this->mailTransport = new MailTransport(
            getenv('MAILER_HOST'),
            (int) getenv('MAILER_PORT'),
            getenv('MAILER_USER_EMAIL'),
            getenv('MAILER_USER_PASSWORD'),
            'ssl'
        );
        $this->orderService = $orderService;
        $this->render = new Render();
    }
    public function createMessageForOrder($templateName): ?string
    {
        $idLastOrder = $this->orderService
            ->getIdOfLastOrder();
        $order = $this->orderService
            ->getById($idLastOrder);
        $productsFromOrder = $this->orderService
            ->getAllProductsByOrderId($idLastOrder);
        $stringProducts = '';
        foreach ($productsFromOrder as $product) {
            $stringProducts .= "<tr>
                                    <th scope='row'style='color: #333333'>" . $product->getId() . "</th>
                                    <td style='color: #333333'>" . $product->getTitle() . "</td>
                                    <td style='color: #333333'>" . $product->getPrice() . " грн. </td>
                                    <td style='color: #333333'>" . $product->getQuantity() . "</td>
                                </tr>";
        }
        $message = "
            <div class='col-lg-12 ' align='left' style='font-size: large'>
                <p class='pb-5' style='color: #333333'>Детали заказа номер - <b><i>" . $order->getId() . "</b></i></p>
                <p style='color: #333333'>Адрес доставки : <b><i>" . $order->getAddress() . "</b></i></p>
                <p style='color: #333333'>Указанный номер телефона : <b><i>" . $order->getContactPhone() . "</b></i></p>
                <p style='color: #333333'>Сумма заказа : <b><i>" . $order->getPriceTotal() . " грн. </b></i></p>
                <p style='color: #333333'>Комментарии : <b><i>" . $order->getComments() . "</b></i></p>
                <p style='color: #333333'>Дата покупки : <b><i>" . $order->getDate() . "</b></i></p>
            </div>
            <div class='col-lg-12' align='center'style='font-size: large'>
                <p class='pb-3' align='center'>Заказанные продукты: </p>
                <table class='table' style='border: 2px solid black;'>
                    <thead>
                    <tr>
                        <th>Номер товара</th>
                        <th>Наименование</th>
                        <th>Цена</th>
                        <th>Количество</th>
                    </tr>
                    </thead>
                    <tbody'>
                        " . $stringProducts . "
                    </tbody>
                </table>
            </div>";
        return $this->render
            ->build_email_template($templateName, $message);
    }

    public function createMessageForComment($templateName, int $product_id): ?string
    {
        $product = (new ProductService())
            ->getProductById($product_id);
        $message = 'Вы успешно опубликовали комментарий для этого продукта'
            . $product->getTitle();
        return $this->render
            ->build_email_template($templateName, $message);
    }

    public function createMessageForRegister(string $templateName, array $params): ?string
    {
        $message =  "<div class='col-lg-12 ' align='left' style='font-size: large'>
                       <p>Вы успешно зарегестрировались на сайте! Для входа используйте эти данные: </p"
                    . "<p>Логин : " . $params[0] . "</p>"
                    . "<p>Пароль : " . $params[1] . "</p>"
                    . "</div>";
        return $this->render
            ->build_email_template($templateName, $message);
    }

    public function sendMessage(string $templateName, array $params)
    {
        $message = '';
        switch ($templateName) {
            case 'order':
                $message = $this->createMessageForOrder($templateName);
                break;
            case 'auth':
                $message = $this->createMessageForComment($templateName, $params[0]);
                break;
            case 'register':
                $message = $this->createMessageForRegister($templateName, $params);
                break;
        }
        $this->mailTransport
            ->send(new Message('Congratulations!', $message, getenv('MAILER_EMAIL_TO')));
    }

}