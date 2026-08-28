<?php

namespace Tests\Feature;

use App\Entity\Post;
use App\Ultility\Ultility;
use Tests\TestCase;

class HomepageVisualAssetsTest extends TestCase
{
    private const HOME_POST_IMAGES = [
        'library_staff/25094/images/1(372).PNG',
        'library_staff/25094/images/1(374).PNG',
        'library_staff/25094/images/1(377).PNG',
        'library_staff/25094/images/1(379).PNG',
        'library_staff/25094/images/1(381).PNG',
        'library_staff/25094/images/5(48).PNG',
        'library_staff/25094/images/5(49).PNG',
        'library_staff/25094/images/6(25).PNG',
    ];

    public function test_legacy_public_asset_paths_are_normalized_or_use_a_fallback(): void
    {
        $this->assertSame(
            asset('assets/image/new/Logo.png'),
            Ultility::assetUrl('/public/assets/image/new/Logo.png', 'assets/image/new/SKT.png')
        );

        $this->assertSame(
            asset('assets/image/banner_home1.png'),
            Ultility::assetUrl('/public/library/images/banner_new/missing.png', 'assets/image/banner_home1.png')
        );
    }

    public function test_homepage_renders_existing_header_banner_and_footer_assets(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(asset('assets/image/new/Logo.png'), false);
        $response->assertSee(asset('assets/image/banner_home1.png'), false);
        $response->assertSee(asset('assets/image/new/SKT.png'), false);
        $response->assertSee(
            '<link rel="icon" href="'.asset('assets/image/new/Logo.png').'" type="image/png"/>',
            false
        );
    }

    public function test_homepage_post_images_keep_their_database_paths_and_are_lazy_loaded(): void
    {
        foreach (self::HOME_POST_IMAGES as $image) {
            $this->assertFileExists(public_path($image));
            $this->assertSame(
                asset($image),
                Ultility::assetUrl('/public/'.$image, 'images/no_image.png')
            );
        }

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('class="post-home-image"', false);
        $response->assertSee("lazyLoad: 'anticipated'", false);
        $response->assertDontSee('assets/image/home-posts/', false);

        foreach (Post::categoryShow('tin-tuc', 4) as $post) {
            $response->assertSee(
                'data-lazy="'.Ultility::assetUrl($post->image, 'images/no_image.png').'"',
                false
            );
        }
    }
}
