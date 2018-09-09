<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductFixture
 *
 */
class ProductFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'product';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'picture' => ['type' => 'string', 'length' => 500, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'price' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'description' => ['type' => 'string', 'length' => 1000, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => '1000-01-01 00:00:00', 'comment' => '', 'precision' => null],
        'updated' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Red Hat',
                'picture' => '7654.jpg',
                'price' => 1.5,
                'description' => 'Lorem ipsum dolor sit amet',
                'created' => '2018-09-07 10:06:50',
                'updated' => '2018-09-07 10:06:50'
            ],
            [
                'id' => 2,
                'name' => 'Rubber Band',
                'picture' => '1234.jpg',
                'price' => 20,
                'description' => 'Red Rubber Band',
                'created' => '2018-09-07 10:06:50',
                'updated' => '2018-09-07 10:06:50'
            ],
            [
                'id' => 3,
                'name' => 'Hello Kitty',
                'picture' => '666.jpg',
                'price' => 5.5,
                'description' => 'This is cute',
                'created' => '2018-09-07 10:06:50',
                'updated' => '2018-09-07 10:06:50'
            ],
            [
                'id' => 4,
                'name' => 'Blue Bag',
                'picture' => '9348.jpg',
                'price' => 25.99,
                'description' => 'Fashionable',
                'created' => '2018-09-07 10:06:50',
                'updated' => '2018-09-07 10:06:50'
            ],
            [
                'id' => 5,
                'name' => 'Paperclips',
                'picture' => '32874.jpg',
                'price' => 1.2,
                'description' => 'Dolor sit amet',
                'created' => '2018-09-07 10:06:50',
                'updated' => '2018-09-07 10:06:50'
            ],
        ];
        parent::init();
    }
}
