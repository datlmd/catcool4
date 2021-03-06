<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<div class="row">
    <div class="col-12">
        <nav aria-label="<?= lang('PagerAdmin.pageNavigation') ?>" class="table-responsive">
            <ul class="pagination justify-content-end my-2">
                <?php if ($pager->hasPrevious()) : ?>
                    <li class="page-item">
                        <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('PagerAdmin.first') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('PagerAdmin.first') ?></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('PagerAdmin.previous') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('PagerAdmin.previous') ?></span>
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
                        <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('PagerAdmin.next') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('PagerAdmin.next') ?></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('PagerAdmin.last') ?>" class="page-link">
                            <span aria-hidden="true"><?= lang('PagerAdmin.last') ?></span>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</div>


