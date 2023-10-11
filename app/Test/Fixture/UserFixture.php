<?php
/**
 * User Fixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'key' => 'unique', 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'photo_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'birthdate' => array('type' => 'date', 'null' => true, 'default' => null),
		'gender' => array('type' => 'enum(\'M\',\'F\')', 'null' => true, 'default' => 'M', 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'hobby' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'last_login_at' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor ',
			'email' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor ',
			'photo_url' => 'Lorem ipsum dolor sit amet',
			'birthdate' => '2023-10-11',
			'gender' => '',
			'hobby' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'last_login_at' => '2023-10-11 05:36:29',
			'created' => 1696995389,
			'modified' => 1696995389
		),
	);

}
