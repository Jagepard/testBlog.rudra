<?php

namespace App\Containers\Admin\UI;

use Rudra\Container\Facades\Rudra;

class UI
{
    public static function renderLinks(array $links, string $page, $pg_limit, $uri): void
    {
        $last = array_key_last($links) + 1;
        ?>

        <ul class="pagination">

        <!-- FIRST -->
        <?php if ($links[0] != $page): ?>
        <li class="paginate_button page-item"><a href="<?= Rudra::config()->get("url") ?><?= $uri . $links[0] ?>" class="page-link"><<</a></li>
        <?php endif; ?>
        <?php foreach ($links as $link): ?>
            <?php if (($link < $page) && ($link >= ((int)$page - $pg_limit))): ?>
            <li class="paginate_button page-item"><a href="<?= Rudra::config()->get("url") ?><?= $uri . $link ?>" class="page-link"><?= $link ?></a></li>
            <?php endif; ?>

            <?php if ($link == $page): ?>
            <li class="paginate_button page-item active"><a href="<?= Rudra::config()->get("url") ?><?= $uri . $link ?>" class="page-link"><?= $link ?></a></li>
            <?php endif; ?>

            <?php if (($link > $page) && ($link <= ((int)$page + $pg_limit))): ?>
                <li class="paginate_button page-item"><a href="<?= Rudra::config()->get("url") ?><?= $uri . $link ?>" class="page-link"><?= $link ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- LAST -->
        <?php if ($last != $page): ?>
        <li class="paginate_button page-item"><a href="<?= Rudra::config()->get("url") ?><?= $uri . $last ?>" class="page-link">>></a></li>
        <?php endif; ?>
        </ul>
        <?php
    }
}