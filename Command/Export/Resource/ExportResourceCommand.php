<?php

namespace Remdan\EasysysConnectorBundle\Command\Export\Resource;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use EasysysConnector\Manager\Resource\Contact\ResourceContactManager;
use EasysysConnector\Model\Resource\ResourceInterface;
use Remdan\EasysysConnectorBundle\Command\AbstractCommand;
use Doctrine\Common\Persistence\ObjectManager;

class ExportResourceCommand extends AbstractCommand
{
    const REPOSITORY_METHOD_FIND = 'esFind';

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var boolean
     */
    protected $insert = false;

    /**
     * @var boolean
     */
    protected $update = false;

    /**
     *
     */
    public function configure()
    {
        $this->setName('remdan:easysys-connector:export:resource')
            ->addArgument(
                'resource',
                InputArgument::REQUIRED,
                'the entity class_name'
            )
            ->addOption(
                'limit',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, the task will change the limit',
                1000
            )
            ->addOption(
                'offset',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, the task will set a offset',
                null
            )
            ->addOption(
                'insert',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will insert new items'
            )
            ->addOption(
                'update',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will update items'
            );
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return bool
     */
    public function isInsert()
    {
        return $this->insert;
    }

    /**
     * @return bool
     */
    public function isUpdate()
    {
        return $this->update;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function initArguments(InputInterface $input, OutputInterface $output)
    {
        $this->entityClass = $input->getArgument('resource');
        if (!class_exists($this->entityClass)) {
            $output->writeln("can't find object or not exist");
        }
    }

    /**
     * @param InputInterface $input
     */
    public function initOptions(InputInterface $input)
    {
        $this->limit = $input->getOption('limit');
        $this->offset = $input->getOption('offset');
        $this->insert = $input->getOption('insert');
        $this->update = $input->getOption('update');
    }

    /**
     * @return array
     */
    public function findObjects()
    {
        $repository = $this->getEasysysConnectorManager()->getObjectManager()->getRepository($this->getEntityClass());
        if (method_exists($repository, self::REPOSITORY_METHOD_FIND)) {
            $method = self::REPOSITORY_METHOD_FIND;
            return $repository->$method($this->getLimit(), $this->getOffset());
        }

        return $repository->findBy(array(), array('id' => 'ASC'), $this->getLimit(), $this->getOffset());
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $this->initArguments($input, $output);
        $this->initOptions($input);

        $items = $this->findObjects();

        $output->writeln(count($items) . ' items found');

        if (count($items) > 0) {
            foreach ($items as $item) {
                if ($item instanceof ResourceInterface) {
                    if ($this->isUpdate() && $item->getEsId()) {
                        $output->writeln('edit item ' . $item->getEsId() . ' start');

                        /** @var ResourceInterface $data */
                        $data = $this->getEasysysConnectorManager()->get($item->getEsResource())->editData($item);

                        $output->writeln('edit item ' . $item->getEsId() . ' finished');
                    }
                    if ($this->isInsert() && !$item->getEsId()) {
                        $output->writeln('create item ' . $item->getId() . ' start');

                        /** @var ResourceInterface $data */
                        $item = $this->getEasysysConnectorManager()->get($item->getEsResource())->createData($item);

                        $this->getEasysysConnectorManager()->getObjectManager()->flush();

                        $output->writeln('create item ' . $item->getId() . ' finished');
                    }
                }
            }

            $this->getEasysysConnectorManager()->getObjectManager()->flush();
        }
    }
}