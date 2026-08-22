<?php

namespace Tests\Feature;

use App\Entity\User;
use App\Mail\Mail as ApplicationMail;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class Laravel9CompatibilityTest extends TestCase
{
    public function test_symfony_mailer_configuration_and_mailable_are_available(): void
    {
        $this->assertNotEmpty(config('mail.default'));
        $this->assertSame('smtp', config('mail.mailers.smtp.transport'));

        Mail::fake();
        Mail::to('test@example.com')->send(new ApplicationMail('Nội dung kiểm thử'));

        Mail::assertSent(ApplicationMail::class);
    }

    public function test_mailgun_transport_can_be_built_without_sending_mail(): void
    {
        config([
            'services.mailgun.domain' => 'example.test',
            'services.mailgun.secret' => 'test-secret',
        ]);

        app('mail.manager')->purge('mailgun');

        $this->assertInstanceOf(
            TransportInterface::class,
            app('mail.manager')->mailer('mailgun')->getSymfonyTransport()
        );
    }

    public function test_retained_legacy_integrations_can_be_loaded(): void
    {
        $this->assertTrue(class_exists(\Facebook\Facebook::class));
        $this->assertTrue(class_exists(\NcJoes\PopplerPhp\PdfToHtml::class));
    }

    public function test_jwt_token_can_be_signed_and_verified_with_rotated_secret(): void
    {
        $user = new User(['id' => 999999]);
        $token = JWTAuth::fromUser($user);
        $payload = JWTAuth::setToken($token)->getPayload();

        $this->assertEquals($user->getKey(), $payload->get('sub'));
    }
}
