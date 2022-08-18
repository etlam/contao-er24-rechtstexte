<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Rechtstexte für eRecht24 extension.
 *
 * (c) fenepedia
 *
 * @license LGPL-3.0-or-later
 */

namespace Fenepedia\ContaoErecht24Rechtstexte\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\PageModel;

/**
 * Adds the eRecht24 API key to the page details.
 *
 * @Hook("loadPageDetails")
 */
class LoadPageDetailsListener
{
    public function __invoke(array $parents, PageModel $page): void
    {
        if (empty($parents)) {
            return;
        }

        $root = end($parents);

        if (empty($root->er24ApiKey) && !$root->fallback) {
            $root = PageModel::findOneBy(['dns = ?', "fallback = '1'"], [$root->dns]) ?? $root;
        }

        $page->er24ApiKey = $root->er24ApiKey;
    }
}
