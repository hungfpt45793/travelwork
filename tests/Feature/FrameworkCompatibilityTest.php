<?php

namespace Tests\Feature;

use App\Entity\Task_detail;
use App\Entity\User;
use App\Mail\Mail as ApplicationMail;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FrameworkCompatibilityTest extends TestCase
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
        $this->assertTrue(class_exists(\VinkiusLabs\LaravelPageSpeed\Middleware\PageSpeed::class));
    }

    public function test_jwt_token_can_be_signed_and_verified_with_rotated_secret(): void
    {
        $user = new User(['id' => 999999]);
        $token = JWTAuth::fromUser($user);
        $payload = JWTAuth::setToken($token)->getPayload();

        $this->assertEquals($user->getKey(), $payload->get('sub'));
    }

    public function test_legacy_date_properties_are_preserved_as_datetime_casts(): void
    {
        $user = new User();
        $user->setRawAttributes(['deleted_at' => '2026-08-23 00:00:00']);

        $task = new Task_detail();
        $task->setRawAttributes(['finish_day' => '2026-08-23 00:00:00']);

        $this->assertInstanceOf(CarbonInterface::class, $user->deleted_at);
        $this->assertInstanceOf(CarbonInterface::class, $task->finish_day);
    }

    public function test_intervention_image_v3_preserves_product_resize_ratio(): void
    {
        $image = ImageManager::gd()->create(1600, 1000);
        $image->scale(height: 800);

        $this->assertSame(1280, $image->width());
        $this->assertSame(800, $image->height());
    }

    public function test_captcha_can_render_with_intervention_image_v3(): void
    {
        $captcha = app('captcha')->create('default', true);

        $this->assertIsArray($captcha);
        $this->assertStringStartsWith('data:image/jpeg;base64,', $captcha['img']);
    }
}
