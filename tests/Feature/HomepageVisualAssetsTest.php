<?php

namespace Tests\Feature;

use App\Ultility\Ultility;
use Tests\TestCase;

class HomepageVisualAssetsTest extends TestCase
{
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
    }
}
