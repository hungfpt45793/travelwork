<?php

namespace Tests\Feature;

use setasign\Fpdi\Fpdi;
use Tests\TestCase;

class PdfRenderingTest extends TestCase
{
    public function test_pdf_renderer_preserves_vietnamese_text_and_page_breaks(): void
    {
        $html = <<<'HTML'
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 20mm; }
        body, body * { font-family: DejaVu Sans, sans-serif; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <section class="page-break">
        <h1>HỒ SƠ ỨNG VIÊN</h1>
        <p>Nguyễn Văn Dũng - Chuyên viên tuyển dụng</p>
        <p>Kỹ năng: lập kế hoạch, giao tiếp và quản lý dự án.</p>
    </section>
    <section>
        <h2>KINH NGHIỆM LÀM VIỆC</h2>
        <p>Điều hành tour, hướng dẫn viên nội địa và marketing du lịch.</p>
    </section>
</body>
</html>
HTML;

        $pdf = app('dompdf.wrapper')
            ->setOptions(['defaultFont' => 'DejaVu Sans'])
            ->setPaper('a4')
            ->loadHTML($html);

        $temporaryPdf = tempnam(sys_get_temp_dir(), 'travelwork_pdf_');

        try {
            file_put_contents($temporaryPdf, $pdf->output());

            $parser = new Fpdi();
            $this->assertSame(2, $parser->setSourceFile($temporaryPdf));

            $command = sprintf('pdftotext %s -', escapeshellarg($temporaryPdf));
            $extractedText = shell_exec($command);

            $this->assertIsString($extractedText);
            $this->assertStringContainsString('Nguyễn Văn Dũng', $extractedText);
            $this->assertStringContainsString('KINH NGHIỆM LÀM VIỆC', $extractedText);
        } finally {
            if (is_file($temporaryPdf)) {
                unlink($temporaryPdf);
            }
        }
    }
}
