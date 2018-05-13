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
        $this->images = Factory::create('\Doamin\Value\Image');
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
        $options = [
            'foo' => $foo,
            'bar' => $bar,
            'amount' => $amount
        ];
        $result = $this->getRepository()->checkSomething($options);

        return $result->getStatus ? self::STATUS_ACCEPTED : self::STATUS_FAILED;
    }

    /**
     * This is testWithManyParameters method description
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
    public function testWithManyParameters(
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

        try{
            switch ($type) {
                case 'basic':
                case 'default':
                    $name = \Tools::generateCorrectName($bar); break;
                default:
                    $name = \Tools::generateCorrectName($name);
            }

            $personCount = $this->repository->countAllPerson($type);

        }catch(\Exception $e){
            
        }



        return $status;
    }


}