<div id="my_pdf_viewer">
    <div id="canvas_container">
        <p class="loading_cv"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Đang tải cv. </p>
        <canvas id="pdf_renderer"></canvas>
    </div>
    <div class="control-pdf">
        <div class="d-flex justify-content-between">
            <div id="navigation_controls">
                <button type="button" class="btn btn-sm btn-success" id="go_previous"><i
                        class="fas fa-backward"></i></button>
                <input id="current_page" class="form-control form-control-sm" value="1" type="hidden" />
                <button type="button" class="btn btn-sm btn-success" id="go_next"><i
                        class="fas fa-forward"></i></button>
            </div>

            <div id="zoom_controls" class="ml-5">
                <button type="button" class="btn btn-sm btn-success" id="zoom_in"><i class="fas fa-plus"></i></button>
                <button type="button" class="btn btn-sm btn-success" id="zoom_out"><i
                        class="fas fa-minus"></i></button>
                <a target="_blank" class="btn btn-sm btn-primary" href="{{ $link_cv }}"><i
                        class="fas fa-download"></i></a>
            </div>
        </div>
    </div>
</div>