<?php

namespace App\Service\Mailer;

use SendinBlue\Client\Model\CreateContact;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use App\Entity\User;
use Exception;

class Mailing
{

    static function config()
    {
        // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $_ENV['API_KEY']);
        return $config;
    }

    //add user to contact list 
    static function addUserToList(User $user, $listId)
    {

        $config =  Mailing::config();
        $apiInstance = new ContactsApi(
            new Client(),
            $config
        );

        $createContact = new CreateContact();
        $createContact['email'] = $user->getEmail();
        $createContact['listIds'] = array($user->getId());
        $createContact['attributes'] = array('NOM' => $user->getName(), 'LIEN_VALIDATION' => $_ENV['URL_SITE']);

        // dump($createContact);
        // exit;
        try {
            $result = $apiInstance->createContact($createContact);
            print_r($result);
        } catch (Exception $e) {
            echo 'An error has occured: ', $e->getMessage(), PHP_EOL;
            return false;
        }

        $contactEmails = new \SendinBlue\Client\Model\AddContactToList();

        try {
            $result = $apiInstance->addContactToList($listId, $contactEmails);
        } catch (Exception $e) {
            echo 'An error has occured: ', $e->getMessage(), PHP_EOL;
            return false;
        }
        return;
    }

    //*envoyer le mail
    static function sendEmail(User $user, String $signedUrl)
    {
        $config = Mailing::config();

        $apiInstance = new TransactionalEmailsApi(
            new Client(),
            $config
        );

        $sendSmtpEmail = new SendSmtpEmail();
        $sendSmtpEmail['to'] = array(array('email' => $user->getEmail(), 'name' => $user->getName()));
        $sendSmtpEmail['templateId'] = 5;
        $sendSmtpEmail['params'] = array('NOM' => $user->getName(), 'LIEN_VALIDATION' => $signedUrl);
        // $sendSmtpEmail['headers'] = array('X-Mailin-custom' => 'custom_header_1:custom_value_1|custom_header_2:custom_value_2');

        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
        }
    }


    //*envoyer le mail
    static function sendEmailResetPassword(string $email, string $resetPasswordToken)
    {

        $config = Mailing::config();


        $apiInstance = new TransactionalEmailsApi(
            new Client(),
            $config
        );

        $sendSmtpEmail = new SendSmtpEmail();
        $sendSmtpEmail['to'] = array(array('email' => $email));
        $sendSmtpEmail['templateId'] = 6;
        $sendSmtpEmail['params'] = array('LIEN_RECUPERATION' => $_ENV['URL_SITE'].'reset-password/reset/' . $resetPasswordToken);
        // $sendSmtpEmail['headers'] = array('X-Mailin-custom' => 'custom_header_1:custom_value_1|custom_header_2:custom_value_2');

        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
        }
    }
}
