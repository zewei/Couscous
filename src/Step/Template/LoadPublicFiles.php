<?php

namespace Couscous\Step\Template;

use Couscous\Model\LazyFile;
use Couscous\Model\Repository;
use Couscous\Step\StepInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Read public files from the template directory to the target directory.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class LoadPublicFiles implements StepInterface
{
    public function __invoke(Repository $repository, OutputInterface $output)
    {
        if (! $repository->template) {
            return;
        }

        $files = new Finder();
        $files->files()->in($repository->template->publicDirectory);

        $repository->watchlist->watchFiles($files);

        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            $repository->addFile(new LazyFile($file->getPathname(), $file->getRelativePathname()));
        }
    }
}
