<?php

namespace Losofacebook\Command;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Keboola\Csv\CsvFile;
use Losofacebook\Service\ImageService;
use Losofacebook\Image;
use Doctrine\DBAL\Connection;

use DateTime;

class CreateImagesCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('dev:create-images')
            ->setDescription('Creates images for users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Will parse images.");

        $finder = new Finder();

        $finder
            ->files()
            ->in($this->getProjectDirectory() . '/app/dev/imaginarium/people');

        $is = $this->getImageService();

        die();
        
        $this->getDb()->exec("DELETE FROM image WHERE type = 1");

        foreach ($finder as $file) {
            $output->writeln("{$file->getRealpath()}");
            $is->createImage($file->getRealpath(), Image::TYPE_PERSON);
        }
    }

    /**
     * @return ImageService
     */
    public function getImageService()
    {
        return $this->getSilexApplication()['imageService'];
    }

    /**
     * @return Connection
     */
    public function getDb()
    {
        return $this->getSilexApplication()['db'];
    }
}
