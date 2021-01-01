<?php

declare(strict_types=1);

namespace App\Command;

use App\Manager\PostManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PostSlugUpdateCommand extends Command
{
    protected static $defaultName = 'app:post:slug-update';

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var PostManager
     */
    private $postManager;

    /**
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        parent::__construct();

        $this->postManager = $postManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Regenerates slugs and updates them in the database')
            ->addOption(
                'missing',
                'm',
                InputOption::VALUE_NONE,
                'If set, will only update slugs which are missing'
            );
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $this->postManager->updateSlugs($input->getOption('missing'));
        $this->io->success('Updated ' . $count . ' slugs');

        return Command::SUCCESS;
    }
}