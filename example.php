<?php
declare(strict_types=1);

namespace Foo\Bar\Name;

use \Domain\Factory;
use \Domain\Repository;
use \Domain\Value\Image;

/**
 * Class MyClass
 *
 * This is class description
 */
class MyClass extends AbstractAdapter implements AdapterInterface, PriceInterface {

    use PriceTrait;
    use TransformTrait;

    const STATUS_ACCEPTED = 'accepted';
    const STATUS_FAILED = 'failed';
    const TYPE = 'internal';

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Image
     */
    private $image;

    /**
     * @var string
     */
    public $type = null;

    /**
     * MyClass constructor.
     *
     * @param null $type
     */
    public function __construct($type = null){
        $this->repository = $this->setRepository(Factory::create('\Domain\Repository'));
        $this->image = Factory::create('\Domain\Value\Image');
        $this->type = $type;
    }

    /**
     * Return repository
     *
     * @return Repository
     */
    public function getRepository(): Repository {

        return $this->repository;
    }

    /**
     * Set repository
     *
     * @param Repository $repository
     *
     * @return MyClass
     */
    public function setRepository(Repository $repository): self {
        $this->repository = $repository;

        return $this;
    }

    /**
     * This is execute method description
     *
     * @see http://link_to_documentation/example
     *
     * @param string $foo
     * @param string $bar
     * @param int $amount
     *
     * @throws \Domain\Repository\Exception\NotFound
     * @throws \Domain\Repository\Exception\AccountLimit
     *
     * @return bool
     */
    public function execute(string $foo, string $bar, int $amount): bool {

        // More than two keys.
        $options = [
            'foo' => $foo,
            'bar' => $bar,
            'amount' => $amount
        ];
        $result = $this->getRepository()->checkSomething($options);

        return $result->getStatus ? self::STATUS_ACCEPTED : self::STATUS_FAILED;
    }

    /**
     * This is doSomethingWithManyParameters method description
     *
     * @param string $foo
     * @param string $bar
     * @param Config $config
     * @param string $name
     * @param string $type
     * @param string $status
     * @param int $amount
     *
     * @throws \Domain\Repository\Exception\NotFound
     * @throws \Domain\Repository\Exception\AccountLimit
     * @throws \Domain\Value\Exception\Image\CanBeSaved
     * @throws \Exception
     *
     * @return bool
     */
    public function doSomethingWithManyParameters(
        string $foo,
        string $bar,
        Config $config,
        string $name,
        string $type,
        string $status,
        int $amount
    ): bool {

        // This is simple comment.
        if ($config->hasParameter('foo') === $foo) {

            return $status;
        }

        switch ($type) {
            case 'basic':
            case 'default':
                $name = \Tools::generateCorrectName($bar); break;
            default:
                $name = \Tools::generateCorrectName($name);
        }

        try{
            $result = $this->repository->countSomething($name, $type);
        }catch(\Domain\Repository\Exception\Count $e){
            $this->logger->info('Repo can\'t count something important', ['name' => $name, 'type' => $type]);
            $result = 0;
        }

        return $amount < $result;
    }

    /**
     * Set something
     *
     * @param string $foo
     * @param string $bar
     * @param string $rad
     * @param string $fad
     *
     * @return Image
     */
    public function setSomethingUsingChaining(string $foo, string $bar, string $rad, string $fad): Image {
        $this->image
            ->setFoo($foo)
            ->setBar($bar)
            ->setRad($rad)
            ->setFad($fad)
            ->setStatuses([self::STATUS_FAILED, self::STATUS_ACCEPTED])
        ;

        return $this->image;
    }

    /**
     * Loop something
     *
     * @param int|null $limit
     *
     * @return array
     */
    public function loopSomething(int $limit = null){
        if ($limit === null) {
            $limit = $this->getRepository()->countLimit();
        }

        $result = [];
        for ($i=0; $i<$limit; $i++) {
            $result[$i] = $this->getRepository()->doSomething($i);
        }

        return $result;
    }

    /**
     * Method description
     *
     * Here's an example of how to format examples:
     * <code>
     *
     * $this->>callSomething([
     *  'test' => 'Test',
     *  'test2' => 'Test2'
     *  'test3' => 'Test3'
     * ]);
     *
     * </code>
     *
     * Here is an example for non-php example or sample:
     * <samp>
     *
     *   pear install net_sample
     *
     * </samp>
     *
     * @param array $options
     *
     * @return null|string
     */
    public function callSomething(array $options): ?string {
        $options['type'] = self::TYPE;

        return parent::callSomething($options);
    }

}