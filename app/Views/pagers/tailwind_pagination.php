<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="flex items-center justify-center space-x-2 mt-8">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" class="px-4 py-2 bg-white border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 hover:text-[#00A859] transition-colors" aria-label="First">
                    <span aria-hidden="true">Awal</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" class="px-4 py-2 bg-white border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 hover:text-[#00A859] transition-colors" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="px-4 py-2 border rounded-lg transition-colors <?= $link['active'] ? 'bg-[#00A859] text-white border-[#00A859] font-bold shadow-sm' : 'bg-white hover:bg-gray-50 hover:text-[#00A859]' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" class="px-4 py-2 bg-white border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 hover:text-[#00A859] transition-colors" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" class="px-4 py-2 bg-white border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 hover:text-[#00A859] transition-colors" aria-label="Last">
                    <span aria-hidden="true">Akhir</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>