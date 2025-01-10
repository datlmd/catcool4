<div class="body <?= $page_meta['div_body_class'] ?? '' ?>">

    <?= $page_layouts['header_top'] ?? "" ?>

    <?= $page_layouts['header_bottom'] ?? "" ?>

    <div role="main" class="main">

        <div class="container-xxl">

            <div class="row">
                <?php if (!empty($page_layouts['column_left'])) : ?>
                    <aside id="column_left" class="col-3 d-none d-md-block">
                        <?= $page_layouts['column_left'] ?>
                    </aside>
                <?php endif; ?>

                <div id="content" class="col">
                    <?= $page_layouts['content_top'] ?? "" ?>

                    <!-- @inertia -->
                    <div id="app" data-page='<?= htmlentities(json_encode($page)) ?>'></div>

                    <?= $page_layouts['content_bottom'] ?? "" ?>
                </div>

                <?php if (!empty($page_layouts['column_right'])): ?>
                    <aside id="column_right" class="col-3 d-none d-md-block">
                        <?= $page_layouts['column_right'] ?? "" ?>
                    </aside>
                <?php endif; ?>
            </div>

        </div>

    </div>

    <?= $page_layouts['footer_top'] ?? "" ?>

    <?= $page_layouts['footer_bottom'] ?? "" ?>

</div>