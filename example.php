<?php
declare(strict_types=1);

namespace Foo\Bar\Name;

/**
 * Class MyClass
 *
 * This is class description
 */
class MyClass extends \Foo\Bar\Name\AbstractAdapter implements
    \Foo\Bar\Name\AdapterInterface,
    \Foo\Bar\Name\PriceInterface,
    \Foo\Bar\Name\MemoryInterface,
    \Foo\Bar\Name\ABCInterface {

    // Traits:

    use \Foo\Bar\Name\PriceTrait;
    use \Foo\Bar\Name\TransformTrait;

    // Constants:

    public const STATUS_ACCEPTED = 'accepted';
    protected const STATUS_FAILED = 'failed';
    private const TYPE = 'internal';


    // Static properties:

    public static $countries = [
        'pl' => 'Poland',
        'dk' => 'Denmark'
    ];

    protected static $helpers = [
        \Foo\Bar\Name\Helper\HelperA::class,
        \Foo\Bar\Name\Helper\HelperB::class,
        \Foo\Bar\Name\Helper\HelperC::class,
    ];

    private static $strategies = ['First', 'Second'];

    // Properties:

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var \Foo\Bar\Domain\Repository
     */
    protected $repository;

    /**
     * @var \Foo\Bar\Domain\Value\Image
     */
    private $image;

    // Abstract static methods:

    /**
     * Return class version
     *
     * @see \Foo\Bar\Name\AbstractAdapter
     *
     * @return string
     */
    public static function getVersion(): string {
        return '0.0.1';
    }

    // Abstract methods:

    /**
     * Return Adapter
     *
     * @see \Foo\Bar\Name\AbstractAdapter
     *
     * @return \Foo\Bar\Name\Adapter\BasicInterface
     */
    public function getAdapter(): \Foo\Bar\Name\Adapter\BasicInterface {
        if (!is_null($this->adapter)) {
            return $this->adapter;
        }

        $this->adapter = \Foo\Bar\Name\AdapterFactory::create('\Adapter\\'.$this->getType());

        return $this->adapter;
    }


    // Magic methods:

    /**
     * MyClass constructor.
     *
     * @param null $type
     */
    public function __construct($type = null) {
        $this->repository = $this->setRepository(\Foo\Bar\Name\RepositoryFactory::create('\Domain\Repository'));
        $this->image = \Foo\Bar\Name\ValueFactory::create('\Domain\Value\Image');
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return implode(',', self::$countries);
    }

    // Static methods:

    /**
     * Get yesterday date
     *
     * @return string
     */
    public static function getYesterday(): string {
        return date('Y-m-d', strtotime("-1 days"));
    }

    /**
     * Get current date
     *
     * @return string
     */
    protected static function getNow(): string {
        return date('Y-m-d');
    }

    /**
     * Get tomorrow date
     *
     * @return string
     */
    private static function getTomorrow(): string {
        return date('Y-m-d', strtotime("+1 days"));
    }

    // Class methods (public, protected, private)

    /**
     * This is execute method description
     *
     * @param \Foo\Bar\This\Is\Some\Exmaple\Foo $foo
     * @param \Foo\Bar\This\Is\Some\Exmaple\Bar $bar
     * @param int|null $amount
     *
     * @throws \Domain\Repository\Exception\NotFoundException
     * @throws \Domain\Repository\Exception\AccountLimitException
     *
     * @return string
     */
    public function execute(\Foo\Bar\This\Is\Some\Exmaple\Foo $foo, \Foo\Bar\This\Is\Some\Exmaple\Bar $bar, int $amount = null): string {
        $simpleArrayWithCountries = ['Poland','Denmark'];

        // Array with more than two keys.
        $options = [
            'foo' => $foo,
            'bar' => $bar,
            'amount' => $amount,
            'countries' => $simpleArrayWithCountries
        ];

        $image = $this->setSomethingUsingChaining(
            [
                $amount,
                self::$strategies,
                \Foo\Bar\Domain\Value\Image::$extensions
            ],
            \Foo\Bar\Test::THIS_IS_TEST,
            $this->getType()
        );
        $result = $this->getRepository()->checkSomething($image, $options);

        return $result->getStatus ? self::STATUS_ACCEPTED : self::STATUS_FAILED;
    }

    /**
     * Loop something
     *
     * @param string $type
     * @param int|null $limit
     *
     * @return bool
     */
    public function loopSomething(string $type, int $limit = null): bool {
        $result = [];
        for ($i=0; $i<$limit; $i++) {
            $result[$i] = $this->getRepository()->doSomething($i);
        }

        switch ($type) {
            case 'A' :
                $name = 'Algeria';
                break;
            case 'B' :
                $name = 'Belgium';
                break;
            case 'C' :
                $name = 'Czech Republic';
                break;
            default:
                $name = 'Poland';
        }

        return in_array($name, $result);
    }

    /**
     * This is doSomethingWithManyParameters method description
     *
     * @param string $foo
     * @param string $bar
     * @param \Foo\Bar\Config $config
     * @param string $name
     * @param string $type
     * @param string $status
     * @param int $amount
     *
     * @throws \Foo\Bar\Domain\Repository\Exception\NotFoundException
     * @throws \Foo\Bar\Domain\Repository\Exception\AccountLimitException
     * @throws \Foo\Bar\Domain\Value\Exception\Image\CanBeSavedException
     * @throws \Exception
     *
     * @return bool
     */
    protected function doSomethingWithManyParameters(
        string $foo,
        string $bar,
        \Foo\Bar\Config $config,
        string $name,
        string $type,
        string $strategyName,
        int $amount
    ): bool {

        // Very long if statement.
        if (
            $foo === 'test'
            && $bar === 'superTest'
            && (
                $name === 'Bob'
                || $type === self::getType()
                || (
                    $amount >= 10
                    && $amount < 100
                )
                || in_array($strategyName, self::$strategies)
            )
        ) {
            return STATUS_ACCEPTED;
        }else{
            return STATUS_FAILED;
        }
    }

    /**
     * Set something
     *
     * @param array $options
     * @param string $bar
     * @param string $rad
     * @param string|null $fad
     *
     * @return Image
     */
    private function setSomethingUsingChaining(array $options, string $bar, string $rad, string $fad = null): Image {

        // We can chain the methods until we have the same object on response.
        return $this->image
            ->setOptions($options)
            ->setBar($bar)
            ->setRad($rad)
            ->setFad($fad)
            ->setStatuses([self::STATUS_FAILED, self::STATUS_ACCEPTED]);
    }

    // Setters and getters

    /**
     * @param string $type
     *
     * @return MyClass
     */
    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    /**
     * Return type
     *
     * @return string
     */
    public function getType(): ?string {
        return $this->type;
    }

    /**
     * @param string $name
     *
     * @return MyClass
     */
    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    /**
     * Return name
     *
     * @return string
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Return repository
     *
     * @return \Foo\Bar\Domain\Repository
     */
    public function getRepository(): ?\Foo\Bar\Domain\Repository {
        return $this->repository;
    }

    /**
     * Set repository
     *
     * @param \Foo\Bar\Domain\Repository $repository
     *
     * @return MyClass
     */
    public function setRepository(\Foo\Bar\Domain\Repository $repository): self {
        $this->repository = $repository;

        return $this;
    }
}