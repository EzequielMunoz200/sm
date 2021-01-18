<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class FamilySearch extends Command
{
    protected static $defaultName = 'app:family:search';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(
                'Retrouver avec la clé sous-sous-famille, la sous-famille associée ainsi que la famille associée.'
            )
            ->addArgument('product', InputArgument::REQUIRED, 'Chercher le produit')
            ->setHelp('Cette commande sert à chercher l\'arborescence de produits. Ex: "Cuisine conviviale"');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $product = ucfirst($input->getArgument('product'));
        $io->title('Resultat pour ' . $product);

        if ($product !== null) {
            $finder = new Finder();

            // find all files in the current directory
            $finder->files()->in('csv');

            // check if there are any search results
            if (!$finder->hasResults()) {
                echo 'File not found';
            }

            $families = [];
            $lastItem1 = [];
            foreach ($finder as $file) {
                $absoluteFilePath = $file->getRealPath();
                $csv = array_map('str_getcsv', file($absoluteFilePath));
                foreach ($csv as $item) {

                    if ($item[0]) {
                        $families[$item[0]] = [];
                    } else {
                        if ($item[1]) {
                            $lastItem1 = $item[1];
                        } else {
                            if ($item[2]) {
                                $families[array_key_last($families)][$lastItem1][] = $item[2];
                            }
                        }
                    }
                }
            }

            foreach ($families as $keyFamily => $family) {
                foreach ($family as $keySubfamily => $subFamily) {
                    if (in_array($product, $subFamily)) {

                        $io->table(
                            ['sous-sous-famille', 'sous-famille', 'famille'],
                            [
                                [$product, $keySubfamily, $keyFamily],
                            ]
                        );
                        return 0;
                    }
                }
            }

            $io->warning("$product n'est pas dans la liste");
            return 1;
        }
    }
}
