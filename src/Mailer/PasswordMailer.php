<?php


namespace App\Mailer;


use App\Entity\User;
use Twig\Environment;

class PasswordMailer
{
    private $mailer;
    private $subject;
    private $sender;
    private $txtTemplate;
    private $htmlTemplate;
    private $twig;

    public function __construct(
        \Swift_Mailer $mailer,
        Environment $twig,
        string $subject,
        string $sender,
        string $txtTemplate,
        string $htmlTemplate
    )
    {
        $this->mailer = $mailer;
        $this->subject = $subject;
        $this->sender = $sender;
        $this->txtTemplate = $txtTemplate;
        $this->htmlTemplate = $htmlTemplate;
        $this->twig = $twig;
    }

    /**
     * @param User $user
     */
    public function sendMail(User $user)
    {
        $message = new \Swift_Message();

        $message->setSubject($this->subject);
        $message->setFrom($this->sender);
        $message->setTo($user->getEmail());
        $message->setBody($this->twig->render($this->htmlTemplate,['user' => $user], 'text/html'));
        $message->addPart($this->twig->render($this->txtTemplate,['user' => $user], 'text/plain'));

        $this->mailer->send($message);
    }

}