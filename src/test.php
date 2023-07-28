<?php

require_once __DIR__.'/vendor/autoload.php';

use Z38\SwissPayment\BIC;
use Z38\SwissPayment\IBAN;
use Z38\SwissPayment\Message\CustomerCreditTransfer;
use Z38\SwissPayment\Money;
use Z38\SwissPayment\PaymentInformation\PaymentInformation;
use Z38\SwissPayment\PostalAccount;
use Z38\SwissPayment\StructuredPostalAddress;
use Z38\SwissPayment\TransactionInformation\BankCreditTransfer;
use Z38\SwissPayment\TransactionInformation\IS1CreditTransfer;
use Z38\SwissPayment\UnstructuredPostalAddress;

$transaction1 = new BankCreditTransfer(
    'instr-001',
    'e2e-001',
    new Money\CHF(130000), // CHF 1300.00
    'Muster Transport AG',
    new StructuredPostalAddress('Wiesenweg', '14b', '8058', 'Zürich-Flughafen'),
    new IBAN('CH51 0022 5225 9529 1301 C'),
    new BIC('UBSWCHZH80A')
);

$transaction2 = new IS1CreditTransfer(
    'instr-002',
    'e2e-002',
    new Money\CHF(30000), // CHF 300.00
    'Finanzverwaltung Stadt Musterhausen',
    UnstructuredPostalAddress::sanitize('Altstadt 1a', '4998 Musterhausen'),
    new PostalAccount('80-151-4')
);

$payment = new PaymentInformation(
    'payment-001',
    'InnoMuster AG',
    new BIC('ZKBKCHZZ80A'),
    new IBAN('CH6600700110000204481')
);
$payment->addTransaction($transaction1);
$payment->addTransaction($transaction2);

$message = new CustomerCreditTransfer('message-001', 'InnoMuster AG');
$message->addPayment($payment);

echo $message->asXml();
