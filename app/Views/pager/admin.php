<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<div class="row mt-2">
    <div class="col-8 pl-3">
        <nav aria-label="<?= lang('Pager.pageNavigation') ?>" class="table-responsive">
            <ul class="pagination float-right">
                <?php if ($pager->hasPrevious()) : ?>
                    <li class="page-item">
                        <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('Pager.first') ?></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
                        </a>
                    </li>
                <?php endif ?>

                <?php foreach ($pager->links() as $link) : ?>
                    <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                        <a href="<?= $link['uri'] ?>" class="page-link">
                            <?= $link['title'] ?>
                        </a>
                    </li>
                <?php endforeach ?>

                <?php if ($pager->hasNext()) : ?>
                    <li class="page-item">
                        <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('Pager.next') ?></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('Pager.last') ?></span>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
    </div>
    <div class="col-4 pr-3 text-right {if !empty($pager)}mt-sm-3 mt-2{/if}">
        {*        {$paging.pagination_title}*}
    </div>
</div>


