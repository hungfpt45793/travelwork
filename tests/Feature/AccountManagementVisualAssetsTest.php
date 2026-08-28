<?php

namespace Tests\Feature;

use App\Entity\User;
use Tests\TestCase;

class AccountManagementVisualAssetsTest extends TestCase
{
    public function test_employer_can_open_account_management_with_existing_visual_assets(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();

        $response = $this->actingAs($employer)->get(route('management_account'));

        $response->assertOk();
        $response->assertSee('/assets/css/sitebar.css', false);
        $response->assertSee('/assets/web/css/side_bar_job.css', false);
        $response->assertSee('/assets/web/css/employee_profile.css', false);
        $response->assertSee('/assets/js/jquery.validate.min.js', false);
        $response->assertDontSee('/public/assets/', false);

        foreach ([
            'assets/css/sitebar.css',
            'assets/web/css/side_bar_job.css',
            'assets/web/css/employee_profile.css',
            'assets/js/jquery.validate.min.js',
        ] as $asset) {
            $this->assertFileExists(public_path($asset));
        }
    }

    public function test_blade_views_do_not_use_legacy_local_public_asset_urls(): void
    {
        $violations = [];
        $views = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(resource_path('views'))
        );

        foreach ($views as $view) {
            if (! $view->isFile() || $view->getExtension() !== 'php') {
                continue;
            }

            $contents = file_get_contents($view->getPathname());

            $hasLegacyAssetUrl = preg_match('/(["\'])\/public\/assets\//', $contents);
            $hasLegacyHtmlAsset = preg_match('/(?:href|src)\s*=\s*(["\'])\/public\//', $contents);
            $hasLegacyAssetHelper = preg_match('/asset\(\s*(["\'])\/?public\//', $contents);

            if ($hasLegacyAssetUrl || $hasLegacyHtmlAsset || $hasLegacyAssetHelper) {
                $violations[] = str_replace(base_path().DIRECTORY_SEPARATOR, '', $view->getPathname());
            }
        }

        $this->assertSame([], $violations, 'Các view còn dùng URL tài nguyên cũ: '.implode(', ', $violations));
    }

    public function test_document_library_category_page_renders_without_missing_route_parameters(): void
    {
        $response = $this->get(route('getAllCategoryVoucher', [
            'slugCategoryVoucher' => 'mau-chung-tu',
        ]));

        $response->assertOk();
        $response->assertDontSee('Missing required parameter', false);
    }
}
